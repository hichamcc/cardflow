<x-layouts.app :title="__('Billing | Settings')">
<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Billing')" :subheading="__('Manage your subscription and billing')">
        <div class="my-6 w-full space-y-6">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Current Plan --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Current Plan</h3>

                <div class="flex items-center gap-3 mb-1">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold
                        {{ $user->subscription_tier === 'pro' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : ($user->subscription_tier === 'business' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400') }}">
                        {{ ucfirst($user->subscription_tier) }}
                    </span>
                    @if ($user->subscription_tier === 'pro')
                        <span class="text-sm text-gray-500 dark:text-gray-400">$12/month</span>
                    @elseif ($user->subscription_tier === 'business')
                        <span class="text-sm text-gray-500 dark:text-gray-400">$29/month</span>
                    @else
                        <span class="text-sm text-gray-500 dark:text-gray-400">Free</span>
                    @endif
                </div>

                @if ($subscription && $subscription->onGracePeriod())
                    <p class="mt-3 text-sm text-amber-600 dark:text-amber-400">
                        Your subscription will end on {{ $subscription->ends_at->format('M j, Y') }}.
                        You can resume anytime before then.
                    </p>
                @endif

                @if ($subscription && $subscription->pastDue())
                    <p class="mt-3 text-sm text-red-600 dark:text-red-400">
                        Your payment is past due. Please update your payment method to continue using Pro features.
                    </p>
                @endif
            </div>

            {{-- Actions --}}
            @if ($user->isFree())
                <a href="{{ route('upgrade') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    Upgrade Plan
                </a>
            @else
                @if ($subscription && ! $subscription->canceled())
                    {{-- Update Payment Method --}}
                    @if ($subscription->customer)
                        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Payment Method</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Update your payment method through Paddle.</p>
                            <a href="{{ $subscription->customer->paddleUrl() ?? '#' }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                Update Payment Method
                            </a>
                        </div>
                    @endif

                    {{-- Cancel Subscription --}}
                    <div class="rounded-xl border border-red-200 bg-red-50/50 p-5 dark:border-red-900 dark:bg-red-900/10">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Cancel Subscription</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                            You'll keep your Pro features until the end of the current billing period.
                        </p>
                        <form method="POST" action="{{ route('settings.billing.cancel') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:border-red-700 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" onclick="return confirm('Are you sure you want to cancel your subscription?')">
                                Cancel Subscription
                            </button>
                        </form>
                    </div>
                @elseif ($subscription && $subscription->onGracePeriod())
                    {{-- Resume Subscription --}}
                    <div class="rounded-xl border border-blue-200 bg-blue-50/50 p-5 dark:border-blue-900 dark:bg-blue-900/10">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Resume Subscription</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                            Changed your mind? Resume your subscription to keep Pro features.
                        </p>
                        <form method="POST" action="{{ route('settings.billing.resume') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                                Resume Subscription
                            </button>
                        </form>
                    </div>

                    {{-- Upgrade option during grace period --}}
                    <a href="{{ route('upgrade') }}" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        Or upgrade to a different plan
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                @else
                    {{-- No Paddle subscription but tier is pro/business (manually set) --}}
                    <div class="rounded-xl border border-red-200 bg-red-50/50 p-5 dark:border-red-900 dark:bg-red-900/10">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Downgrade to Free</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                            This will immediately switch your account to the Free plan.
                        </p>
                        <form method="POST" action="{{ route('settings.billing.cancel') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:border-red-700 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" onclick="return confirm('Are you sure you want to downgrade to the Free plan?')">
                                Downgrade to Free
                            </button>
                        </form>
                    </div>
                @endif
            @endif
        </div>
    </x-settings.layout>
</section>
</x-layouts.app>
