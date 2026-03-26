<?php

namespace App\Http\Controllers;

use App\Models\CardTag;
use App\Models\Folder;
use App\Models\SavedCard;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactImportExportController extends Controller
{
    private const CSV_HEADERS = ['full_name', 'email', 'phone', 'company_name', 'job_title', 'website', 'relationship_status', 'folder', 'tags', 'notes', 'last_contacted_at'];

    public function export(Request $request): StreamedResponse
    {
        $user = $request->user();
        $query = $user->savedCards()->with(['businessCard', 'tags', 'folder']);

        // Respect current filters (same logic as SavedCardController@index)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%")
                    ->orWhere('custom_note', 'like', "%{$search}%")
                    ->orWhereHas('businessCard', function ($bq) use ($search) {
                        $bq->where('full_name', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%")
                            ->orWhere('job_title', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($folderId = $request->input('folder')) {
            $query->where('folder_id', $folderId);
        }

        if ($tagId = $request->input('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('card_tags.id', $tagId));
        }

        if ($status = $request->input('status')) {
            $query->where('relationship_status', $status);
        }

        $contacts = $query->get();

        $filename = 'contacts_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($contacts) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, self::CSV_HEADERS);

            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->getFullName(),
                    $contact->getEmail(),
                    $contact->getPhone(),
                    $contact->getCompanyName(),
                    $contact->getJobTitle(),
                    $contact->getWebsite(),
                    $contact->relationship_status,
                    $contact->folder?->name,
                    $contact->tags->pluck('name')->implode('|'),
                    $contact->custom_note,
                    $contact->last_contacted_at?->toDateTimeString(),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function import(Request $request): View
    {
        return view('contacts.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        if ($handle === false) {
            return back()->with('error', 'Could not read the uploaded file.');
        }

        $headers = fgetcsv($handle);

        if ($headers === false) {
            fclose($handle);
            return back()->with('error', 'The CSV file appears to be empty.');
        }

        // Normalize headers (trim whitespace, lowercase)
        $headers = array_map(fn ($h) => strtolower(trim($h)), $headers);

        // Validate required columns
        $requiredColumns = ['full_name'];
        $missingColumns = array_diff($requiredColumns, $headers);
        if (!empty($missingColumns)) {
            fclose($handle);
            return back()->with('error', 'Missing required columns: ' . implode(', ', $missingColumns) . '. Download the sample template for the correct format.');
        }

        $user = $request->user();
        $created = 0;
        $skipped = 0;
        $errors = 0;
        $rowNum = 1;
        $maxRows = 500;

        while (($row = fgetcsv($handle)) !== false && $rowNum <= $maxRows) {
            $rowNum++;

            // Map columns to values
            $data = [];
            foreach ($headers as $index => $header) {
                $data[$header] = $row[$index] ?? null;
            }

            // Skip rows without a name
            $fullName = trim($data['full_name'] ?? '');
            if (empty($fullName)) {
                $errors++;
                continue;
            }

            // Skip duplicates by email
            $email = trim($data['email'] ?? '');
            if ($email) {
                $existsByEmail = $user->savedCards()
                    ->where(function ($q) use ($email) {
                        $q->where('email', $email)
                            ->orWhereHas('businessCard', fn ($bq) => $bq->where('email', $email));
                    })
                    ->exists();

                if ($existsByEmail) {
                    $skipped++;
                    continue;
                }
            }

            // Resolve folder
            $folderId = null;
            $folderName = trim($data['folder'] ?? '');
            if ($folderName) {
                $folder = $user->folders()->firstOrCreate(['name' => $folderName]);
                $folderId = $folder->id;
            }

            // Validate relationship status
            $status = trim($data['relationship_status'] ?? '');
            $validStatuses = ['lead', 'prospect', 'client', 'partner', 'other'];
            $relationshipStatus = in_array($status, $validStatuses) ? $status : null;

            // Parse last_contacted_at
            $lastContactedAt = null;
            $lastContactedRaw = trim($data['last_contacted_at'] ?? '');
            if ($lastContactedRaw) {
                try {
                    $lastContactedAt = \Carbon\Carbon::parse($lastContactedRaw);
                } catch (\Exception $e) {
                    // Ignore invalid dates
                }
            }

            // Validate website
            $website = trim($data['website'] ?? '');
            if ($website && !filter_var($website, FILTER_VALIDATE_URL)) {
                $website = null;
            }

            try {
                $contact = $user->savedCards()->create([
                    'full_name' => $fullName,
                    'email' => $email ?: null,
                    'phone' => trim($data['phone'] ?? '') ?: null,
                    'company_name' => trim($data['company_name'] ?? '') ?: null,
                    'job_title' => trim($data['job_title'] ?? '') ?: null,
                    'website' => $website ?: null,
                    'relationship_status' => $relationshipStatus,
                    'folder_id' => $folderId,
                    'custom_note' => trim($data['notes'] ?? '') ?: null,
                    'last_contacted_at' => $lastContactedAt,
                ]);

                // Resolve tags
                $tagsRaw = trim($data['tags'] ?? '');
                if ($tagsRaw) {
                    $tagNames = array_filter(array_map('trim', explode('|', $tagsRaw)));
                    $tagIds = [];
                    foreach ($tagNames as $tagName) {
                        $tag = $user->tags()->firstOrCreate(['name' => $tagName]);
                        $tagIds[] = $tag->id;
                    }
                    if (!empty($tagIds)) {
                        $contact->tags()->attach($tagIds);
                    }
                }

                $created++;
            } catch (\Exception $e) {
                $errors++;
            }
        }

        fclose($handle);

        return redirect()->route('contacts.import')
            ->with('import_results', [
                'created' => $created,
                'skipped' => $skipped,
                'errors' => $errors,
            ]);
    }

    public function sampleCsv(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, self::CSV_HEADERS);
            fputcsv($handle, [
                'Jane Smith',
                'jane@example.com',
                '+1 555-0100',
                'Acme Corp',
                'Marketing Director',
                'https://acme.com',
                'client',
                'VIP',
                'design|marketing',
                'Met at conference 2024',
                '2024-12-15 10:00:00',
            ]);
            fclose($handle);
        }, 'contacts_sample.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
