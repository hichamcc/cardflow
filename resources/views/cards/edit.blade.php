<x-layouts.app :title="__('Edit Card')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <x-heading size="xl" level="1">{{ __('Edit Card') }}</x-heading>
            <x-subheading>{{ __('Update your business card details.') }}</x-subheading>
        </div>

        <x-form method="put" action="{{ route('cards.update', $card) }}" :upload="true">
            @include('cards._form')

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('cards.show', $card) }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    {{ __('Save Changes') }}
                </button>
            </div>
        </x-form>
    </div>
</x-layouts.app>
