<x-layouts.app :title="$note->title ?? __('Note')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('notes.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Notes') }}
            </a>
        </div>

        <div class="mx-auto w-full max-w-2xl">
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 p-6 dark:border-gray-700">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $note->title ?? __('Untitled') }}</h1>
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                @php
                                    $catColors = [
                                        'general' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                        'meeting' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'idea' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                        'todo' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                    ];
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $catColors[$note->category] ?? $catColors['general'] }}">
                                    {{ ucfirst($note->category) }}
                                </span>
                                @if($note->is_pinned)
                                    <span class="inline-flex items-center gap-1 text-xs text-amber-600 dark:text-amber-400">
                                        <x-phosphor-push-pin class="h-3 w-3" />
                                        {{ __('Pinned') }}
                                    </span>
                                @endif
                                @if($note->savedCard)
                                    <a href="{{ route('contacts.show', $note->savedCard) }}" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline dark:text-blue-400">
                                        <x-phosphor-user class="h-3 w-3" />
                                        {{ $note->savedCard->getFullName() }}
                                    </a>
                                @endif
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ $note->created_at->format('M d, Y g:i A') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('notes.toggle-pin', $note) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-lg border border-gray-300 bg-white p-2 text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700" title="{{ $note->is_pinned ? __('Unpin') : __('Pin') }}">
                                    <x-phosphor-push-pin class="h-4 w-4 {{ $note->is_pinned ? 'text-amber-500' : '' }}" />
                                </button>
                            </form>
                            <a href="{{ route('notes.edit', $note) }}" class="rounded-lg border border-gray-300 bg-white p-2 text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700" title="{{ __('Edit') }}">
                                <x-phosphor-pencil class="h-4 w-4" />
                            </a>
                            <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('{{ __('Delete this note?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-gray-300 bg-white p-2 text-red-600 transition hover:bg-red-50 dark:border-gray-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20" title="{{ __('Delete') }}">
                                    <x-phosphor-trash class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="prose prose-sm max-w-none text-gray-700 dark:prose-invert dark:text-gray-300">
                        {!! nl2br(e($note->content)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
