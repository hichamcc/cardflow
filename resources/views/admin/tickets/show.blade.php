<x-layouts.admin :title="$ticket->subject">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-4xl">
        <div class="flex items-start justify-between">
            <div>
                <x-heading size="xl" level="1">{{ $ticket->subject }}</x-heading>
                <x-subheading>
                    {{ $ticket->user->name }}
                    @if($ticket->user->subscription_tier !== 'free')
                        @php $tierColor = $ticket->user->isPro() ? 'blue' : 'purple'; @endphp
                        <span class="inline-flex items-center rounded-full px-1.5 py-0.5 text-[10px] font-medium bg-{{ $tierColor }}-100 text-{{ $tierColor }}-700 dark:bg-{{ $tierColor }}-900/30 dark:text-{{ $tierColor }}-400">
                            {{ ucfirst($ticket->user->subscription_tier) }}
                        </span>
                    @endif
                    &middot; {{ $ticket->created_at->format('M j, Y g:ia') }}
                    @if ($ticket->category)
                        &middot; {{ str_replace('_', ' ', ucfirst($ticket->category)) }}
                    @endif
                </x-subheading>
            </div>
            {{-- Status Update --}}
            <form method="POST" action="{{ route('admin.tickets.update-status', $ticket) }}" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                    @foreach (['open', 'in_progress', 'resolved', 'closed'] as $status)
                        <option value="{{ $status }}" {{ $ticket->status === $status ? 'selected' : '' }}>{{ str_replace('_', ' ', ucfirst($status)) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-gray-600 px-3 py-2 text-sm font-medium text-white hover:bg-gray-700">Update</button>
            </form>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- Ticket Info --}}
        <div class="flex gap-3">
            @php
                $statusColors = ['open' => 'green', 'in_progress' => 'blue', 'resolved' => 'purple', 'closed' => 'gray'];
                $prioColors = ['low' => 'gray', 'medium' => 'yellow', 'high' => 'red'];
            @endphp
            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-{{ $statusColors[$ticket->status] ?? 'gray' }}-100 text-{{ $statusColors[$ticket->status] ?? 'gray' }}-700 dark:bg-{{ $statusColors[$ticket->status] ?? 'gray' }}-900 dark:text-{{ $statusColors[$ticket->status] ?? 'gray' }}-300">
                {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
            </span>
            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-{{ $prioColors[$ticket->priority] ?? 'gray' }}-100 text-{{ $prioColors[$ticket->priority] ?? 'gray' }}-700 dark:bg-{{ $prioColors[$ticket->priority] ?? 'gray' }}-900 dark:text-{{ $prioColors[$ticket->priority] ?? 'gray' }}-300">
                {{ ucfirst($ticket->priority) }} Priority
            </span>
        </div>

        {{-- Conversation --}}
        <div class="space-y-4">
            @foreach ($ticket->messages as $msg)
                <div class="rounded-xl border p-4 {{ $msg->is_admin_reply ? 'border-blue-200 bg-blue-50 dark:border-blue-800 dark:bg-blue-900/20' : 'border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900' }}">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="shrink-0 size-7 rounded-full {{ $msg->is_admin_reply ? 'bg-blue-600' : 'bg-gradient-to-br from-blue-500 to-purple-600' }} flex items-center justify-center">
                            <span class="text-[10px] font-bold text-white">{{ $msg->user->initials() }}</span>
                        </div>
                        <span class="text-sm font-medium {{ $msg->is_admin_reply ? 'text-blue-700 dark:text-blue-300' : 'text-gray-900 dark:text-white' }}">
                            {{ $msg->user->name }}
                            @if ($msg->is_admin_reply) <span class="text-xs font-normal text-blue-500">(Admin)</span> @endif
                        </span>
                        <span class="text-xs text-gray-400 ml-auto">{{ $msg->created_at->format('M j, g:ia') }}</span>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $msg->message }}</p>
                </div>
            @endforeach
        </div>

        {{-- Reply Form --}}
        @if ($ticket->isOpen())
            <form method="POST" action="{{ route('admin.tickets.reply', $ticket) }}" class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                @csrf
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reply as Admin</label>
                <textarea name="message" id="message" rows="4" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-600 dark:bg-gray-800 dark:text-white" placeholder="Type your reply...">{{ old('message') }}</textarea>
                @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                <button type="submit" class="mt-3 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Send Reply</button>
            </form>
        @endif
    </div>
</x-layouts.admin>
