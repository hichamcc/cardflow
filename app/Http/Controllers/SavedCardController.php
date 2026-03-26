<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\Folder;
use App\Models\SavedCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SavedCardController extends Controller
{
    public function index(Request $request, ?Folder $folder = null): View
    {
        $user = $request->user();
        $query = $user->savedCards()->with(['businessCard.user', 'tags', 'folder']);

        // Search — handle both linked and manual contacts
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                // Search manual client fields
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('job_title', 'like', "%{$search}%")
                    ->orWhere('custom_note', 'like', "%{$search}%")
                    // Search linked card fields
                    ->orWhereHas('businessCard', function ($bq) use ($search) {
                        $bq->where('full_name', 'like', "%{$search}%")
                            ->orWhere('company_name', 'like', "%{$search}%")
                            ->orWhere('job_title', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by folder
        if ($folder) {
            $query->where('folder_id', $folder->id);
        } elseif ($folderId = $request->input('folder')) {
            $query->where('folder_id', $folderId);
        }

        // Filter by tag
        if ($tagId = $request->input('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('card_tags.id', $tagId));
        }

        // Filter by type (saved cards vs manual contacts)
        if ($type = $request->input('type')) {
            if ($type === 'saved') {
                $query->whereNotNull('business_card_id');
            } elseif ($type === 'manual') {
                $query->whereNull('business_card_id');
            }
        }

        // Filter by relationship status
        if ($status = $request->input('status')) {
            $query->where('relationship_status', $status);
        }

        // Sort
        $sort = $request->input('sort', 'latest');
        $query = match ($sort) {
            'name' => $query->orderByRaw("COALESCE(saved_cards.full_name, (SELECT full_name FROM business_cards WHERE business_cards.id = saved_cards.business_card_id)) ASC"),
            'company' => $query->orderByRaw("COALESCE(saved_cards.company_name, (SELECT company_name FROM business_cards WHERE business_cards.id = saved_cards.business_card_id)) ASC"),
            'last_contacted' => $query->orderByDesc('last_contacted_at'),
            default => $query->latest(),
        };

        $contacts = $query->paginate(20)->withQueryString();
        $folders = $user->folders()->withCount('savedCards')->get();
        $tags = $user->tags()->get();

        return view('contacts.index', compact('contacts', 'folders', 'tags', 'folder'));
    }

    public function create(Request $request): View
    {
        $folders = $request->user()->folders()->get();
        $tags = $request->user()->tags()->get();

        return view('contacts.create', compact('folders', 'tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'profile_photo' => 'nullable|image|max:2048',
            'folder_id' => 'nullable|exists:folders,id',
            'relationship_status' => 'nullable|in:lead,prospect,client,partner,other',
            'contact_frequency' => 'nullable|in:never,low,medium,high',
            'custom_note' => 'nullable|string|max:2000',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:card_tags,id',
        ]);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo_path'] = $request->file('profile_photo')->store('contacts', 'public');
        }
        unset($validated['profile_photo'], $validated['tags']);

        $contact = $request->user()->savedCards()->create($validated);

        if ($request->has('tags')) {
            $contact->tags()->attach($request->input('tags'));
        }

        return to_route('contacts.show', $contact)->with('success', 'Contact created successfully.');
    }

    public function show(Request $request, SavedCard $contact): View
    {
        abort_unless($contact->user_id === $request->user()->id, 403);

        $contact->load([
            'businessCard.socialLinks',
            'businessCard.customFields',
            'tags',
            'folder',
            'interactions' => fn ($q) => $q->latest('interaction_date'),
            'followUps' => fn ($q) => $q->orderBy('follow_up_date'),
            'deals',
            'notes' => fn ($q) => $q->latest(),
            'events' => fn ($q) => $q->where('status', 'scheduled')->orderBy('start_at')->take(5),
        ]);

        // Build unified activity timeline
        $timeline = collect()
            ->merge($contact->interactions->map(fn ($i) => ['type' => 'interaction', 'date' => $i->interaction_date, 'item' => $i]))
            ->merge($contact->followUps->map(fn ($f) => ['type' => 'follow_up', 'date' => $f->follow_up_date, 'item' => $f]))
            ->merge($contact->deals->map(fn ($d) => ['type' => 'deal', 'date' => $d->created_at, 'item' => $d]))
            ->merge($contact->notes->map(fn ($n) => ['type' => 'note', 'date' => $n->created_at, 'item' => $n]))
            ->sortByDesc('date')
            ->take(20)
            ->values();

        $folders = $request->user()->folders()->get();
        $tags = $request->user()->tags()->get();

        return view('contacts.show', compact('contact', 'folders', 'tags', 'timeline'));
    }

    public function edit(Request $request, SavedCard $contact): View
    {
        abort_unless($contact->user_id === $request->user()->id, 403);
        abort_unless($contact->isManualClient(), 404);

        $contact->load(['tags']);
        $folders = $request->user()->folders()->get();
        $tags = $request->user()->tags()->get();

        return view('contacts.edit', compact('contact', 'folders', 'tags'));
    }

    public function update(Request $request, SavedCard $contact): RedirectResponse
    {
        abort_unless($contact->user_id === $request->user()->id, 403);

        $rules = [
            'custom_note' => 'nullable|string|max:2000',
            'folder_id' => 'nullable|exists:folders,id',
            'contact_frequency' => 'nullable|in:never,low,medium,high',
            'relationship_status' => 'nullable|in:lead,prospect,client,partner,other',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:card_tags,id',
        ];

        // Allow editing direct fields for manual clients
        if ($contact->isManualClient()) {
            $rules = array_merge($rules, [
                'full_name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:50',
                'company_name' => 'nullable|string|max:255',
                'job_title' => 'nullable|string|max:255',
                'website' => 'nullable|url|max:255',
                'profile_photo' => 'nullable|image|max:2048',
            ]);
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo_path'] = $request->file('profile_photo')->store('contacts', 'public');
        }
        unset($validated['profile_photo']);

        $contact->update(collect($validated)->except('tags')->toArray());

        if (isset($validated['tags'])) {
            $contact->tags()->sync($validated['tags']);
        }

        return back()->with('success', 'Contact updated successfully.');
    }

    public function destroy(Request $request, SavedCard $contact): RedirectResponse
    {
        abort_unless($contact->user_id === $request->user()->id, 403);

        $contact->delete();

        return to_route('contacts.index')->with('success', 'Contact removed.');
    }

    public function saveFromPublic(Request $request, string $slug): RedirectResponse
    {
        $card = BusinessCard::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $user = $request->user();

        if ($card->user_id === $user->id) {
            return back()->with('error', 'You cannot save your own card.');
        }

        $existing = $user->savedCards()->where('business_card_id', $card->id)->first();
        if ($existing) {
            return to_route('contacts.show', $existing)->with('info', 'You already saved this card.');
        }

        $savedCard = $user->savedCards()->create([
            'business_card_id' => $card->id,
            'saved_from_user_id' => $card->user_id,
        ]);

        return to_route('contacts.show', $savedCard)->with('success', 'Card saved to your contacts!');
    }

    public function move(Request $request, SavedCard $contact): RedirectResponse
    {
        abort_unless($contact->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'folder_id' => 'nullable|exists:folders,id',
        ]);

        $contact->update($validated);

        return back()->with('success', 'Contact moved successfully.');
    }
}
