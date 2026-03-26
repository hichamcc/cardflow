<x-layouts.admin :title="__('Contact Submissions')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <x-heading size="xl" level="1">{{ __('Contact Submissions') }}</x-heading>
            <x-subheading>{{ __('Messages from the landing page contact form') }}</x-subheading>
        </div>

        {{-- Filters --}}
        <div class="flex gap-3">
            <a href="{{ route('admin.contacts.index') }}" class="rounded-lg px-4 py-2 text-sm font-medium {{ ! request('filter') ? 'bg-blue-600 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300' }}">All</a>
            <a href="{{ route('admin.contacts.index', ['filter' => 'unread']) }}" class="rounded-lg px-4 py-2 text-sm font-medium {{ request('filter') === 'unread' ? 'bg-blue-600 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300' }}">Unread</a>
            <a href="{{ route('admin.contacts.index', ['filter' => 'read']) }}" class="rounded-lg px-4 py-2 text-sm font-medium {{ request('filter') === 'read' ? 'bg-blue-600 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300' }}">Read</a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- Submissions Table --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Name</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Email</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Subject</th>
                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Date</th>
                            <th class="px-5 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($submissions as $sub)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 {{ ! $sub->is_read ? 'bg-blue-50/50 dark:bg-blue-900/10' : '' }}">
                                <td class="px-5 py-3">
                                    @if (! $sub->is_read)
                                        <span class="inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                                    @else
                                        <span class="inline-flex h-2 w-2 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $sub->name }}</td>
                                <td class="px-5 py-3 text-sm text-gray-500">{{ $sub->email }}</td>
                                <td class="px-5 py-3 text-sm text-gray-500">{{ $sub->subject ?? '—' }}</td>
                                <td class="px-5 py-3 text-sm text-gray-500">{{ $sub->created_at->diffForHumans() }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.contacts.show', $sub) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500">No submissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $submissions->links() }}
    </div>
</x-layouts.admin>
