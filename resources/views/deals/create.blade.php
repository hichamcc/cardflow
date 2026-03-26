<x-layouts.app :title="__('New Deal')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-2xl">
        <div>
            <a href="{{ route('deals.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Deals') }}
            </a>
        </div>

        <div>
            <x-heading size="xl" level="1">{{ __('New Deal') }}</x-heading>
            <x-subheading>{{ __('Create a new deal in your pipeline') }}</x-subheading>
        </div>

        <form method="POST" action="{{ route('deals.store') }}" class="flex flex-col gap-5">
            @csrf

            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900 space-y-4">
                <div>
                    <label for="deal_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Deal Name') }}</label>
                    <input type="text" name="deal_name" id="deal_name" value="{{ old('deal_name') }}" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white" placeholder="e.g. Website Redesign Project">
                    @error('deal_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="saved_card_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Contact') }}</label>
                    <select name="saved_card_id" id="saved_card_id" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="">{{ __('Select a contact') }}</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}" {{ old('saved_card_id') == $contact->id ? 'selected' : '' }}>{{ $contact->getFullName() }}</option>
                        @endforeach
                    </select>
                    @error('saved_card_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="deal_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Value') }}</label>
                        <input type="number" name="deal_value" id="deal_value" value="{{ old('deal_value', '0') }}" step="0.01" min="0" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        @error('deal_value') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Currency') }}</label>
                        <select name="currency" id="currency" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP</option>
                            <option value="MAD" {{ old('currency') === 'MAD' ? 'selected' : '' }}>MAD</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="stage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Stage') }}</label>
                        <select name="stage" id="stage" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            <option value="lead" {{ old('stage', 'lead') === 'lead' ? 'selected' : '' }}>{{ __('Lead') }}</option>
                            <option value="negotiation" {{ old('stage') === 'negotiation' ? 'selected' : '' }}>{{ __('Negotiation') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="expected_close_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Expected Close Date') }}</label>
                        <input type="date" name="expected_close_date" id="expected_close_date" value="{{ old('expected_close_date') }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Notes') }}</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white" placeholder="Optional notes about this deal...">{{ old('notes') }}</textarea>
                    @error('notes') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">{{ __('Create Deal') }}</button>
                <a href="{{ route('deals.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-layouts.app>
