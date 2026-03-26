<?php

namespace App\Http\Controllers;

use App\Models\CardTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(Request $request): View
    {
        $tags = $request->user()
            ->tags()
            ->withCount('savedCards')
            ->orderBy('name')
            ->get();

        return view('tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('tags.create');
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $tag = $request->user()->tags()->create($validated);

        if ($request->wantsJson()) {
            return response()->json($tag);
        }

        return to_route('tags.index')->with('success', 'Tag created.');
    }

    public function edit(Request $request, CardTag $tag): View
    {
        abort_unless($tag->user_id === $request->user()->id, 403);

        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, CardTag $tag): RedirectResponse
    {
        abort_unless($tag->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $tag->update($validated);

        return to_route('tags.index')->with('success', 'Tag updated.');
    }

    public function destroy(Request $request, CardTag $tag): RedirectResponse
    {
        abort_unless($tag->user_id === $request->user()->id, 403);

        $tag->savedCards()->detach();
        $tag->delete();

        return to_route('tags.index')->with('success', 'Tag deleted.');
    }
}
