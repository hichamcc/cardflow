<x-layouts.app :title="$event->title">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('calendar.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Calendar') }}
            </a>
        </div>

        <div class="mx-auto w-full max-w-2xl">
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 p-6 dark:border-gray-700">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $event->title }}</h1>
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                @php
                                    $typeColors = [
                                        'meeting' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'call' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        'task' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                        'reminder' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                        'other' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                    ];
                                    $statusColors = [
                                        'scheduled' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        'cancelled' => 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400',
                                    ];
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $typeColors[$event->type] ?? $typeColors['other'] }}">
                                    {{ ucfirst($event->type) }}
                                </span>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$event->status] ?? '' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                                @if($event->isOverdue())
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">{{ __('Overdue') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($event->status === 'scheduled')
                                <form method="POST" action="{{ route('events.complete', $event) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-green-50 px-3 py-2 text-sm font-medium text-green-700 transition hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/40">
                                        <x-phosphor-check class="h-4 w-4" />
                                        {{ __('Complete') }}
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('events.edit', $event) }}" class="rounded-lg border border-gray-300 bg-white p-2 text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                <x-phosphor-pencil class="h-4 w-4" />
                            </a>
                            <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('{{ __('Delete this event?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-gray-300 bg-white p-2 text-red-600 transition hover:bg-red-50 dark:border-gray-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">
                                    <x-phosphor-trash class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 p-6">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Start') }}</p>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $event->start_at->format('M d, Y g:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('End') }}</p>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $event->end_at->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Duration') }}</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $event->duration() }}</p>
                    </div>
                    @if($event->location)
                        <div>
                            <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Location') }}</p>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $event->location }}</p>
                        </div>
                    @endif
                    @if($event->savedCard)
                        <div>
                            <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Contact') }}</p>
                            <a href="{{ route('contacts.show', $event->savedCard) }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">{{ $event->savedCard->getFullName() }}</a>
                        </div>
                    @endif
                    @if($event->description)
                        <div>
                            <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Description') }}</p>
                            <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">{!! nl2br(e($event->description)) !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
