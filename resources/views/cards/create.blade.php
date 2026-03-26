<x-layouts.app :title="__('Create Card')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <x-heading size="xl" level="1">{{ __('Create New Card') }}</x-heading>
            <x-subheading>{{ __('Fill in the details for your new digital business card.') }}</x-subheading>
        </div>

        <x-form method="post" action="{{ route('cards.store') }}" :upload="true">
            @include('cards._form')

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('cards.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    {{ __('Create Card') }}
                </button>
            </div>
        </x-form>
    </div>
</x-layouts.app>
