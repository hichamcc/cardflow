<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        {{-- Greeting --}}
        <div>
            <x-heading size="xl" level="1">{{ __('Good ' . (now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening')) . ', :name', ['name' => auth()->user()->name]) }}</x-heading>
            <x-subheading>{{ now()->format('l, F j, Y') }}</x-subheading>
        </div>

        {{-- Quick Actions --}}
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('cards.create') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 hover:shadow dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                <x-phosphor-plus-circle class="h-4 w-4 text-blue-500" />
                {{ __('New Card') }}
            </a>
            <a href="{{ route('contacts.create') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 hover:shadow dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                <x-phosphor-user-plus class="h-4 w-4 text-green-500" />
                {{ __('Add Contact') }}
            </a>
            <a href="{{ route('notes.create') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 hover:shadow dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                <x-phosphor-notepad class="h-4 w-4 text-purple-500" />
                {{ __('New Note') }}
            </a>
            <a href="{{ route('events.create') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 hover:shadow dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                <x-phosphor-calendar-plus class="h-4 w-4 text-amber-500" />
                {{ __('New Event') }}
            </a>
        </div>

        {{-- Stats Grid --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white p-5 transition hover:shadow-md dark:border-gray-700 dark:bg-gray-900">
                <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-blue-500/5 transition group-hover:scale-150 dark:bg-blue-500/10"></div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/40">
                        <x-phosphor-identification-card class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_cards'] }}</p>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('My Cards') }}</p>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white p-5 transition hover:shadow-md dark:border-gray-700 dark:bg-gray-900">
                <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-green-500/5 transition group-hover:scale-150 dark:bg-green-500/10"></div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 dark:bg-green-900/40">
                        <x-phosphor-address-book class="h-5 w-5 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_saved'] }}</p>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Contacts') }}</p>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white p-5 transition hover:shadow-md dark:border-gray-700 dark:bg-gray-900">
                <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-purple-500/5 transition group-hover:scale-150 dark:bg-purple-500/10"></div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/40">
                        <x-phosphor-eye class="h-5 w-5 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_views'] }}</p>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Total Views') }}</p>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white p-5 transition hover:shadow-md dark:border-gray-700 dark:bg-gray-900">
                <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-amber-500/5 transition group-hover:scale-150 dark:bg-amber-500/10"></div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 dark:bg-amber-900/40">
                        <x-phosphor-clock-countdown class="h-5 w-5 text-amber-600 dark:text-amber-400" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_follow_ups'] }}</p>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Follow-ups') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Today's Schedule + Follow-ups --}}
        <div class="grid gap-6 lg:grid-cols-2">
            {{-- Today's Schedule --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/40">
                            <x-phosphor-calendar-dots class="h-3.5 w-3.5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <x-heading size="base">{{ __("Today's Schedule") }}</x-heading>
                    </div>
                    <a href="{{ route('calendar.index') }}" class="text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ __('View all') }} &rarr;
                    </a>
                </div>
                <div class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($todayEvents as $event)
                        <a href="{{ route('events.show', $event) }}" class="flex items-center gap-3 px-5 py-3 transition hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl shrink-0"
                                 style="background-color: {{ $event->color ?? '#6B7280' }}15; color: {{ $event->color ?? '#6B7280' }}">
                                <x-dynamic-component :component="'phosphor-' . $event->getTypeIcon()" class="h-4 w-4" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">{{ $event->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $event->start_at->format('g:i A') }} - {{ $event->end_at->format('g:i A') }}
                                    @if($event->savedCard) &middot; {{ $event->savedCard->getFullName() }} @endif
                                </p>
                            </div>
                        </a>
                    @empty
                        <div class="px-5 py-10 text-center">
                            <x-phosphor-calendar-blank class="mx-auto h-8 w-8 text-gray-300 dark:text-gray-600" />
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Nothing scheduled today') }}</p>
                            <a href="{{ route('events.create') }}" class="mt-1 inline-block text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                {{ __('Add an event') }} &rarr;
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Upcoming Follow-ups --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/40">
                            <x-phosphor-clock-countdown class="h-3.5 w-3.5 text-amber-600 dark:text-amber-400" />
                        </div>
                        <x-heading size="base">{{ __('Follow-ups') }}</x-heading>
                    </div>
                    <a href="{{ route('follow-ups.index') }}" class="text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ __('View all') }} &rarr;
                    </a>
                </div>
                <div class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($upcomingFollowUps as $followUp)
                        <div class="flex items-center gap-3 px-5 py-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl shrink-0 {{ $followUp->isOverdue() ? 'bg-red-100 dark:bg-red-900/30' : 'bg-gray-100 dark:bg-gray-800' }}">
                                <x-phosphor-user class="h-4 w-4 {{ $followUp->isOverdue() ? 'text-red-600 dark:text-red-400' : 'text-gray-500 dark:text-gray-400' }}" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $followUp->savedCard?->getFullName() ?? __('Unknown') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    {{ $followUp->notes ? Str::limit($followUp->notes, 40) : __('No notes') }}
                                </p>
                            </div>
                            <span class="text-xs font-medium whitespace-nowrap rounded-full px-2 py-0.5 {{ $followUp->isOverdue() ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' }}">
                                {{ $followUp->follow_up_date->diffForHumans() }}
                            </span>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center">
                            <x-phosphor-clock-countdown class="mx-auto h-8 w-8 text-gray-300 dark:text-gray-600" />
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('No pending follow-ups') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- My Cards + Recent Activity --}}
        <div class="grid gap-6 lg:grid-cols-2">
            {{-- Recent Cards --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/40">
                            <x-phosphor-identification-card class="h-3.5 w-3.5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <x-heading size="base">{{ __('My Cards') }}</x-heading>
                    </div>
                    <a href="{{ route('cards.create') }}" class="text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ __('+ New') }}
                    </a>
                </div>
                <div class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($recentCards as $card)
                        <a href="{{ route('cards.show', $card) }}" class="flex items-center gap-3 px-5 py-3 transition hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl text-white text-xs font-bold shrink-0" style="background-color: {{ $card->theme_color }}">
                                {{ strtoupper(substr($card->full_name, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">{{ $card->card_name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $card->full_name }}</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ number_format($card->view_count) }} {{ __('views') }}</span>
                                <span class="inline-flex h-2 w-2 rounded-full {{ $card->is_active ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }}"></span>
                            </div>
                        </a>
                    @empty
                        <div class="px-5 py-10 text-center">
                            <x-phosphor-identification-card class="mx-auto h-8 w-8 text-gray-300 dark:text-gray-600" />
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('No cards yet') }}</p>
                            <a href="{{ route('cards.create') }}" class="mt-1 inline-block text-xs font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                {{ __('Create your first card') }} &rarr;
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                            <x-phosphor-pulse class="h-3.5 w-3.5 text-gray-600 dark:text-gray-400" />
                        </div>
                        <x-heading size="base">{{ __('Recent Activity') }}</x-heading>
                    </div>
                </div>
                <div class="divide-y divide-gray-50 dark:divide-gray-800">
                    @forelse($recentInteractions as $interaction)
                        <div class="flex items-center gap-3 px-5 py-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800 shrink-0">
                                <x-dynamic-component :component="'phosphor-' . $interaction->getTypeIcon()" class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900 dark:text-white">
                                    <span class="font-medium">{{ ucfirst($interaction->interaction_type) }}</span>
                                    {{ __('with') }}
                                    <span class="font-medium">{{ $interaction->savedCard?->getFullName() ?? __('Unknown') }}</span>
                                </p>
                                @if($interaction->subject)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $interaction->subject }}</p>
                                @endif
                            </div>
                            <span class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">{{ $interaction->interaction_date->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center">
                            <x-phosphor-pulse class="mx-auto h-8 w-8 text-gray-300 dark:text-gray-600" />
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('No recent activity') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
