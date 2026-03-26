<x-layouts.app :title="__('Follow-ups')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('Follow-ups') }}</x-heading>
                <x-subheading>{{ __('Stay on top of your relationship-building tasks.') }}</x-subheading>
            </div>
            @if($contacts->isNotEmpty())
                <button
                    x-data
                    @click="$dispatch('open-followup-modal')"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
                >
                    <x-phosphor-plus class="h-4 w-4" />
                    {{ __('New Follow-up') }}
                </button>
            @endif
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        {{-- New Follow-up Modal --}}
        @if($contacts->isNotEmpty())
        <div
            x-data="{ open: false, contactId: '' }"
            x-show="open"
            x-cloak
            @open-followup-modal.window="open = true"
            @keydown.escape.window="open = false"
            class="fixed inset-0 z-50 flex items-center justify-center"
        >
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/40" @click="open = false"></div>

            {{-- Modal --}}
            <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800" @click.stop>
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Schedule a Follow-up') }}</h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <x-phosphor-x class="h-5 w-5" />
                    </button>
                </div>

                <form method="POST" :action="'/contacts/' + contactId + '/follow-ups'" class="space-y-4">
                    @csrf

                    {{-- Contact Select --}}
                    <div>
                        <label for="modal_contact" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Contact') }}</label>
                        <select
                            id="modal_contact"
                            x-model="contactId"
                            required
                            class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">{{ __('Select a contact...') }}</option>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact['id'] }}">{{ $contact['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Follow-up Date --}}
                    <div>
                        <label for="modal_follow_up_date" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Follow-up Date') }}</label>
                        <input type="date" id="modal_follow_up_date" name="follow_up_date" required min="{{ now()->format('Y-m-d') }}" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    {{-- Reminder Date --}}
                    <div>
                        <label for="modal_reminder_date" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Reminder Date') }} <span class="text-gray-400">({{ __('optional') }})</span></label>
                        <input type="date" id="modal_reminder_date" name="reminder_date" min="{{ now()->format('Y-m-d') }}" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label for="modal_notes" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Notes') }} <span class="text-gray-400">({{ __('optional') }})</span></label>
                        <textarea id="modal_notes" name="notes" rows="3" placeholder="{{ __('What do you need to follow up on?') }}" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500"></textarea>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="open = false" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit" :disabled="!contactId" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            <x-phosphor-clock-countdown class="h-4 w-4" />
                            {{ __('Schedule Follow-up') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        {{-- Overdue --}}
        @if($overdue->isNotEmpty())
        <div>
            <h3 class="flex items-center gap-2 text-sm font-semibold text-red-600 dark:text-red-400 mb-3">
                <x-phosphor-warning class="h-4 w-4" />
                {{ __('Overdue') }} ({{ $overdue->count() }})
            </h3>
            <div class="space-y-2">
                @foreach($overdue as $followUp)
                    @include('follow-ups._item', ['followUp' => $followUp, 'variant' => 'overdue'])
                @endforeach
            </div>
        </div>
        @endif

        {{-- Due Today --}}
        <div>
            <h3 class="flex items-center gap-2 text-sm font-semibold text-amber-600 dark:text-amber-400 mb-3">
                <x-phosphor-clock class="h-4 w-4" />
                {{ __('Due Today') }} ({{ $today->count() }})
            </h3>
            @if($today->isNotEmpty())
                <div class="space-y-2">
                    @foreach($today as $followUp)
                        @include('follow-ups._item', ['followUp' => $followUp, 'variant' => 'today'])
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Nothing due today.') }}</p>
            @endif
        </div>

        {{-- Upcoming --}}
        <div>
            <h3 class="flex items-center gap-2 text-sm font-semibold text-blue-600 dark:text-blue-400 mb-3">
                <x-phosphor-calendar class="h-4 w-4" />
                {{ __('Upcoming') }} ({{ $upcoming->count() }})
            </h3>
            @if($upcoming->isNotEmpty())
                <div class="space-y-2">
                    @foreach($upcoming as $followUp)
                        @include('follow-ups._item', ['followUp' => $followUp, 'variant' => 'upcoming'])
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No upcoming follow-ups.') }}</p>
            @endif
        </div>

        {{-- Completed --}}
        @if($completed->isNotEmpty())
        <div>
            <h3 class="flex items-center gap-2 text-sm font-semibold text-green-600 dark:text-green-400 mb-3">
                <x-phosphor-check-circle class="h-4 w-4" />
                {{ __('Recently Completed') }} ({{ $completed->count() }})
            </h3>
            <div class="space-y-2 opacity-75">
                @foreach($completed as $followUp)
                    @include('follow-ups._item', ['followUp' => $followUp, 'variant' => 'completed'])
                @endforeach
            </div>
        </div>
        @endif

        @if($overdue->isEmpty() && $today->isEmpty() && $upcoming->isEmpty() && $completed->isEmpty())
            <div class="py-12 text-center">
                <x-phosphor-bell-ringing class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" />
                <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">{{ __('No follow-ups scheduled yet.') }}</p>
                @if($contacts->isNotEmpty())
                    <button
                        x-data
                        @click="$dispatch('open-followup-modal')"
                        class="mt-2 inline-block text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400"
                    >
                        {{ __('Schedule your first follow-up') }}
                    </button>
                @else
                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">{{ __('Add contacts first, then you can schedule follow-ups for them.') }}</p>
                    <a href="{{ route('contacts.index') }}" class="mt-2 inline-block text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">
                        {{ __('Go to Contacts') }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</x-layouts.app>
