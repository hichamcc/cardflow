@php
    $borderColor = match($variant) {
        'overdue' => 'border-l-red-500',
        'today' => 'border-l-amber-500',
        'upcoming' => 'border-l-blue-500',
        'completed' => 'border-l-green-500',
        default => 'border-l-gray-300',
    };
@endphp

<div class="flex items-center gap-4 rounded-lg border border-gray-200 border-l-4 {{ $borderColor }} bg-white px-4 py-3 dark:border-gray-700 dark:bg-gray-900">
    <div class="flex-1 min-w-0">
        <a href="{{ route('contacts.show', $followUp->saved_card_id) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 dark:text-white dark:hover:text-blue-400">
            {{ $followUp->savedCard->businessCard->full_name ?? __('Unknown Contact') }}
        </a>
        @if($followUp->savedCard->businessCard->company_name ?? false)
            <span class="text-xs text-gray-500 dark:text-gray-400"> &middot; {{ $followUp->savedCard->businessCard->company_name }}</span>
        @endif
        @if($followUp->notes)
            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400 truncate">{{ $followUp->notes }}</p>
        @endif
    </div>

    <div class="text-right shrink-0">
        <p class="text-xs font-medium {{ $variant === 'overdue' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
            {{ $followUp->follow_up_date->format('M j, Y') }}
        </p>
        @if($variant === 'overdue')
            <p class="text-xs text-red-500">{{ $followUp->follow_up_date->diffForHumans() }}</p>
        @endif
    </div>

    @if($variant !== 'completed')
        <div class="flex items-center gap-1 shrink-0">
            <x-form method="patch" action="{{ route('follow-ups.complete', $followUp) }}">
                <button type="submit" title="{{ __('Mark Complete') }}" class="p-1.5 text-gray-400 hover:text-green-500">
                    <x-phosphor-check-circle class="h-5 w-5" />
                </button>
            </x-form>
            <x-form method="patch" action="{{ route('follow-ups.cancel', $followUp) }}">
                <button type="submit" title="{{ __('Cancel') }}" class="p-1.5 text-gray-400 hover:text-amber-500">
                    <x-phosphor-x-circle class="h-5 w-5" />
                </button>
            </x-form>
        </div>
    @else
        <span class="text-xs text-green-600 dark:text-green-400 font-medium">{{ __('Done') }}</span>
    @endif
</div>
