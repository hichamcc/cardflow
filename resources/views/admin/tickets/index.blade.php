<x-layouts.admin :title="__('Support Tickets')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <x-heading size="xl" level="1">{{ __('Support Tickets') }}</x-heading>
            <x-subheading>{{ __('Manage all support requests') }}</x-subheading>
        </div>

        {{-- Filters --}}
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="status" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <option value="">All Statuses</option>
                @foreach (['open', 'in_progress', 'resolved', 'closed'] as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                @endforeach
            </select>
            <select name="priority" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <option value="">All Priorities</option>
                @foreach (['low', 'medium', 'high'] as $priority)
                    <option value="{{ $priority }}" {{ request('priority') === $priority ? 'selected' : '' }}>{{ ucfirst($priority) }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Filter</button>
            @if (request()->hasAny(['status', 'priority']))
                <a href="{{ route('admin.tickets.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300">Clear</a>
            @endif
        </form>

        {{-- Tickets Table --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Ticket</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">User</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Priority</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Created</th>
                            <th class="px-5 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="px-5 py-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ticket->subject }}</p>
                                    @if ($ticket->category)
                                        <span class="text-xs text-gray-400">{{ str_replace('_', ' ', ucfirst($ticket->category)) }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-500">
                                    {{ $ticket->user->name }}
                                    @if($ticket->user->subscription_tier !== 'free')
                                        @php $tierColor = $ticket->user->isPro() ? 'blue' : 'purple'; @endphp
                                        <span class="ml-1 inline-flex items-center rounded-full px-1.5 py-0.5 text-[10px] font-medium bg-{{ $tierColor }}-100 text-{{ $tierColor }}-700 dark:bg-{{ $tierColor }}-900/30 dark:text-{{ $tierColor }}-400">
                                            {{ ucfirst($ticket->user->subscription_tier) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    @php
                                        $statusColors = ['open' => 'green', 'in_progress' => 'blue', 'resolved' => 'purple', 'closed' => 'gray'];
                                        $c = $statusColors[$ticket->status] ?? 'gray';
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-{{ $c }}-100 text-{{ $c }}-700 dark:bg-{{ $c }}-900 dark:text-{{ $c }}-300">
                                        {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    @php
                                        $prioColors = ['low' => 'gray', 'medium' => 'yellow', 'high' => 'red'];
                                        $pc = $prioColors[$ticket->priority] ?? 'gray';
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-{{ $pc }}-100 text-{{ $pc }}-700 dark:bg-{{ $pc }}-900 dark:text-{{ $pc }}-300">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500">No tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $tickets->links() }}
    </div>
</x-layouts.admin>
