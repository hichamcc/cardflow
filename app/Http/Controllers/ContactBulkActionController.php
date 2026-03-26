<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactBulkActionController extends Controller
{
    public function move(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
            'folder_id' => 'nullable|exists:folders,id',
        ]);

        $request->user()->savedCards()
            ->whereIn('id', $validated['ids'])
            ->update(['folder_id' => $validated['folder_id']]);

        return back()->with('success', __('Contacts moved successfully.'));
    }

    public function tag(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
            'tag_id' => 'required|exists:card_tags,id',
        ]);

        $contacts = $request->user()->savedCards()
            ->whereIn('id', $validated['ids'])
            ->get();

        foreach ($contacts as $contact) {
            $contact->tags()->syncWithoutDetaching([$validated['tag_id']]);
        }

        return back()->with('success', __('Tag added to selected contacts.'));
    }

    public function status(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
            'relationship_status' => 'required|in:lead,prospect,client,partner,other',
        ]);

        $request->user()->savedCards()
            ->whereIn('id', $validated['ids'])
            ->update(['relationship_status' => $validated['relationship_status']]);

        return back()->with('success', __('Status updated for selected contacts.'));
    }

    public function export(Request $request): StreamedResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $contacts = $request->user()->savedCards()
            ->with(['businessCard', 'tags', 'folder'])
            ->whereIn('id', $validated['ids'])
            ->get();

        $filename = 'contacts_selected_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($contacts) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['full_name', 'email', 'phone', 'company_name', 'job_title', 'website', 'relationship_status', 'folder', 'tags', 'notes', 'last_contacted_at']);

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

    public function destroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $deleted = $request->user()->savedCards()
            ->whereIn('id', $validated['ids'])
            ->delete();

        return back()->with('success', __(':count contacts deleted.', ['count' => $deleted]));
    }
}
