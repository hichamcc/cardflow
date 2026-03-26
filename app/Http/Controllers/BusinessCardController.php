<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class BusinessCardController extends Controller
{
    public function index(Request $request): View
    {
        $cards = $request->user()
            ->businessCards()
            ->withCount('savedCards')
            ->latest()
            ->paginate(12);

        return view('cards.index', compact('cards'));
    }

    public function create(Request $request): View
    {
        $user = $request->user();

        if (! $user->canCreateCard()) {
            return view('cards.limit-reached', [
                'limit' => $user->cardLimit(),
                'tier' => $user->subscription_tier,
            ]);
        }

        return view('cards.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user->canCreateCard()) {
            return back()->with('error', 'You have reached your card limit. Upgrade to create more cards.');
        }

        $validated = $request->validate([
            'card_name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'bio' => 'nullable|string|max:1000',
            'theme_color' => 'nullable|string|max:7',
            'layout_style' => 'nullable|string|in:classic,modern,minimal',
            'hide_branding' => 'nullable|boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'company_logo' => 'nullable|image|max:2048',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string',
            'social_links.*.url' => 'required_with:social_links|url',
            'custom_fields' => 'nullable|array',
            'custom_fields.*.field_name' => 'required_with:custom_fields|string|max:255',
            'custom_fields.*.field_value' => 'required_with:custom_fields|string|max:255',
            'custom_fields.*.icon' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo_path'] = $request->file('profile_photo')->store('cards/photos', 'public');
        }

        if ($request->hasFile('company_logo')) {
            $validated['company_logo_path'] = $request->file('company_logo')->store('cards/logos', 'public');
        }

        $card = $user->businessCards()->create($validated);

        // Save social links
        if (! empty($validated['social_links'])) {
            foreach ($validated['social_links'] as $index => $link) {
                if (! empty($link['url'])) {
                    $card->socialLinks()->create([
                        'platform' => $link['platform'],
                        'url' => $link['url'],
                        'display_order' => $index,
                    ]);
                }
            }
        }

        // Save custom fields
        if (! empty($validated['custom_fields'])) {
            foreach ($validated['custom_fields'] as $index => $field) {
                if (! empty($field['field_value'])) {
                    $card->customFields()->create([
                        'field_name' => $field['field_name'],
                        'field_value' => $field['field_value'],
                        'icon' => $field['icon'] ?? null,
                        'display_order' => $index,
                    ]);
                }
            }
        }

        return to_route('cards.show', $card)->with('success', 'Business card created successfully!');
    }

    public function show(Request $request, BusinessCard $card): View
    {
        abort_unless($card->user_id === $request->user()->id, 403);

        $card->load(['socialLinks', 'customFields']);

        return view('cards.show', compact('card'));
    }

    public function edit(Request $request, BusinessCard $card): View
    {
        abort_unless($card->user_id === $request->user()->id, 403);

        $card->load(['socialLinks', 'customFields']);

        return view('cards.edit', compact('card'));
    }

    public function update(Request $request, BusinessCard $card): RedirectResponse
    {
        abort_unless($card->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'card_name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'bio' => 'nullable|string|max:1000',
            'theme_color' => 'nullable|string|max:7',
            'layout_style' => 'nullable|string|in:classic,modern,minimal',
            'hide_branding' => 'nullable|boolean',
            'profile_photo' => 'nullable|image|max:2048',
            'company_logo' => 'nullable|image|max:2048',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string',
            'social_links.*.url' => 'required_with:social_links|url',
            'custom_fields' => 'nullable|array',
            'custom_fields.*.field_name' => 'required_with:custom_fields|string|max:255',
            'custom_fields.*.field_value' => 'required_with:custom_fields|string|max:255',
            'custom_fields.*.icon' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($card->profile_photo_path) {
                Storage::disk('public')->delete($card->profile_photo_path);
            }
            $validated['profile_photo_path'] = $request->file('profile_photo')->store('cards/photos', 'public');
        }

        if ($request->hasFile('company_logo')) {
            if ($card->company_logo_path) {
                Storage::disk('public')->delete($card->company_logo_path);
            }
            $validated['company_logo_path'] = $request->file('company_logo')->store('cards/logos', 'public');
        }

        $card->update($validated);

        // Sync social links
        $card->socialLinks()->delete();
        if (! empty($validated['social_links'])) {
            foreach ($validated['social_links'] as $index => $link) {
                if (! empty($link['url'])) {
                    $card->socialLinks()->create([
                        'platform' => $link['platform'],
                        'url' => $link['url'],
                        'display_order' => $index,
                    ]);
                }
            }
        }

        // Sync custom fields
        $card->customFields()->delete();
        if (! empty($validated['custom_fields'])) {
            foreach ($validated['custom_fields'] as $index => $field) {
                if (! empty($field['field_value'])) {
                    $card->customFields()->create([
                        'field_name' => $field['field_name'],
                        'field_value' => $field['field_value'],
                        'icon' => $field['icon'] ?? null,
                        'display_order' => $index,
                    ]);
                }
            }
        }

        return to_route('cards.show', $card)->with('success', 'Business card updated successfully!');
    }

    public function destroy(Request $request, BusinessCard $card): RedirectResponse
    {
        abort_unless($card->user_id === $request->user()->id, 403);

        if ($card->profile_photo_path) {
            Storage::disk('public')->delete($card->profile_photo_path);
        }
        if ($card->company_logo_path) {
            Storage::disk('public')->delete($card->company_logo_path);
        }

        $card->delete();

        return to_route('cards.index')->with('success', 'Business card deleted.');
    }

    public function duplicate(Request $request, BusinessCard $card): RedirectResponse
    {
        abort_unless($card->user_id === $request->user()->id, 403);

        $user = $request->user();
        if (! $user->canCreateCard()) {
            return back()->with('error', 'You have reached your card limit.');
        }

        $newCard = $card->replicate(['slug', 'view_count']);
        $newCard->card_name = $card->card_name . ' (Copy)';
        $newCard->slug = BusinessCard::generateUniqueSlug($card->full_name);
        $newCard->view_count = 0;
        $newCard->save();

        foreach ($card->socialLinks as $link) {
            $newCard->socialLinks()->create($link->only(['platform', 'url', 'display_order']));
        }

        foreach ($card->customFields as $field) {
            $newCard->customFields()->create($field->only(['field_name', 'field_value', 'icon', 'display_order']));
        }

        return to_route('cards.edit', $newCard)->with('success', 'Card duplicated successfully!');
    }

    public function toggle(Request $request, BusinessCard $card): RedirectResponse
    {
        abort_unless($card->user_id === $request->user()->id, 403);

        $card->update(['is_active' => ! $card->is_active]);

        $status = $card->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Card {$status} successfully.");
    }
}
