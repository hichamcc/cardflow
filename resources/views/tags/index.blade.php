<x-layouts.app :title="__('Tags')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('Tags') }}</x-heading>
                <x-subheading>{{ __('Tag your contacts for quick filtering.') }}</x-subheading>
            </div>
            <a href="{{ route('tags.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <x-phosphor-plus class="h-4 w-4" />
                {{ __('New Tag') }}
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-3">
            @forelse($tags as $tag)
                <div class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 dark:border-gray-700 dark:bg-gray-900">
                    <span class="h-3 w-3 rounded-full" style="background-color: {{ $tag->color }}"></span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $tag->name }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">({{ $tag->saved_cards_count }})</span>
                    <a href="{{ route('tags.edit', $tag) }}" class="ml-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <x-phosphor-pencil-simple class="h-3.5 w-3.5" />
                    </a>
                    <x-form method="delete" action="{{ route('tags.destroy', $tag) }}" class="inline">
                        <button type="submit" onclick="return confirm('Delete this tag?')" class="text-gray-400 hover:text-red-500">
                            <x-phosphor-x class="h-3.5 w-3.5" />
                        </button>
                    </x-form>
                </div>
            @empty
                <div class="w-full py-12 text-center">
                    <x-phosphor-tag class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" />
                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ __('No tags yet. Create tags to categorize your contacts.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
