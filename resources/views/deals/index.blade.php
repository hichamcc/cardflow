<x-layouts.app :title="__('Deals')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('Deal Pipeline') }}</x-heading>
                <x-subheading>{{ __('Track and manage your deals') }}</x-subheading>
            </div>
            <a href="{{ route('deals.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                <x-phosphor-plus class="h-4 w-4" />
                {{ __('New Deal') }}
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pipeline Board --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach($stages as $stageKey => $stageLabel)
                @php
                    $stageColors = [
                        'lead' => 'blue',
                        'negotiation' => 'amber',
                        'closed_won' => 'green',
                        'closed_lost' => 'red',
                    ];
                    $color = $stageColors[$stageKey];
                    $stageDeals = $deals->get($stageKey, collect());
                @endphp
                <div class="flex flex-col rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800/50">
                    {{-- Stage Header --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-{{ $color }}-100 text-{{ $color }}-600 dark:bg-{{ $color }}-900/30 dark:text-{{ $color }}-400">
                                <span class="text-xs font-bold">{{ $stageDeals->count() }}</span>
                            </span>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $stageLabel }}</h3>
                        </div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            ${{ number_format($totals[$stageKey], 0) }}
                        </span>
                    </div>

                    {{-- Deal Cards --}}
                    <div class="flex flex-col gap-2 p-3 min-h-[120px]">
                        @forelse($stageDeals as $deal)
                            <div class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                                <a href="{{ route('deals.show', $deal) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 dark:text-white dark:hover:text-blue-400">
                                    {{ $deal->deal_name }}
                                </a>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $deal->savedCard ? $deal->savedCard->getFullName() : __('No contact') }}
                                </p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                        ${{ number_format($deal->deal_value, 0) }}
                                    </span>
                                    @if($deal->expected_close_date)
                                        <span class="text-xs text-gray-400 dark:text-gray-500">
                                            {{ $deal->expected_close_date->format('M d') }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Quick Stage Change --}}
                                @if($deal->isOpen())
                                    <div class="mt-2 flex gap-1">
                                        @if($stageKey === 'lead')
                                            <form method="POST" action="{{ route('deals.update-stage', $deal) }}">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="stage" value="negotiation">
                                                <button type="submit" class="rounded bg-amber-50 px-2 py-0.5 text-[10px] font-medium text-amber-700 hover:bg-amber-100 dark:bg-amber-900/20 dark:text-amber-400">{{ __('Negotiate') }}</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('deals.update-stage', $deal) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="stage" value="closed_won">
                                            <button type="submit" class="rounded bg-green-50 px-2 py-0.5 text-[10px] font-medium text-green-700 hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400">{{ __('Won') }}</button>
                                        </form>
                                        <form method="POST" action="{{ route('deals.update-stage', $deal) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="stage" value="closed_lost">
                                            <button type="submit" class="rounded bg-red-50 px-2 py-0.5 text-[10px] font-medium text-red-700 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400">{{ __('Lost') }}</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="flex flex-1 items-center justify-center py-6">
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('No deals') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>
