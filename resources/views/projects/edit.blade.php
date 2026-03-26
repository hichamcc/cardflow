<x-layouts.app :title="__('Edit Project')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Project') }}
            </a>
        </div>

        <div>
            <x-heading size="xl" level="1">{{ __('Edit Project') }}</x-heading>
        </div>

        <x-form method="put" action="{{ route('projects.update', $project) }}">
            <div class="mx-auto max-w-2xl space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $project->name) }}" required placeholder="{{ __('Project name') }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="description" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Description') }}</label>
                            <textarea id="description" name="description" rows="4" placeholder="{{ __('Describe the project...') }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">{{ old('description', $project->description) }}</textarea>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="status" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
                                <select id="status" name="status"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="active" {{ old('status', $project->status) === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="on_hold" {{ old('status', $project->status) === 'on_hold' ? 'selected' : '' }}>{{ __('On Hold') }}</option>
                                    <option value="completed" {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="priority" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Priority') }}</label>
                                <select id="priority" name="priority"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="low" {{ old('priority', $project->priority) === 'low' ? 'selected' : '' }}>{{ __('Low') }}</option>
                                    <option value="medium" {{ old('priority', $project->priority) === 'medium' ? 'selected' : '' }}>{{ __('Medium') }}</option>
                                    <option value="high" {{ old('priority', $project->priority) === 'high' ? 'selected' : '' }}>{{ __('High') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="due_date" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Due Date') }}</label>
                                <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $project->due_date?->format('Y-m-d')) }}"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label for="saved_card_id" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Link to Contact') }}</label>
                                <select id="saved_card_id" name="saved_card_id"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="">{{ __('None') }}</option>
                                    @foreach($contacts as $c)
                                        <option value="{{ $c['id'] }}" {{ old('saved_card_id', $project->saved_card_id) == $c['id'] ? 'selected' : '' }}>{{ $c['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('projects.show', $project) }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                        {{ __('Update Project') }}
                    </button>
                </div>
            </div>
        </x-form>
    </div>
</x-layouts.app>
