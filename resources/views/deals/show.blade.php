<x-layouts.app :title="$deal->deal_name">
    <div class="flex h-full w-full flex-1 flex-col gap-6 max-w-3xl">
        <div>
            <a href="{{ route('deals.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Deals') }}
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $deal->deal_name }}</h1>
                    @if($deal->savedCard)
                        <a href="{{ route('contacts.show', $deal->savedCard) }}" class="mt-1 text-sm text-blue-600 hover:underline dark:text-blue-400">
                            {{ $deal->savedCard->getFullName() }}
                        </a>
                    @endif
                </div>
                <a href="{{ route('deals.edit', $deal) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <x-phosphor-pencil class="h-4 w-4" />
                    {{ __('Edit') }}
                </a>
            </div>

            <div class="mt-4 flex flex-wrap gap-3">
                @php
                    $stageColors = [
                        'lead' => 'blue',
                        'negotiation' => 'amber',
                        'closed_won' => 'green',
                        'closed_lost' => 'red',
                    ];
                    $stageLabels = [
                        'lead' => 'Lead',
                        'negotiation' => 'Negotiation',
                        'closed_won' => 'Won',
                        'closed_lost' => 'Lost',
                    ];
                    $c = $stageColors[$deal->stage] ?? 'gray';
                @endphp
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-{{ $c }}-100 text-{{ $c }}-700 dark:bg-{{ $c }}-900/30 dark:text-{{ $c }}-400">
                    {{ $stageLabels[$deal->stage] ?? ucfirst($deal->stage) }}
                </span>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <div>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Value') }}</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">${{ number_format($deal->deal_value, 2) }} {{ $deal->currency }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Expected Close') }}</p>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $deal->expected_close_date ? $deal->expected_close_date->format('M d, Y') : __('Not set') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ __('Created') }}</p>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $deal->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            @if($deal->notes)
                <div class="mt-6">
                    <p class="text-xs font-medium text-gray-400 dark:text-gray-500 mb-1">{{ __('Notes') }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $deal->notes }}</p>
                </div>
            @endif

            {{-- Stage Transitions --}}
            @if($deal->isOpen())
                <div class="mt-6 flex gap-2 border-t border-gray-200 pt-4 dark:border-gray-700">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 self-center mr-2">{{ __('Move to:') }}</span>
                    @if($deal->stage === 'lead')
                        <form method="POST" action="{{ route('deals.update-stage', $deal) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="stage" value="negotiation">
                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-100 dark:bg-amber-900/20 dark:text-amber-400">
                                <x-phosphor-handshake class="h-3.5 w-3.5" />
                                {{ __('Negotiation') }}
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('deals.update-stage', $deal) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="stage" value="closed_won">
                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400">
                            <x-phosphor-trophy class="h-3.5 w-3.5" />
                            {{ __('Won') }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('deals.update-stage', $deal) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="stage" value="closed_lost">
                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400">
                            <x-phosphor-x-circle class="h-3.5 w-3.5" />
                            {{ __('Lost') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
