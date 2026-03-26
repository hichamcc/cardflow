<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $view = $request->input('view', 'calendar');

        $overdue = $user->events()->with('savedCard')->overdue()->orderBy('start_at')->get();
        $today = $user->events()->with('savedCard')->today()->scheduled()->orderBy('start_at')->get();
        $upcoming = $user->events()->with('savedCard')->upcoming()->where('start_at', '>', today()->endOfDay())->orderBy('start_at')->take(20)->get();

        return view('calendar.index', compact('view', 'overdue', 'today', 'upcoming'));
    }

    public function create(Request $request): View
    {
        $contacts = $request->user()->savedCards()->get()->map(fn ($c) => [
            'id' => $c->id,
            'name' => $c->getFullName(),
        ]);

        return view('events.create', compact('contacts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:meeting,call,task,reminder,other',
            'saved_card_id' => 'nullable|exists:saved_cards,id',
            'color' => 'nullable|string|max:7',
        ]);

        $event = $request->user()->events()->create($validated);

        return to_route('events.show', $event)->with('success', 'Event created successfully.');
    }

    public function show(Request $request, Event $event): View
    {
        abort_unless($event->user_id === $request->user()->id, 403);

        $event->load('savedCard');

        return view('events.show', compact('event'));
    }

    public function edit(Request $request, Event $event): View
    {
        abort_unless($event->user_id === $request->user()->id, 403);

        $contacts = $request->user()->savedCards()->get()->map(fn ($c) => [
            'id' => $c->id,
            'name' => $c->getFullName(),
        ]);

        return view('events.edit', compact('event', 'contacts'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        abort_unless($event->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'location' => 'nullable|string|max:255',
            'type' => 'required|in:meeting,call,task,reminder,other',
            'saved_card_id' => 'nullable|exists:saved_cards,id',
            'color' => 'nullable|string|max:7',
        ]);

        $event->update($validated);

        return to_route('events.show', $event)->with('success', 'Event updated successfully.');
    }

    public function destroy(Request $request, Event $event): RedirectResponse
    {
        abort_unless($event->user_id === $request->user()->id, 403);

        $event->delete();

        return to_route('calendar.index')->with('success', 'Event deleted.');
    }

    public function complete(Request $request, Event $event): RedirectResponse
    {
        abort_unless($event->user_id === $request->user()->id, 403);

        $event->markCompleted();

        return back()->with('success', 'Event marked as completed.');
    }

    public function cancel(Request $request, Event $event): RedirectResponse
    {
        abort_unless($event->user_id === $request->user()->id, 403);

        $event->markCancelled();

        return back()->with('success', 'Event cancelled.');
    }

    public function apiEvents(Request $request): JsonResponse
    {
        $user = $request->user();

        $start = $request->input('start', now()->startOfMonth()->toDateString());
        $end = $request->input('end', now()->endOfMonth()->toDateString());

        $events = $user->events()
            ->with('savedCard')
            ->between($start, $end)
            ->get()
            ->map(fn (Event $event) => [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_at->toIso8601String(),
                'end' => $event->end_at->toIso8601String(),
                'type' => $event->type,
                'status' => $event->status,
                'color' => $event->color ?? match ($event->type) {
                    'meeting' => '#3B82F6',
                    'call' => '#10B981',
                    'task' => '#8B5CF6',
                    'reminder' => '#F59E0B',
                    default => '#6B7280',
                },
                'url' => route('events.show', $event),
                'contact' => $event->savedCard ? $event->savedCard->getFullName() : null,
            ]);

        return response()->json($events);
    }
}
