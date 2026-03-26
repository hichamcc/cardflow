<x-layouts.admin :title="__('Admin Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <x-heading size="xl" level="1">{{ __('Admin Dashboard') }}</x-heading>
            <x-subheading>{{ __('Overview of your platform') }}</x-subheading>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $statCards = [
                    ['Total Users', $stats['total_users'], 'phosphor-users', 'blue'],
                    ['Free', $stats['free_users'], 'phosphor-user', 'gray'],
                    ['Pro', $stats['pro_users'], 'phosphor-crown', 'purple'],
                    ['Business', $stats['business_users'], 'phosphor-buildings', 'amber'],
                    ['Open Tickets', $stats['open_tickets'], 'phosphor-lifebuoy', 'red'],
                    ['Unread Messages', $stats['unread_contacts'], 'phosphor-envelope-simple', 'green'],
                ];
            @endphp
            @foreach ($statCards as [$label, $value, $icon, $color])
                <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
                    <div class="flex items-center gap-2 mb-2">
                        <x-dynamic-component :component="$icon" class="h-4 w-4 text-{{ $color }}-500" />
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $label }}</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            {{-- Recent Signups --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 dark:border-gray-700 px-5 py-3">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Recent Signups</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($recentSignups as $user)
                        <a href="{{ route('admin.users.show', $user) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <div class="shrink-0 size-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                <span class="text-xs font-semibold text-white">{{ $user->initials() }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $user->subscription_tier === 'pro' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : ($user->subscription_tier === 'business' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400') }}">
                                    {{ ucfirst($user->subscription_tier) }}
                                </span>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="px-5 py-4 text-sm text-gray-500">No users yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Tickets --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 dark:border-gray-700 px-5 py-3">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Recent Tickets</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($recentTickets as $ticket)
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $ticket->subject }}</p>
                                <p class="text-xs text-gray-500">{{ $ticket->user->name }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $ticket->status === 'open' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : ($ticket->status === 'in_progress' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400') }}">
                                    {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                </span>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $ticket->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="px-5 py-4 text-sm text-gray-500">No tickets yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
