<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = $user->notes()->with('savedCard')->latest();

        if ($request->filled('category')) {
            $query->category($request->input('category'));
        }

        if ($request->boolean('pinned')) {
            $query->pinned();
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Show pinned first, then by latest
        $query->reorder()->orderByDesc('is_pinned')->latest();

        $notes = $query->paginate(20)->withQueryString();

        return view('notes.index', compact('notes'));
    }

    public function create(Request $request): View
    {
        $contacts = $request->user()->savedCards()->get()->map(fn ($c) => [
            'id' => $c->id,
            'name' => $c->getFullName(),
        ]);

        return view('notes.create', compact('contacts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|max:10000',
            'category' => 'required|in:general,meeting,idea,todo',
            'saved_card_id' => 'nullable|exists:saved_cards,id',
            'is_pinned' => 'boolean',
        ]);

        $validated['is_pinned'] = $request->boolean('is_pinned');

        $note = $request->user()->notes()->create($validated);

        return to_route('notes.show', $note)->with('success', 'Note created successfully.');
    }

    public function show(Request $request, Note $note): View
    {
        abort_unless($note->user_id === $request->user()->id, 403);

        $note->load('savedCard');

        return view('notes.show', compact('note'));
    }

    public function edit(Request $request, Note $note): View
    {
        abort_unless($note->user_id === $request->user()->id, 403);

        $contacts = $request->user()->savedCards()->get()->map(fn ($c) => [
            'id' => $c->id,
            'name' => $c->getFullName(),
        ]);

        return view('notes.edit', compact('note', 'contacts'));
    }

    public function update(Request $request, Note $note): RedirectResponse
    {
        abort_unless($note->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|max:10000',
            'category' => 'required|in:general,meeting,idea,todo',
            'saved_card_id' => 'nullable|exists:saved_cards,id',
            'is_pinned' => 'boolean',
        ]);

        $validated['is_pinned'] = $request->boolean('is_pinned');

        $note->update($validated);

        return to_route('notes.show', $note)->with('success', 'Note updated successfully.');
    }

    public function destroy(Request $request, Note $note): RedirectResponse
    {
        abort_unless($note->user_id === $request->user()->id, 403);

        $note->delete();

        return to_route('notes.index')->with('success', 'Note deleted.');
    }

    public function togglePin(Request $request, Note $note): RedirectResponse
    {
        abort_unless($note->user_id === $request->user()->id, 403);

        $note->togglePin();

        return back()->with('success', $note->is_pinned ? 'Note pinned.' : 'Note unpinned.');
    }
}
