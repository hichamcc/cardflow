<x-layouts.app :title="__('Folders')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('Folders') }}</x-heading>
                <x-subheading>{{ __('Organize your saved contacts into folders.') }}</x-subheading>
            </div>
            <a href="{{ route('folders.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <x-phosphor-plus class="h-4 w-4" />
                {{ __('New Folder') }}
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse($folders as $folder)
                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                    <div class="flex items-start justify-between">
                        <a href="{{ route('folders.show', $folder) }}" class="flex items-center gap-3 group">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg" style="background-color: {{ $folder->color }}20">
                                <x-phosphor-folder-fill class="h-5 w-5" style="color: {{ $folder->color }}" />
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400">{{ $folder->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $folder->saved_cards_count }} {{ __('contacts') }}</p>
                            </div>
                        </a>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('folders.edit', $folder) }}" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <x-phosphor-pencil-simple class="h-4 w-4" />
                            </a>
                            <x-form method="delete" action="{{ route('folders.destroy', $folder) }}">
                                <button type="submit" onclick="return confirm('Delete this folder? Contacts will be moved out.')" class="p-1.5 text-gray-400 hover:text-red-500">
                                    <x-phosphor-trash class="h-4 w-4" />
                                </button>
                            </x-form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <x-phosphor-folder class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" />
                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ __('No folders yet. Create one to organize your contacts.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
