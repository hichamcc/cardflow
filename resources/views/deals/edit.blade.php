<x-layouts.app :title="__('Edit Deal')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-2xl">
        <div>
            <a href="{{ route('deals.show', $deal) }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Deal') }}
            </a>
        </div>

        <div>
            <x-heading size="xl" level="1">{{ __('Edit Deal') }}</x-heading>
            <x-subheading>{{ $deal->deal_name }}</x-subheading>
        </div>

        <form method="POST" action="{{ route('deals.update', $deal) }}" class="flex flex-col gap-5">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900 space-y-4">
                <div>
                    <label for="deal_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Deal Name') }}</label>
                    <input type="text" name="deal_name" id="deal_name" value="{{ old('deal_name', $deal->deal_name) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    @error('deal_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="saved_card_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Contact') }}</label>
                    <select name="saved_card_id" id="saved_card_id" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="">{{ __('Select a contact') }}</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}" {{ old('saved_card_id', $deal->saved_card_id) == $contact->id ? 'selected' : '' }}>{{ $contact->getFullName() }}</option>
                        @endforeach
                    </select>
                    @error('saved_card_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="deal_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Value') }}</label>
                        <input type="number" name="deal_value" id="deal_value" value="{{ old('deal_value', $deal->deal_value) }}" step="0.01" min="0" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Currency') }}</label>
                        <select name="currency" id="currency" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            @foreach(['USD', 'EUR', 'GBP', 'MAD'] as $cur)
                                <option value="{{ $cur }}" {{ old('currency', $deal->currency) === $cur ? 'selected' : '' }}>{{ $cur }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="stage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Stage') }}</label>
                        <select name="stage" id="stage" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            @foreach(['lead' => 'Lead', 'negotiation' => 'Negotiation', 'closed_won' => 'Won', 'closed_lost' => 'Lost'] as $key => $label)
                                <option value="{{ $key }}" {{ old('stage', $deal->stage) === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="expected_close_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Expected Close Date') }}</label>
                        <input type="date" name="expected_close_date" id="expected_close_date" value="{{ old('expected_close_date', $deal->expected_close_date?->format('Y-m-d')) }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Notes') }}</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">{{ old('notes', $deal->notes) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">{{ __('Update Deal') }}</button>
                    <a href="{{ route('deals.show', $deal) }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300">{{ __('Cancel') }}</a>
                </div>
                <form method="POST" action="{{ route('deals.destroy', $deal) }}" onsubmit="return confirm('Delete this deal?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400">{{ __('Delete') }}</button>
                </form>
            </div>
        </form>
    </div>
</x-layouts.app>
