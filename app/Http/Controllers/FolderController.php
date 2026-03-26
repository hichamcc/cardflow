<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FolderController extends Controller
{
    public function index(Request $request): View
    {
        $folders = $request->user()
            ->folders()
            ->withCount('savedCards')
            ->orderBy('name')
            ->get();

        return view('folders.index', compact('folders'));
    }

    public function create(): View
    {
        return view('folders.create');
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
        ]);

        $folder = $request->user()->folders()->create($validated);

        if ($request->wantsJson()) {
            return response()->json($folder);
        }

        return to_route('folders.index')->with('success', 'Folder created.');
    }

    public function edit(Request $request, Folder $folder): View
    {
        abort_unless($folder->user_id === $request->user()->id, 403);

        return view('folders.edit', compact('folder'));
    }

    public function update(Request $request, Folder $folder): RedirectResponse
    {
        abort_unless($folder->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
        ]);

        $folder->update($validated);

        return to_route('folders.index')->with('success', 'Folder updated.');
    }

    public function destroy(Request $request, Folder $folder): RedirectResponse
    {
        abort_unless($folder->user_id === $request->user()->id, 403);

        // Move contacts out of folder before deleting
        $folder->savedCards()->update(['folder_id' => null]);
        $folder->delete();

        return to_route('folders.index')->with('success', 'Folder deleted.');
    }
}
