<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\SavedCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FollowUpController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $overdue = $user->followUps()
            ->with('savedCard.businessCard')
            ->where('status', 'pending')
            ->where('follow_up_date', '<', today())
            ->orderBy('follow_up_date')
            ->get();

        $today = $user->followUps()
            ->with('savedCard.businessCard')
            ->where('status', 'pending')
            ->whereDate('follow_up_date', today())
            ->get();

        $upcoming = $user->followUps()
            ->with('savedCard.businessCard')
            ->where('status', 'pending')
            ->where('follow_up_date', '>', today())
            ->orderBy('follow_up_date')
            ->take(20)
            ->get();

        $completed = $user->followUps()
            ->with('savedCard.businessCard')
            ->where('status', 'completed')
            ->latest('updated_at')
            ->take(10)
            ->get();

        $contacts = $user->savedCards()
            ->with('businessCard')
            ->orderBy('full_name')
            ->get()
            ->map(fn ($c) => ['id' => $c->id, 'name' => $c->getFullName() ?: 'Unnamed']);

        return view('follow-ups.index', compact('overdue', 'today', 'upcoming', 'completed', 'contacts'));
    }

    public function store(Request $request, SavedCard $contact): RedirectResponse
    {
        abort_unless($contact->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'follow_up_date' => 'required|date|after_or_equal:today',
            'reminder_date' => 'nullable|date|before_or_equal:follow_up_date',
            'notes' => 'nullable|string|max:2000',
        ]);

        $validated['user_id'] = $request->user()->id;

        $contact->followUps()->create($validated);

        return back()->with('success', 'Follow-up scheduled.');
    }

    public function complete(Request $request, FollowUp $followUp): RedirectResponse
    {
        abort_unless($followUp->user_id === $request->user()->id, 403);

        $followUp->markCompleted();

        return back()->with('success', 'Follow-up marked as completed.');
    }

    public function cancel(Request $request, FollowUp $followUp): RedirectResponse
    {
        abort_unless($followUp->user_id === $request->user()->id, 403);

        $followUp->markCancelled();

        return back()->with('success', 'Follow-up cancelled.');
    }

    public function destroy(Request $request, FollowUp $followUp): RedirectResponse
    {
        abort_unless($followUp->user_id === $request->user()->id, 403);

        $followUp->delete();

        return back()->with('success', 'Follow-up deleted.');
    }
}
