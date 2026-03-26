<x-layouts.app :title="__('Edit Event')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Event') }}
            </a>
        </div>

        <div>
            <x-heading size="xl" level="1">{{ __('Edit Event') }}</x-heading>
        </div>

        <x-form method="put" action="{{ route('events.update', $event) }}">
            <div class="mx-auto max-w-2xl space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Title') }} <span class="text-red-500">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="type" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Type') }}</label>
                                <select id="type" name="type"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="meeting" {{ old('type', $event->type) === 'meeting' ? 'selected' : '' }}>{{ __('Meeting') }}</option>
                                    <option value="call" {{ old('type', $event->type) === 'call' ? 'selected' : '' }}>{{ __('Call') }}</option>
                                    <option value="task" {{ old('type', $event->type) === 'task' ? 'selected' : '' }}>{{ __('Task') }}</option>
                                    <option value="reminder" {{ old('type', $event->type) === 'reminder' ? 'selected' : '' }}>{{ __('Reminder') }}</option>
                                    <option value="other" {{ old('type', $event->type) === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="saved_card_id" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Contact') }}</label>
                                <select id="saved_card_id" name="saved_card_id"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="">{{ __('None') }}</option>
                                    @foreach($contacts as $c)
                                        <option value="{{ $c['id'] }}" {{ old('saved_card_id', $event->saved_card_id) == $c['id'] ? 'selected' : '' }}>{{ $c['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="start_at" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Start') }} <span class="text-red-500">*</span></label>
                                <input type="datetime-local" id="start_at" name="start_at" value="{{ old('start_at', $event->start_at->format('Y-m-d\TH:i')) }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label for="end_at" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('End') }} <span class="text-red-500">*</span></label>
                                <input type="datetime-local" id="end_at" name="end_at" value="{{ old('end_at', $event->end_at->format('Y-m-d\TH:i')) }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>
                        <div>
                            <label for="location" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Location') }}</label>
                            <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                        </div>
                        <div>
                            <label for="description" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Description') }}</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">{{ old('description', $event->description) }}</textarea>
                        </div>
                        <div>
                            <label for="color" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Color') }}</label>
                            <input type="color" id="color" name="color" value="{{ old('color', $event->color ?? '#3B82F6') }}"
                                class="h-10 w-20 cursor-pointer rounded-lg border border-gray-300 p-1 dark:border-gray-600">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('events.show', $event) }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                        {{ __('Update Event') }}
                    </button>
                </div>
            </div>
        </x-form>
    </div>
</x-layouts.app>
