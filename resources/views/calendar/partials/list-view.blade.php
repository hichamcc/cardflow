<div class="space-y-6">
    {{-- Overdue --}}
    @if($overdue->isNotEmpty())
        <div class="rounded-xl border border-red-200 bg-white dark:border-red-800 dark:bg-gray-900">
            <div class="border-b border-red-200 px-5 py-3 dark:border-red-800">
                <h2 class="text-sm font-semibold text-red-600 dark:text-red-400">{{ __('Overdue') }} ({{ $overdue->count() }})</h2>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($overdue as $event)
                    @include('calendar.partials._event-row', ['event' => $event, 'showDate' => true])
                @endforeach
            </div>
        </div>
    @endif

    {{-- Today --}}
    <div class="rounded-xl border border-blue-200 bg-white dark:border-blue-800 dark:bg-gray-900">
        <div class="border-b border-blue-200 px-5 py-3 dark:border-blue-800">
            <h2 class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ __('Today') }} - {{ now()->format('l, M d') }}</h2>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($today as $event)
                @include('calendar.partials._event-row', ['event' => $event, 'showDate' => false])
            @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No events today.') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Upcoming --}}
    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-5 py-3 dark:border-gray-700">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Upcoming') }}</h2>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($upcoming as $event)
                @include('calendar.partials._event-row', ['event' => $event, 'showDate' => true])
            @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No upcoming events.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
