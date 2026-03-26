<?php

namespace App\Providers;

use App\Listeners\SyncSubscriptionTier;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Paddle\Events\SubscriptionCanceled;
use Laravel\Paddle\Events\SubscriptionCreated;
use Laravel\Paddle\Events\SubscriptionUpdated;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(SubscriptionCreated::class, SyncSubscriptionTier::class);
        Event::listen(SubscriptionUpdated::class, SyncSubscriptionTier::class);
        Event::listen(SubscriptionCanceled::class, SyncSubscriptionTier::class);
    }
}
