<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('settings.billing', [
            'user' => $user,
            'subscription' => $user->subscription(),
        ]);
    }

    public function upgrade(Request $request): View
    {
        $user = $request->user();

        return view('upgrade', [
            'user' => $user,
        ]);
    }

    public function cancel(Request $request): RedirectResponse
    {
        $user = $request->user();
        $subscription = $user->subscription();

        if ($subscription && ! $subscription->canceled()) {
            $subscription->cancel();
            return back()->with('success', 'Your subscription has been canceled. You can continue using Pro features until the end of your billing period.');
        }

        // No Paddle subscription — downgrade tier directly
        if (! $subscription && ! $user->isFree()) {
            $user->update(['subscription_tier' => 'free']);
            return back()->with('success', 'Your plan has been downgraded to Free.');
        }

        return back();
    }

    public function resume(Request $request): RedirectResponse
    {
        $subscription = $request->user()->subscription();

        if ($subscription && $subscription->onGracePeriod()) {
            $subscription->stopCancelation();
        }

        return back()->with('success', 'Your subscription has been resumed.');
    }
}
