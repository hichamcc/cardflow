<x-layouts.app :title="__('Card Limit Reached')">
    <div class="flex h-full w-full flex-1 items-center justify-center">
        <div class="max-w-md text-center">
            <x-phosphor-lock-key class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600" />
            <x-heading size="xl" level="1" class="mt-4">{{ __('Card Limit Reached') }}</x-heading>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                {{ __('Your :tier plan allows :limit business cards. Upgrade to create unlimited cards.', ['tier' => ucfirst($tier), 'limit' => $limit]) }}
            </p>
            <div class="mt-6 flex items-center justify-center gap-3">
                <a href="{{ route('cards.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    {{ __('Back to Cards') }}
                </a>
                <a href="#" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                    <x-phosphor-rocket-launch class="h-4 w-4" />
                    {{ __('Upgrade Plan') }}
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
