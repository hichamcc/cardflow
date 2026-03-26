<x-layouts.admin :title="__('Contact Submission')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-3xl">
        <div class="flex items-center justify-between">
            <div>
                <x-heading size="xl" level="1">{{ $submission->name }}</x-heading>
                <x-subheading>{{ $submission->email }} &middot; {{ $submission->created_at->format('M j, Y g:ia') }}</x-subheading>
            </div>
            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route('admin.contacts.mark-read', $submission) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        @if ($submission->is_read)
                            <x-phosphor-envelope-simple class="h-4 w-4" />
                            Mark Unread
                        @else
                            <x-phosphor-envelope-simple-open class="h-4 w-4" />
                            Mark Read
                        @endif
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.contacts.destroy', $submission) }}" onsubmit="return confirm('Delete this submission?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-300 bg-red-50 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-100 dark:border-red-600 dark:bg-red-900/30 dark:text-red-300">
                        <x-phosphor-trash class="h-4 w-4" />
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
            @if ($submission->subject)
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $submission->subject }}</h3>
            @endif
            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $submission->message }}</p>
        </div>

        <div class="flex gap-3 text-sm">
            <span class="inline-flex items-center gap-1 text-gray-500">
                @if ($submission->is_read)
                    <x-phosphor-check-circle class="h-4 w-4 text-green-500" /> Read
                @else
                    <x-phosphor-circle class="h-4 w-4 text-blue-500" /> Unread
                @endif
            </span>
        </div>
    </div>
</x-layouts.admin>
