<?php

namespace App\Listeners;

use App\Models\User;
use Laravel\Paddle\Events\SubscriptionCanceled;
use Laravel\Paddle\Events\SubscriptionCreated;
use Laravel\Paddle\Events\SubscriptionUpdated;

class SyncSubscriptionTier
{
    public function handle(SubscriptionCreated|SubscriptionUpdated|SubscriptionCanceled $event): void
    {
        $customer = $event->subscription->customer;

        if (! $customer) {
            return;
        }

        $user = User::find($customer->billable_id);

        $user?->syncSubscriptionTier();
    }
}
