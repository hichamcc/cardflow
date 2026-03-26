<x-layouts.app :title="__('Edit Note')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('notes.show', $note) }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Note') }}
            </a>
        </div>

        <div>
            <x-heading size="xl" level="1">{{ __('Edit Note') }}</x-heading>
        </div>

        <x-form method="put" action="{{ route('notes.update', $note) }}">
            <div class="mx-auto max-w-2xl space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Title') }}</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $note->title) }}" placeholder="{{ __('Note title (optional)') }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                        </div>
                        <div>
                            <label for="content" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Content') }} <span class="text-red-500">*</span></label>
                            <textarea id="content" name="content" rows="10" required
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">{{ old('content', $note->content) }}</textarea>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="category" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Category') }}</label>
                                <select id="category" name="category"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="general" {{ old('category', $note->category) === 'general' ? 'selected' : '' }}>{{ __('General') }}</option>
                                    <option value="meeting" {{ old('category', $note->category) === 'meeting' ? 'selected' : '' }}>{{ __('Meeting') }}</option>
                                    <option value="idea" {{ old('category', $note->category) === 'idea' ? 'selected' : '' }}>{{ __('Idea') }}</option>
                                    <option value="todo" {{ old('category', $note->category) === 'todo' ? 'selected' : '' }}>{{ __('To-Do') }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="saved_card_id" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Link to Contact') }}</label>
                                <select id="saved_card_id" name="saved_card_id"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="">{{ __('None (Standalone)') }}</option>
                                    @foreach($contacts as $c)
                                        <option value="{{ $c['id'] }}" {{ old('saved_card_id', $note->saved_card_id) == $c['id'] ? 'selected' : '' }}>{{ $c['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $note->is_pinned) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Pin this note') }}</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('notes.show', $note) }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                        {{ __('Update Note') }}
                    </button>
                </div>
            </div>
        </x-form>
    </div>
</x-layouts.app>
