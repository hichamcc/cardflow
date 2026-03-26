<a href="{{ route('events.show', $event) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-800">
    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full"
         style="background-color: {{ $event->color ?? '#6B7280' }}20; color: {{ $event->color ?? '#6B7280' }}">
        <x-dynamic-component :component="'phosphor-' . $event->getTypeIcon()" class="h-4 w-4" />
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $event->title }}</p>
        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
            <span>{{ $event->start_at->format('g:i A') }} - {{ $event->end_at->format('g:i A') }}</span>
            @if($showDate)
                <span>&middot; {{ $event->start_at->format('M d') }}</span>
            @endif
            @if($event->location)
                <span>&middot; {{ $event->location }}</span>
            @endif
            @if($event->savedCard)
                <span>&middot; {{ $event->savedCard->getFullName() }}</span>
            @endif
        </div>
    </div>
    @if($event->status === 'scheduled')
        <div class="flex items-center gap-1">
            <form method="POST" action="{{ route('events.complete', $event) }}" onclick="event.stopPropagation()">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-md bg-green-50 p-1.5 text-green-600 hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/40">
                    <x-phosphor-check class="h-3.5 w-3.5" />
                </button>
            </form>
        </div>
    @else
        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium {{ $event->status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
            {{ ucfirst($event->status) }}
        </span>
    @endif
</a>
