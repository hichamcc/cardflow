<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = $user->projects()->with('savedCard', 'tasks')->latest();

        if ($request->filled('status')) {
            $query->status($request->input('status'));
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->paginate(12)->withQueryString();

        return view('projects.index', compact('projects'));
    }

    public function create(Request $request): View
    {
        $contacts = $request->user()->savedCards()->get()->map(fn ($c) => [
            'id' => $c->id,
            'name' => $c->getFullName(),
        ]);

        return view('projects.create', compact('contacts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'status' => 'required|in:active,completed,on_hold',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'saved_card_id' => 'nullable|exists:saved_cards,id',
        ]);

        $project = $request->user()->projects()->create($validated);

        return to_route('projects.show', $project)->with('success', 'Project created successfully.');
    }

    public function show(Request $request, Project $project): View
    {
        abort_unless($project->user_id === $request->user()->id, 403);

        $project->load(['savedCard', 'tasks']);

        return view('projects.show', compact('project'));
    }

    public function edit(Request $request, Project $project): View
    {
        abort_unless($project->user_id === $request->user()->id, 403);

        $contacts = $request->user()->savedCards()->get()->map(fn ($c) => [
            'id' => $c->id,
            'name' => $c->getFullName(),
        ]);

        return view('projects.edit', compact('project', 'contacts'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        abort_unless($project->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'status' => 'required|in:active,completed,on_hold',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'saved_card_id' => 'nullable|exists:saved_cards,id',
        ]);

        $project->update($validated);

        return to_route('projects.show', $project)->with('success', 'Project updated successfully.');
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        abort_unless($project->user_id === $request->user()->id, 403);

        $project->delete();

        return to_route('projects.index')->with('success', 'Project deleted.');
    }

    // --- Task Actions ---

    public function storeTask(Request $request, Project $project): RedirectResponse
    {
        abort_unless($project->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $maxPosition = $project->tasks()->max('position') ?? 0;

        $project->tasks()->create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'position' => $maxPosition + 1,
        ]);

        return back()->with('success', 'Task added.');
    }

    public function toggleTask(Request $request, Task $task): RedirectResponse
    {
        abort_unless($task->project->user_id === $request->user()->id, 403);

        $task->update(['is_completed' => !$task->is_completed]);

        return back()->with('success', $task->is_completed ? 'Task completed.' : 'Task reopened.');
    }

    public function destroyTask(Request $request, Task $task): RedirectResponse
    {
        abort_unless($task->project->user_id === $request->user()->id, 403);

        $task->delete();

        return back()->with('success', 'Task removed.');
    }
}
