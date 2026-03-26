<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\SavedCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function store(Request $request, SavedCard $contact): RedirectResponse
    {
        abort_unless($contact->user_id === $request->user()->id, 403);

        $user = $request->user();

        // Check interaction limit for free tier
        if ($user->isFree()) {
            $monthlyCount = $user->interactions()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            if ($monthlyCount >= $user->monthlyInteractionLimit()) {
                return back()->with('error', 'Monthly interaction limit reached. Upgrade to Pro for unlimited interactions.');
            }
        }

        $validated = $request->validate([
            'interaction_type' => 'required|in:email,call,meeting,note',
            'subject' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
            'interaction_date' => 'required|date',
        ]);

        $validated['user_id'] = $user->id;

        $contact->interactions()->create($validated);
        $contact->markContacted();

        return back()->with('success', 'Interaction logged.');
    }

    public function destroy(Request $request, Interaction $interaction): RedirectResponse
    {
        abort_unless($interaction->user_id === $request->user()->id, 403);

        $interaction->delete();

        return back()->with('success', 'Interaction removed.');
    }
}
