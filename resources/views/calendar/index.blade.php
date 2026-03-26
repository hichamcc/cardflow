<x-layouts.app :title="__('Calendar')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('Calendar') }}</x-heading>
                <x-subheading>{{ __('Manage your schedule and events.') }}</x-subheading>
            </div>
            <div class="flex items-center gap-3">
                {{-- View Toggle --}}
                <div class="inline-flex rounded-lg border border-gray-300 dark:border-gray-600">
                    <a href="{{ route('calendar.index', ['view' => 'calendar']) }}"
                       class="rounded-l-lg px-3 py-2 text-sm font-medium {{ $view === 'calendar' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                        <x-phosphor-calendar-blank class="inline h-4 w-4" />
                        {{ __('Calendar') }}
                    </a>
                    <a href="{{ route('calendar.index', ['view' => 'list']) }}"
                       class="rounded-r-lg px-3 py-2 text-sm font-medium {{ $view === 'list' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                        <x-phosphor-list class="inline h-4 w-4" />
                        {{ __('List') }}
                    </a>
                </div>
                <a href="{{ route('events.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                    <x-phosphor-plus class="h-4 w-4" />
                    {{ __('New Event') }}
                </a>
            </div>
        </div>

        @if($view === 'calendar')
            @include('calendar.partials.calendar-view')
        @else
            @include('calendar.partials.list-view')
        @endif
    </div>
</x-layouts.app>
