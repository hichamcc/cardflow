<x-layouts.app :title="$contact->getFullName()">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('contacts.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Contacts') }}
            </a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div class="flex items-start gap-4">
                    @if($contact->getProfilePhotoUrl())
                        <img src="{{ $contact->getProfilePhotoUrl() }}" alt="{{ $contact->getFullName() }}" class="h-16 w-16 shrink-0 rounded-full object-cover">
                    @else
                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-gray-100 text-2xl font-bold text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                            {{ strtoupper(substr($contact->getFullName(), 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $contact->getFullName() }}</h1>
                        @if($contact->getJobTitle())
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $contact->getJobTitle() }}</p>
                        @endif
                        @if($contact->getCompanyName())
                            <p class="text-sm text-gray-400 dark:text-gray-500">{{ $contact->getCompanyName() }}</p>
                        @endif
                        @if($contact->relationship_status)
                            @php
                                $statusColors = [
                                    'lead' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'prospect' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                    'client' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                    'partner' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                    'other' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                ];
                            @endphp
                            <span class="mt-1.5 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$contact->relationship_status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($contact->relationship_status) }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if($contact->getPhone())
                        <a href="tel:{{ $contact->getPhone() }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-phone class="h-4 w-4" />
                            {{ __('Call') }}
                        </a>
                    @endif
                    @if($contact->getEmail())
                        <a href="mailto:{{ $contact->getEmail() }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-envelope class="h-4 w-4" />
                            {{ __('Email') }}
                        </a>
                    @endif
                    @if($contact->isLinkedCard())
                        <a href="{{ route('public.card.show', $contact->businessCard->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-arrow-square-out class="h-4 w-4" />
                            {{ __('View Card') }}
                        </a>
                    @endif
                    @if($contact->isManualClient())
                        <a href="{{ route('contacts.edit', $contact) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-pencil class="h-4 w-4" />
                            {{ __('Edit') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="flex flex-col gap-6 lg:col-span-2">
                {{-- Quick Note --}}
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                    <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                        <x-heading size="base">{{ __('Quick Note') }}</x-heading>
                    </div>
                    <div class="p-5">
                        <form method="POST" action="{{ route('contacts.update', $contact) }}">
                            @csrf
                            @method('PUT')
                            <textarea name="custom_note" rows="3" placeholder="{{ __('Add personal notes about this contact...') }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">{{ old('custom_note', $contact->custom_note) }}</textarea>
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                    <x-phosphor-floppy-disk class="h-4 w-4" />
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Activity Timeline --}}
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                    <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                        <x-heading size="base">{{ __('Activity Timeline') }}</x-heading>
                    </div>
                    @if($timeline->isNotEmpty())
                        <div class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($timeline as $entry)
                                <div class="flex items-start gap-3 px-5 py-3">
                                    {{-- Icon --}}
                                    @if($entry['type'] === 'interaction')
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                                            <x-dynamic-component :component="'phosphor-' . $entry['item']->getTypeIcon()" class="h-4 w-4 text-blue-600 dark:text-blue-400" />
                                        </div>
                                    @elseif($entry['type'] === 'follow_up')
                                        @php
                                            $fu = $entry['item'];
                                            $fuBg = $fu->status === 'completed' ? 'bg-green-100 dark:bg-green-900/30' : ($fu->isOverdue() ? 'bg-red-100 dark:bg-red-900/30' : 'bg-amber-100 dark:bg-amber-900/30');
                                        @endphp
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $fuBg }}">
                                            @if($fu->status === 'completed')
                                                <x-phosphor-check-circle class="h-4 w-4 text-green-600 dark:text-green-400" />
                                            @elseif($fu->isOverdue())
                                                <x-phosphor-warning class="h-4 w-4 text-red-600 dark:text-red-400" />
                                            @else
                                                <x-phosphor-clock class="h-4 w-4 text-amber-600 dark:text-amber-400" />
                                            @endif
                                        </div>
                                    @elseif($entry['type'] === 'deal')
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                                            <x-phosphor-currency-circle-dollar class="h-4 w-4 text-emerald-600 dark:text-emerald-400" />
                                        </div>
                                    @elseif($entry['type'] === 'note')
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                            <x-phosphor-note-pencil class="h-4 w-4 text-gray-600 dark:text-gray-400" />
                                        </div>
                                    @endif

                                    {{-- Content --}}
                                    <div class="min-w-0 flex-1">
                                        @if($entry['type'] === 'interaction')
                                            <p class="text-sm text-gray-900 dark:text-white">
                                                <span class="font-medium">{{ ucfirst($entry['item']->interaction_type) }}</span>
                                                @if($entry['item']->subject)
                                                    <span class="text-gray-600 dark:text-gray-300">- {{ $entry['item']->subject }}</span>
                                                @endif
                                            </p>
                                            @if($entry['item']->notes)
                                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400 line-clamp-1">{{ $entry['item']->notes }}</p>
                                            @endif
                                        @elseif($entry['type'] === 'follow_up')
                                            <p class="text-sm text-gray-900 dark:text-white">
                                                <span class="font-medium">{{ __('Follow-up') }}</span>
                                                <span class="inline-flex ml-1.5 items-center rounded-full px-1.5 py-0.5 text-[10px] font-medium
                                                    {{ $entry['item']->status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                                    {{ $entry['item']->status === 'pending' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : '' }}
                                                    {{ $entry['item']->status === 'cancelled' ? 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' : '' }}
                                                ">{{ ucfirst($entry['item']->status) }}</span>
                                            </p>
                                            @if($entry['item']->notes)
                                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400 line-clamp-1">{{ $entry['item']->notes }}</p>
                                            @endif
                                        @elseif($entry['type'] === 'deal')
                                            <p class="text-sm text-gray-900 dark:text-white">
                                                <a href="{{ route('deals.show', $entry['item']) }}" class="font-medium hover:text-blue-600 dark:hover:text-blue-400">{{ $entry['item']->deal_name }}</a>
                                                <span class="text-gray-500 dark:text-gray-400">&middot; ${{ number_format($entry['item']->deal_value, 0) }}</span>
                                            </p>
                                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $entry['item']->stage)) }}</p>
                                        @elseif($entry['type'] === 'note')
                                            <p class="text-sm text-gray-900 dark:text-white">
                                                <a href="{{ route('notes.show', $entry['item']) }}" class="font-medium hover:text-blue-600 dark:hover:text-blue-400">{{ $entry['item']->title ?? __('Untitled Note') }}</a>
                                            </p>
                                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400 line-clamp-1">{{ Str::limit($entry['item']->content, 80) }}</p>
                                        @endif
                                    </div>

                                    {{-- Timestamp --}}
                                    <span class="shrink-0 text-xs text-gray-400 dark:text-gray-500">{{ $entry['date']->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="px-5 py-8 text-center">
                            <x-phosphor-clock-counter-clockwise class="mx-auto h-8 w-8 text-gray-300 dark:text-gray-600" />
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('No activity yet. Log an interaction or create a note to get started.') }}</p>
                        </div>
                    @endif
                </div>

                {{-- Events --}}
                @if($contact->events->isNotEmpty())
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                    <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                        <x-heading size="base">{{ __('Upcoming Events') }}</x-heading>
                        <a href="{{ route('events.create', ['contact' => $contact->id]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">{{ __('+ New Event') }}</a>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($contact->events as $event)
                            <a href="{{ route('events.show', $event) }}" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full" style="background-color: {{ $event->color ?? '#6B7280' }}20; color: {{ $event->color ?? '#6B7280' }}">
                                    <x-dynamic-component :component="'phosphor-' . $event->getTypeIcon()" class="h-4 w-4" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $event->title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $event->start_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Deals --}}
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                    <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                        <x-heading size="base">{{ __('Deals') }}</x-heading>
                        <a href="{{ route('deals.create', ['contact' => $contact->id]) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">{{ __('+ New Deal') }}</a>
                    </div>
                    {{-- Inline Create --}}
                    <div class="border-b border-gray-200 p-5 dark:border-gray-700">
                        <form method="POST" action="{{ route('deals.store') }}" class="space-y-3">
                            @csrf
                            <input type="hidden" name="saved_card_id" value="{{ $contact->id }}">
                            <input type="hidden" name="redirect_to_contact" value="1">
                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label for="deal_name" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Deal Name') }}</label>
                                    <input type="text" name="deal_name" id="deal_name" required placeholder="{{ __('e.g. Website Project') }}" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                                </div>
                                <div>
                                    <label for="deal_value_inline" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Value ($)') }}</label>
                                    <input type="number" name="deal_value" id="deal_value_inline" step="0.01" min="0" value="0" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                    <x-phosphor-plus class="h-4 w-4" />
                                    {{ __('Add Deal') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($contact->deals as $deal)
                            <div class="flex items-center gap-3 px-5 py-3">
                                @php
                                    $dealColors = ['lead' => 'blue', 'negotiation' => 'amber', 'closed_won' => 'green', 'closed_lost' => 'red'];
                                    $dc = $dealColors[$deal->stage] ?? 'gray';
                                @endphp
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-{{ $dc }}-100 dark:bg-{{ $dc }}-900/30">
                                    <x-phosphor-currency-circle-dollar class="h-4 w-4 text-{{ $dc }}-600 dark:text-{{ $dc }}-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <a href="{{ route('deals.show', $deal) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 dark:text-white dark:hover:text-blue-400">{{ $deal->deal_name }}</a>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">${{ number_format($deal->deal_value, 0) }} &middot; {{ ucfirst(str_replace('_', ' ', $deal->stage)) }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-5 py-8 text-center">
                                <x-phosphor-currency-circle-dollar class="mx-auto h-8 w-8 text-gray-300 dark:text-gray-600" />
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('No deals yet.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Interactions --}}
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                    <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                        <x-heading size="base">{{ __('Interactions') }}</x-heading>
                    </div>
                    <div class="border-b border-gray-200 p-5 dark:border-gray-700">
                        <form method="POST" action="{{ route('interactions.store', $contact) }}" class="space-y-3">
                            @csrf
                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label for="interaction_type" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Type') }}</label>
                                    <select id="interaction_type" name="interaction_type" required class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                        <option value="email">{{ __('Email') }}</option>
                                        <option value="call">{{ __('Call') }}</option>
                                        <option value="meeting">{{ __('Meeting') }}</option>
                                        <option value="note">{{ __('Note') }}</option>
                                        <option value="other">{{ __('Other') }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="interaction_date" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Date') }}</label>
                                    <input type="date" id="interaction_date" name="interaction_date" value="{{ now()->format('Y-m-d') }}" required class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label for="subject" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Subject') }}</label>
                                <input type="text" id="subject" name="subject" placeholder="{{ __('Brief summary...') }}" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="interaction_notes" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Notes') }}</label>
                                <textarea id="interaction_notes" name="notes" rows="2" placeholder="{{ __('Optional details...') }}" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                    <x-phosphor-plus class="h-4 w-4" />
                                    {{ __('Add Interaction') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($contact->interactions as $interaction)
                            <div class="flex items-start gap-3 px-5 py-4">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                    <x-dynamic-component :component="'phosphor-' . $interaction->getTypeIcon()" class="h-4 w-4 text-gray-600 dark:text-gray-400" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ ucfirst($interaction->interaction_type) }}
                                            @if($interaction->subject)
                                                <span class="font-normal text-gray-600 dark:text-gray-300">- {{ $interaction->subject }}</span>
                                            @endif
                                        </p>
                                        <span class="shrink-0 text-xs text-gray-400 dark:text-gray-500">{{ $interaction->interaction_date->format('M d, Y') }}</span>
                                    </div>
                                    @if($interaction->notes)
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $interaction->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="px-5 py-8 text-center">
                                <x-phosphor-chat-circle class="mx-auto h-8 w-8 text-gray-300 dark:text-gray-600" />
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('No interactions logged yet.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Follow-ups --}}
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                    <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                        <x-heading size="base">{{ __('Follow-ups') }}</x-heading>
                    </div>
                    <div class="border-b border-gray-200 p-5 dark:border-gray-700">
                        <form method="POST" action="{{ route('follow-ups.store', $contact) }}" class="space-y-3">
                            @csrf
                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label for="follow_up_date" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Follow-up Date') }}</label>
                                    <input type="date" id="follow_up_date" name="follow_up_date" required min="{{ now()->format('Y-m-d') }}" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                </div>
                                <div>
                                    <label for="reminder_date" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Reminder Date') }}</label>
                                    <input type="date" id="reminder_date" name="reminder_date" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>
                            <div>
                                <label for="follow_up_notes" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Notes') }}</label>
                                <textarea id="follow_up_notes" name="notes" rows="2" placeholder="{{ __('What do you need to follow up on?') }}" class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                    <x-phosphor-calendar-plus class="h-4 w-4" />
                                    {{ __('Schedule Follow-up') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($contact->followUps as $followUp)
                            <div class="flex items-start gap-3 px-5 py-4">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full {{ $followUp->status === 'completed' ? 'bg-green-100 dark:bg-green-900/30' : ($followUp->isOverdue() ? 'bg-red-100 dark:bg-red-900/30' : 'bg-amber-100 dark:bg-amber-900/30') }}">
                                    @if($followUp->status === 'completed')
                                        <x-phosphor-check-circle class="h-4 w-4 text-green-600 dark:text-green-400" />
                                    @elseif($followUp->status === 'cancelled')
                                        <x-phosphor-x-circle class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                                    @elseif($followUp->isOverdue())
                                        <x-phosphor-warning class="h-4 w-4 text-red-600 dark:text-red-400" />
                                    @else
                                        <x-phosphor-clock class="h-4 w-4 text-amber-600 dark:text-amber-400" />
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $followUp->follow_up_date->format('M d, Y') }}
                                            @if($followUp->isOverdue())
                                                <span class="ml-1 text-xs font-medium text-red-600 dark:text-red-400">{{ __('Overdue') }}</span>
                                            @endif
                                        </p>
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                            {{ $followUp->status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                            {{ $followUp->status === 'pending' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : '' }}
                                            {{ $followUp->status === 'cancelled' ? 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' : '' }}
                                        ">
                                            {{ ucfirst($followUp->status) }}
                                        </span>
                                    </div>
                                    @if($followUp->notes)
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $followUp->notes }}</p>
                                    @endif
                                    @if($followUp->isPending())
                                        <div class="mt-2 flex gap-2">
                                            <form method="POST" action="{{ route('follow-ups.complete', $followUp) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700 transition hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/40">
                                                    <x-phosphor-check class="h-3 w-3" />
                                                    {{ __('Complete') }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('follow-ups.cancel', $followUp) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-gray-50 px-2.5 py-1 text-xs font-medium text-gray-600 transition hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                                                    <x-phosphor-x class="h-3 w-3" />
                                                    {{ __('Cancel') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="px-5 py-8 text-center">
                                <x-phosphor-calendar-blank class="mx-auto h-8 w-8 text-gray-300 dark:text-gray-600" />
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('No follow-ups scheduled.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="flex flex-col gap-6">
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                    <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                        <x-heading size="base">{{ __('Contact Details') }}</x-heading>
                    </div>
                    <div class="space-y-3 p-5">
                        @if($contact->getEmail())
                            <div>
                                <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Email') }}</p>
                                <a href="mailto:{{ $contact->getEmail() }}" class="text-sm text-gray-900 hover:underline dark:text-white">{{ $contact->getEmail() }}</a>
                            </div>
                        @endif
                        @if($contact->getPhone())
                            <div>
                                <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Phone') }}</p>
                                <a href="tel:{{ $contact->getPhone() }}" class="text-sm text-gray-900 hover:underline dark:text-white">{{ $contact->getPhone() }}</a>
                            </div>
                        @endif
                        @if($contact->getWebsite())
                            <div>
                                <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Website') }}</p>
                                <a href="{{ $contact->getWebsite() }}" target="_blank" rel="noopener noreferrer" class="text-sm text-blue-600 hover:underline dark:text-blue-400 break-all">{{ $contact->getWebsite() }}</a>
                            </div>
                        @endif
                        @if($contact->isLinkedCard() && $contact->businessCard->socialLinks->isNotEmpty())
                            <div>
                                <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Social') }}</p>
                                <div class="mt-1 flex flex-wrap gap-2">
                                    @foreach($contact->businessCard->socialLinks as $link)
                                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <x-dynamic-component :component="'phosphor-' . $link->getPlatformIcon()" class="h-3 w-3" />
                                            {{ ucfirst($link->platform) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($contact->isLinkedCard() && $contact->businessCard->customFields->isNotEmpty())
                            @foreach($contact->businessCard->customFields as $field)
                                <div>
                                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ $field->field_name }}</p>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $field->field_value }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                    <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                        <x-heading size="base">{{ __('Organization') }}</x-heading>
                    </div>
                    <div class="p-5">
                        <form method="POST" action="{{ route('contacts.update', $contact) }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="folder_id" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Folder') }}</label>
                                <select id="folder_id" name="folder_id" class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="">{{ __('No Folder') }}</option>
                                    @foreach($folders as $f)
                                        <option value="{{ $f->id }}" {{ $contact->folder_id == $f->id ? 'selected' : '' }}>{{ $f->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="relationship_status" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Relationship Status') }}</label>
                                <select id="relationship_status" name="relationship_status" class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="lead" {{ $contact->relationship_status === 'lead' ? 'selected' : '' }}>{{ __('Lead') }}</option>
                                    <option value="prospect" {{ $contact->relationship_status === 'prospect' ? 'selected' : '' }}>{{ __('Prospect') }}</option>
                                    <option value="client" {{ $contact->relationship_status === 'client' ? 'selected' : '' }}>{{ __('Client') }}</option>
                                    <option value="partner" {{ $contact->relationship_status === 'partner' ? 'selected' : '' }}>{{ __('Partner') }}</option>
                                    <option value="other" {{ $contact->relationship_status === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="contact_frequency" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Contact Frequency') }}</label>
                                <select id="contact_frequency" name="contact_frequency" class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="high" {{ $contact->contact_frequency === 'high' ? 'selected' : '' }}>{{ __('High (Weekly)') }}</option>
                                    <option value="medium" {{ $contact->contact_frequency === 'medium' ? 'selected' : '' }}>{{ __('Medium (Bi-weekly)') }}</option>
                                    <option value="low" {{ $contact->contact_frequency === 'low' ? 'selected' : '' }}>{{ __('Low (Monthly)') }}</option>
                                    <option value="never" {{ $contact->contact_frequency === 'never' ? 'selected' : '' }}>{{ __('Never') }}</option>
                                </select>
                            </div>
                            <div>
                                <p class="mb-2 text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Tags') }}</p>
                                <div class="max-h-40 space-y-2 overflow-y-auto">
                                    @foreach($tags as $tag)
                                        <label class="flex items-center gap-2">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ $contact->tags->contains($tag->id) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800">
                                            <span class="text-sm text-gray-700 dark:text-gray-300" @if($tag->color) style="color: {{ $tag->color }}" @endif>{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @if($tags->isEmpty())
                                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('No tags created yet.') }}</p>
                                @endif
                            </div>
                            <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                {{ __('Update') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                    <div class="space-y-2 text-xs text-gray-400 dark:text-gray-500">
                        <div class="flex justify-between">
                            <span>{{ $contact->isManualClient() ? __('Created on') : __('Saved on') }}</span>
                            <span class="text-gray-600 dark:text-gray-300">{{ $contact->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($contact->last_contacted_at)
                            <div class="flex justify-between">
                                <span>{{ __('Last contacted') }}</span>
                                <span class="text-gray-600 dark:text-gray-300">{{ $contact->last_contacted_at->diffForHumans() }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span>{{ __('Interactions') }}</span>
                            <span class="text-gray-600 dark:text-gray-300">{{ $contact->interactions->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>{{ __('Follow-ups') }}</span>
                            <span class="text-gray-600 dark:text-gray-300">{{ $contact->followUps->where('status', 'pending')->count() }} {{ __('pending') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
