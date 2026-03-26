<x-layouts.app :title="__('New Support Ticket')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-2xl">
        <div>
            <x-heading size="xl" level="1">{{ __('New Support Ticket') }}</x-heading>
            <x-subheading>{{ __('Describe your issue and we\'ll get back to you') }}</x-subheading>
        </div>

        @if(auth()->user()->isPro() || auth()->user()->isBusiness())
            <div class="flex items-center gap-2 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 dark:border-blue-800 dark:bg-blue-900/20">
                <x-phosphor-star class="h-5 w-5 text-blue-600 dark:text-blue-400" />
                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">{{ __('Priority Support') }} &mdash; {{ __('Your tickets are automatically marked as high priority.') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('support.store') }}" class="flex flex-col gap-5">
            @csrf

            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white" placeholder="Brief description of your issue">
                @error('subject') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                    <select name="category" id="category" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="">Select category</option>
                        <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>General</option>
                        <option value="billing" {{ old('category') === 'billing' ? 'selected' : '' }}>Billing</option>
                        <option value="bug" {{ old('category') === 'bug' ? 'selected' : '' }}>Bug Report</option>
                        <option value="feature_request" {{ old('category') === 'feature_request' ? 'selected' : '' }}>Feature Request</option>
                    </select>
                    @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                    @if(auth()->user()->isPro() || auth()->user()->isBusiness())
                        <input type="hidden" name="priority" value="high">
                        <div class="flex items-center gap-2 rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">High</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Auto-set for Pro/Business') }}</span>
                        </div>
                    @else
                        <select name="priority" id="priority" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    @endif
                    @error('priority') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                <textarea name="message" id="message" rows="6" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white" placeholder="Describe your issue in detail...">{{ old('message') }}</textarea>
                @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Submit Ticket</button>
                <a href="{{ route('support.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>
