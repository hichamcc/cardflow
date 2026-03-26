<x-layouts.app :title="__('Upgrade Your Plan')">
    <div class="flex h-full w-full flex-1 flex-col items-center py-12">
        <div class="max-w-4xl w-full px-4">
            {{-- Header --}}
            <div class="text-center mb-10">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Choose your plan</h1>
                <p class="text-gray-500 dark:text-gray-400">Unlock powerful features to grow your network.</p>
            </div>

            @if ($user->subscription() && ! $user->subscription()->canceled())
                <div class="mb-8 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700 dark:border-blue-800 dark:bg-blue-900/30 dark:text-blue-300 text-center">
                    You're currently on the <strong>{{ ucfirst($user->subscription_tier) }}</strong> plan.
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto">
                {{-- Pro Plan --}}
                <div class="rounded-2xl border-2 border-blue-500 bg-white dark:bg-gray-900 p-7 relative shadow-lg shadow-blue-500/10">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                        <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">Most Popular</span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-2">Pro</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-4">For professionals who network seriously</p>

                    <div class="mb-6">
                        <span class="text-4xl font-black text-gray-900 dark:text-white">$12</span>
                        <span class="text-gray-400 text-sm">/month</span>
                    </div>

                    <ul class="space-y-2.5 mb-7 text-sm text-gray-600 dark:text-gray-300">
                        @foreach (['Unlimited business cards', 'Unlimited interactions', 'Deal pipeline tracking', 'Follow-up reminders', 'Project management', 'Custom branding', 'Priority support'] as $feature)
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    @if ($user->subscription_tier === 'pro')
                        <div class="w-full text-center py-3 rounded-xl bg-gray-100 text-gray-500 text-sm font-semibold dark:bg-gray-800 dark:text-gray-400">
                            Current Plan
                        </div>
                    @else
                        <x-paddle-button :checkout="$proCheckout" class="block w-full text-center py-3 rounded-xl bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/25 cursor-pointer">
                            Subscribe to Pro
                        </x-paddle-button>
                    @endif
                </div>

                {{-- Business Plan --}}
                <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-7 relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                        <span class="px-3 py-1 rounded-full bg-gray-500 text-white text-xs font-bold uppercase tracking-wider">Coming Soon</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-2">Business</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-4">For teams that grow together</p>

                    <div class="mb-6">
                        <span class="text-4xl font-black text-gray-900 dark:text-white">$29</span>
                        <span class="text-gray-400 text-sm">/month</span>
                    </div>

                    <ul class="space-y-2.5 mb-7 text-sm text-gray-600 dark:text-gray-300">
                        @foreach (['Everything in Pro', 'Team features (5 users)', 'Shared contact database', 'Advanced pipeline', 'Weekly digest reports', 'API access', 'Custom domain', 'Dedicated onboarding'] as $feature)
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="w-full text-center py-3 rounded-xl bg-gray-100 text-gray-400 text-sm font-semibold dark:bg-gray-800 dark:text-gray-500 cursor-not-allowed">
                        Coming Soon
                    </div>
                </div>
            </div>

            {{-- Back link --}}
            <div class="text-center mt-8">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                    &larr; Back to dashboard
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
