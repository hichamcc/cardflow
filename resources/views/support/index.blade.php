<x-layouts.app :title="__('Support Tickets')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('Support Tickets') }}</x-heading>
                <x-subheading>{{ __('View and manage your support requests') }}</x-subheading>
            </div>
            <a href="{{ route('support.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <x-phosphor-plus-circle class="h-4 w-4" />
                New Ticket
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($tickets as $ticket)
                    <a href="{{ route('support.show', $ticket) }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ticket->subject }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $ticket->category ? str_replace('_', ' ', ucfirst($ticket->category)) . ' · ' : '' }}{{ $ticket->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            @php
                                $statusColors = ['open' => 'green', 'in_progress' => 'blue', 'resolved' => 'purple', 'closed' => 'gray'];
                                $c = $statusColors[$ticket->status] ?? 'gray';
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-{{ $c }}-100 text-{{ $c }}-700 dark:bg-{{ $c }}-900 dark:text-{{ $c }}-300">
                                {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                            </span>
                            @php
                                $prioColors = ['low' => 'gray', 'medium' => 'yellow', 'high' => 'red'];
                                $pc = $prioColors[$ticket->priority] ?? 'gray';
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-{{ $pc }}-100 text-{{ $pc }}-700 dark:bg-{{ $pc }}-900 dark:text-{{ $pc }}-300">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="px-5 py-12 text-center">
                        <x-phosphor-lifebuoy class="h-10 w-10 text-gray-300 dark:text-gray-600 mx-auto mb-3" />
                        <p class="text-sm text-gray-500">No support tickets yet.</p>
                        <a href="{{ route('support.create') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium mt-1 inline-block">Create your first ticket</a>
                    </div>
                @endforelse
            </div>
        </div>

        {{ $tickets->links() }}
    </div>
</x-layouts.app>
