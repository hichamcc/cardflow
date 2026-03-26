<x-layouts.admin :title="__('User Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <x-heading size="xl" level="1">{{ __('User Management') }}</x-heading>
            <x-subheading>{{ __('Browse and manage all users') }}</x-subheading>
        </div>

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
            <select name="tier" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <option value="">All Tiers</option>
                @foreach (['free', 'pro', 'business'] as $tier)
                    <option value="{{ $tier }}" {{ request('tier') === $tier ? 'selected' : '' }}>{{ ucfirst($tier) }}</option>
                @endforeach
            </select>
            <select name="status" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <option value="">All Statuses</option>
                @foreach (['active', 'suspended', 'banned'] as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Filter</button>
            @if (request()->hasAny(['search', 'tier', 'status']))
                <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800">Clear</a>
            @endif
        </form>

        {{-- Users Table --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">User</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Tier</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Cards</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Joined</th>
                            <th class="px-5 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="shrink-0 size-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                            <span class="text-xs font-semibold text-white">{{ $user->initials() }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                        {{ $user->subscription_tier === 'pro' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : ($user->subscription_tier === 'business' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400') }}">
                                        {{ ucfirst($user->subscription_tier) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                        {{ $user->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : ($user->status === 'suspended' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300') }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-500">{{ $user->business_cards_count }}</td>
                                <td class="px-5 py-3 text-sm text-gray-500">{{ $user->created_at->format('M j, Y') }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $users->links() }}
    </div>
</x-layouts.admin>
