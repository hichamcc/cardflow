<x-layouts.app :title="__('Notes')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('Notes') }}</x-heading>
                <x-subheading>{{ __('Capture ideas, meeting notes, and to-dos.') }}</x-subheading>
            </div>
            <a href="{{ route('notes.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                <x-phosphor-plus class="h-4 w-4" />
                {{ __('New Note') }}
            </a>
        </div>

        {{-- Filters --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
            <form method="GET" action="{{ route('notes.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Search') }}</label>
                    <div class="relative">
                        <x-phosphor-magnifying-glass class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search notes...') }}"
                            class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-10 pr-4 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                    </div>
                </div>
                <div class="min-w-[140px]">
                    <label for="category" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Category') }}</label>
                    <select id="category" name="category"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="">{{ __('All') }}</option>
                        <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>{{ __('General') }}</option>
                        <option value="meeting" {{ request('category') === 'meeting' ? 'selected' : '' }}>{{ __('Meeting') }}</option>
                        <option value="idea" {{ request('category') === 'idea' ? 'selected' : '' }}>{{ __('Idea') }}</option>
                        <option value="todo" {{ request('category') === 'todo' ? 'selected' : '' }}>{{ __('To-Do') }}</option>
                    </select>
                </div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="pinned" value="1" {{ request()->boolean('pinned') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Pinned only') }}</span>
                </label>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                        <x-phosphor-funnel class="h-4 w-4" />
                        {{ __('Filter') }}
                    </button>
                    @if(request()->hasAny(['search', 'category', 'pinned']))
                        <a href="{{ route('notes.index') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-x class="h-4 w-4" />
                            {{ __('Clear') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Notes Grid --}}
        @if($notes->isNotEmpty())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($notes as $note)
                    @php
                        $catColors = [
                            'general' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                            'meeting' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                            'idea' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                            'todo' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                        ];
                    @endphp
                    <a href="{{ route('notes.show', $note) }}"
                       class="group rounded-xl border border-gray-200 bg-white p-5 transition hover:border-blue-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-900 dark:hover:border-blue-600 {{ $note->is_pinned ? 'ring-2 ring-amber-200 dark:ring-amber-800' : '' }}">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400 truncate">
                                {{ $note->title ?? __('Untitled') }}
                            </h3>
                            <div class="flex items-center gap-1.5 shrink-0">
                                @if($note->is_pinned)
                                    <x-phosphor-push-pin class="h-3.5 w-3.5 text-amber-500" />
                                @endif
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium {{ $catColors[$note->category] ?? $catColors['general'] }}">
                                    {{ ucfirst($note->category) }}
                                </span>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 line-clamp-3">{{ Str::limit($note->content, 150) }}</p>
                        <div class="mt-3 flex items-center justify-between border-t border-gray-100 pt-3 dark:border-gray-800">
                            @if($note->savedCard)
                                <span class="inline-flex items-center gap-1 text-xs text-gray-400 dark:text-gray-500">
                                    <x-phosphor-user class="h-3 w-3" />
                                    {{ $note->savedCard->getFullName() }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Standalone') }}</span>
                            @endif
                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $note->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-2">{{ $notes->withQueryString()->links() }}</div>
        @else
            <div class="rounded-xl border border-gray-200 bg-white px-6 py-16 text-center dark:border-gray-700 dark:bg-gray-900">
                <x-phosphor-note-pencil class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" />
                <h3 class="mt-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('No notes yet') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Create your first note to start capturing ideas.') }}</p>
                <a href="{{ route('notes.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                    <x-phosphor-plus class="h-4 w-4" />
                    {{ __('New Note') }}
                </a>
            </div>
        @endif
    </div>
</x-layouts.app>
