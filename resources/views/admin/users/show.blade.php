<x-layouts.admin :title="$user->name">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <x-heading size="xl" level="1">{{ $user->name }}</x-heading>
                <x-subheading>{{ $user->email }}</x-subheading>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <x-phosphor-pencil-simple class="h-4 w-4" />
                    Edit
                </a>
                @if (! $user->is_admin)
                    <form method="POST" action="{{ route('admin.users.impersonate', $user) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-amber-300 bg-amber-50 px-3 py-2 text-sm font-medium text-amber-700 hover:bg-amber-100 dark:border-amber-600 dark:bg-amber-900/30 dark:text-amber-300">
                            <x-phosphor-user-switch class="h-4 w-4" />
                            Impersonate
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- User Info --}}
        <div class="grid md:grid-cols-3 gap-4">
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tier</p>
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-sm font-medium
                    {{ $user->subscription_tier === 'pro' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : ($user->subscription_tier === 'business' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400') }}">
                    {{ ucfirst($user->subscription_tier) }}
                </span>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</p>
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-sm font-medium
                    {{ $user->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : ($user->status === 'suspended' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300') }}">
                    {{ ucfirst($user->status) }}
                </span>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Joined</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('M j, Y') }}</p>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->business_cards_count }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Business Cards</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->saved_cards_count }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Saved Cards</p>
            </div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->support_tickets_count }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Support Tickets</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        @if (! $user->is_admin)
            <div class="flex flex-wrap gap-2">
                @if ($user->status !== 'active')
                    <form method="POST" action="{{ route('admin.users.activate', $user) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700">
                            <x-phosphor-check-circle class="h-4 w-4" />
                            Activate
                        </button>
                    </form>
                @endif
                @if ($user->status !== 'suspended')
                    <form method="POST" action="{{ route('admin.users.suspend', $user) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-yellow-600 px-3 py-2 text-sm font-medium text-white hover:bg-yellow-700">
                            <x-phosphor-pause-circle class="h-4 w-4" />
                            Suspend
                        </button>
                    </form>
                @endif
                @if ($user->status !== 'banned')
                    <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">
                            <x-phosphor-prohibit class="h-4 w-4" />
                            Ban
                        </button>
                    </form>
                @endif
            </div>
        @endif

        {{-- Subscription Status --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Subscription</h3>
            @if ($user->subscription())
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Status</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            @if ($user->subscription()->onGracePeriod())
                                <span class="text-amber-600 dark:text-amber-400">Canceling (grace period)</span>
                            @elseif ($user->subscription()->canceled())
                                <span class="text-red-600 dark:text-red-400">Canceled</span>
                            @elseif ($user->subscription()->pastDue())
                                <span class="text-red-600 dark:text-red-400">Past Due</span>
                            @else
                                <span class="text-green-600 dark:text-green-400">Active</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Plan</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($user->subscription_tier) }}</span>
                    </div>
                    @if ($user->subscription()->onGracePeriod())
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Ends at</span>
                            <span class="font-medium text-amber-600 dark:text-amber-400">{{ $user->subscription()->ends_at->format('M j, Y') }}</span>
                        </div>
                    @endif
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">No active subscription (Free tier)</p>
            @endif
        </div>

        {{-- User's Cards --}}
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div class="border-b border-gray-200 dark:border-gray-700 px-5 py-3">
                <h3 class="font-semibold text-gray-900 dark:text-white">Business Cards</h3>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($cards as $card)
                    <div class="flex items-center justify-between px-5 py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $card->card_name }}</p>
                            <p class="text-xs text-gray-500">{{ $card->full_name }} &middot; {{ $card->job_title }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400">{{ $card->view_count }} views</span>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $card->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400' }}">
                                {{ $card->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="px-5 py-4 text-sm text-gray-500">No cards created.</p>
                @endforelse
            </div>
        </div>

        {{-- Admin Notes --}}
        @if ($user->admin_notes)
            <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Admin Notes</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $user->admin_notes }}</p>
            </div>
        @endif
    </div>
</x-layouts.admin>
