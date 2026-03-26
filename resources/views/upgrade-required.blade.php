<x-layouts.app :title="__('Upgrade to Pro')">
    <div class="flex h-full w-full flex-1 items-center justify-center py-16">
        <div class="max-w-lg text-center">
            {{-- Icon --}}
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 shadow-lg shadow-blue-500/25">
                <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">This is a Pro feature</h1>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm mx-auto leading-relaxed">
                Upgrade to Pro to unlock deal pipeline, follow-up reminders, project management, and more.
            </p>

            {{-- Feature list --}}
            <div class="mb-8 inline-flex flex-col gap-3 text-left">
                @foreach ([
                    'Unlimited business cards',
                    'Deal pipeline tracking',
                    'Follow-up reminders',
                    'Project management',
                    'Custom branding',
                    'Priority support',
                ] as $feature)
                    <div class="flex items-center gap-2.5">
                        <svg class="h-5 w-5 shrink-0 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('upgrade') }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/25">
                    Upgrade to Pro &mdash; $12/mo
                    <svg class="ml-2 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Back to dashboard
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
