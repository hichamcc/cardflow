<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealController extends Controller
{
    public function index(Request $request): View
    {
        $deals = $request->user()
            ->deals()
            ->with('savedCard')
            ->latest()
            ->get()
            ->groupBy('stage');

        $stages = [
            'lead' => 'Lead',
            'negotiation' => 'Negotiation',
            'closed_won' => 'Won',
            'closed_lost' => 'Lost',
        ];

        $totals = [
            'lead' => $deals->get('lead', collect())->sum('deal_value'),
            'negotiation' => $deals->get('negotiation', collect())->sum('deal_value'),
            'closed_won' => $deals->get('closed_won', collect())->sum('deal_value'),
            'closed_lost' => $deals->get('closed_lost', collect())->sum('deal_value'),
        ];

        $contacts = $request->user()->savedCards()->get();

        return view('deals.index', compact('deals', 'stages', 'totals', 'contacts'));
    }

    public function create(Request $request): View
    {
        $contacts = $request->user()->savedCards()->get();

        return view('deals.create', compact('contacts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'deal_name' => 'required|string|max:255',
            'saved_card_id' => 'required|exists:saved_cards,id',
            'deal_value' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'stage' => 'nullable|in:lead,negotiation,closed_won,closed_lost',
            'expected_close_date' => 'nullable|date',
            'notes' => 'nullable|string|max:2000',
        ]);

        // Verify contact ownership
        abort_unless(
            $request->user()->savedCards()->where('id', $validated['saved_card_id'])->exists(),
            403
        );

        $validated['stage'] = $validated['stage'] ?? 'lead';
        $validated['currency'] = $validated['currency'] ?? 'USD';

        $request->user()->deals()->create($validated);

        if ($request->has('redirect_to_contact')) {
            return back()->with('success', 'Deal created successfully.');
        }

        return redirect()->route('deals.index')->with('success', 'Deal created successfully.');
    }

    public function show(Request $request, Deal $deal): View
    {
        abort_unless($deal->user_id === $request->user()->id, 403);

        $deal->load('savedCard');

        return view('deals.show', compact('deal'));
    }

    public function edit(Request $request, Deal $deal): View
    {
        abort_unless($deal->user_id === $request->user()->id, 403);

        $contacts = $request->user()->savedCards()->get();

        return view('deals.edit', compact('deal', 'contacts'));
    }

    public function update(Request $request, Deal $deal): RedirectResponse
    {
        abort_unless($deal->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'deal_name' => 'required|string|max:255',
            'saved_card_id' => 'required|exists:saved_cards,id',
            'deal_value' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'stage' => 'required|in:lead,negotiation,closed_won,closed_lost',
            'expected_close_date' => 'nullable|date',
            'notes' => 'nullable|string|max:2000',
        ]);

        abort_unless(
            $request->user()->savedCards()->where('id', $validated['saved_card_id'])->exists(),
            403
        );

        $deal->update($validated);

        return redirect()->route('deals.show', $deal)->with('success', 'Deal updated successfully.');
    }

    public function destroy(Request $request, Deal $deal): RedirectResponse
    {
        abort_unless($deal->user_id === $request->user()->id, 403);

        $deal->delete();

        return redirect()->route('deals.index')->with('success', 'Deal deleted.');
    }

    public function updateStage(Request $request, Deal $deal): RedirectResponse
    {
        abort_unless($deal->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'stage' => 'required|in:lead,negotiation,closed_won,closed_lost',
        ]);

        $deal->update(['stage' => $validated['stage']]);

        return back()->with('success', 'Deal stage updated.');
    }
}
