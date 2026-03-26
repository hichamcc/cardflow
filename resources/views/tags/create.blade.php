<x-layouts.app :title="__('Create Tag')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <x-heading size="xl" level="1">{{ __('Create Tag') }}</x-heading>
        </div>

        <div class="max-w-lg">
            <x-form method="post" action="{{ route('tags.store') }}" class="space-y-4">
                <x-input type="text" name="name" :label="__('Tag Name')" :value="old('name')" required placeholder="e.g. VIP, Conference, Partner" />

                <div>
                    <x-label for="color" :value="__('Color')" />
                    <div class="flex items-center gap-3 mt-1">
                        <input type="color" name="color" id="color" value="{{ old('color', '#3B82F6') }}" class="h-10 w-14 rounded cursor-pointer border border-gray-200 dark:border-gray-700">
                        <div class="flex gap-2">
                            @foreach(['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#14B8A6', '#F97316'] as $color)
                                <button type="button" onclick="document.getElementById('color').value='{{ $color }}'" class="h-8 w-8 rounded-full border-2 border-white shadow-sm dark:border-gray-600" style="background-color: {{ $color }}"></button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        {{ __('Create Tag') }}
                    </button>
                    <a href="{{ route('tags.index') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </x-form>
        </div>
    </div>
</x-layouts.app>
