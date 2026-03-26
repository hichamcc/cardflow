<x-layouts.admin :title="__('Edit User')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-2xl">
        <div>
            <x-heading size="xl" level="1">{{ __('Edit User') }}</x-heading>
            <x-subheading>{{ $user->name }} ({{ $user->email }})</x-subheading>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex flex-col gap-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="subscription_tier" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subscription Tier</label>
                <select name="subscription_tier" id="subscription_tier" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    @foreach (['free', 'pro', 'business'] as $tier)
                        <option value="{{ $tier }}" {{ old('subscription_tier', $user->subscription_tier) === $tier ? 'selected' : '' }}>{{ ucfirst($tier) }}</option>
                    @endforeach
                </select>
                @error('subscription_tier') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    @foreach (['active', 'suspended', 'banned'] as $status)
                        <option value="{{ $status }}" {{ old('status', $user->status) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Admin Notes</label>
                <textarea name="admin_notes" id="admin_notes" rows="4" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">{{ old('admin_notes', $user->admin_notes) }}</textarea>
                @error('admin_notes') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Save Changes</button>
                <a href="{{ route('admin.users.show', $user) }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
