<x-layouts.app :title="__('My Cards')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('My Cards') }}</x-heading>
                <x-subheading>{{ __('Manage your digital business cards.') }}</x-subheading>
            </div>
            <a href="{{ route('cards.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                <x-phosphor-plus-bold class="h-4 w-4" />
                {{ __('Create New Card') }}
            </a>
        </div>

        @if($cards->isEmpty())
            {{-- Empty State --}}
            <div class="flex flex-1 flex-col items-center justify-center rounded-xl border border-dashed border-gray-300 bg-white px-6 py-16 dark:border-gray-700 dark:bg-gray-900">
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                    <x-phosphor-identification-card class="h-7 w-7 text-gray-400 dark:text-gray-500" />
                </div>
                <h3 class="mt-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('No business cards yet') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Get started by creating your first digital business card.') }}</p>
                <a href="{{ route('cards.create') }}" class="mt-5 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                    <x-phosphor-plus-bold class="h-4 w-4" />
                    {{ __('Create New Card') }}
                </a>
            </div>
        @else
            {{-- Cards Grid --}}
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($cards as $card)
                    <div class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white transition hover:shadow-md dark:border-gray-700 dark:bg-gray-900">
                        {{-- Theme Color Accent Bar --}}
                        <div class="h-1.5" style="background-color: {{ $card->theme_color }}"></div>

                        <div class="p-5">
                            {{-- Card Header --}}
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-bold text-white" style="background-color: {{ $card->theme_color }}">
                                        {{ strtoupper(substr($card->full_name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $card->card_name }}</h3>
                                        <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $card->full_name }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $card->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                    {{ $card->is_active ? __('Active') : __('Inactive') }}
                                </span>
                            </div>

                            {{-- Card Details --}}
                            <div class="mt-4 space-y-1.5">
                                @if($card->job_title)
                                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                        <x-phosphor-briefcase class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                                        <span class="truncate">{{ $card->job_title }}</span>
                                    </div>
                                @endif
                                @if($card->company_name)
                                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                        <x-phosphor-buildings class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                                        <span class="truncate">{{ $card->company_name }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Views Count --}}
                            <div class="mt-4 flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                                <x-phosphor-eye class="h-3.5 w-3.5" />
                                <span>{{ number_format($card->view_count) }} {{ __('views') }}</span>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-4 flex items-center gap-1 border-t border-gray-100 pt-4 dark:border-gray-800">
                                <a href="{{ route('cards.show', $card) }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" title="{{ __('View') }}">
                                    <x-phosphor-eye class="h-4 w-4" />
                                    {{ __('View') }}
                                </a>
                                <a href="{{ route('cards.edit', $card) }}" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" title="{{ __('Edit') }}">
                                    <x-phosphor-pencil-simple class="h-4 w-4" />
                                    {{ __('Edit') }}
                                </a>
                                {{-- Share Button --}}
                                <div x-data="{ showShare: false }">
                                    <button type="button" @click="showShare = true" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" title="{{ __('Share') }}">
                                        <x-phosphor-share-network class="h-4 w-4" />
                                        {{ __('Share') }}
                                    </button>

                                    {{-- Share Modal --}}
                                    <template x-teleport="body">
                                        <div x-show="showShare" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
                                            <div class="fixed inset-0 bg-black/50" @click="showShare = false"></div>
                                            <div x-show="showShare" x-transition.scale.origin.center class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900" @click.outside="showShare = false">
                                                {{-- Close --}}
                                                <button @click="showShare = false" class="absolute right-3 top-3 rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300">
                                                    <x-phosphor-x-bold class="h-4 w-4" />
                                                </button>

                                                {{-- Header --}}
                                                <div class="text-center">
                                                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full" style="background-color: {{ $card->theme_color }}15">
                                                        <x-phosphor-share-network class="h-6 w-6" style="color: {{ $card->theme_color }}" />
                                                    </div>
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Share Card') }}</h3>
                                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $card->full_name }}</p>
                                                </div>

                                                {{-- QR Code --}}
                                                <div class="mt-5 flex justify-center">
                                                    <div class="rounded-xl border border-gray-100 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                                                        <img src="{{ route('public.card.qr', $card->slug) }}" alt="QR Code" class="h-48 w-48" />
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-center text-xs text-gray-400 dark:text-gray-500">{{ __('Scan to view card') }}</p>

                                                {{-- Public URL --}}
                                                <div class="mt-4" x-data="{ copied: false }">
                                                    <label class="mb-1.5 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Public Link') }}</label>
                                                    <div class="flex items-center gap-2">
                                                        <input type="text" value="{{ $card->getPublicUrl() }}" readonly class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300" />
                                                        <button type="button" @click="navigator.clipboard.writeText('{{ $card->getPublicUrl() }}'); copied = true; setTimeout(() => copied = false, 2000)" class="flex-shrink-0 rounded-lg border border-gray-200 bg-white p-2 text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                                                            <x-phosphor-check class="h-4 w-4 text-green-500" x-show="copied" x-cloak />
                                                            <x-phosphor-copy class="h-4 w-4" x-show="!copied" />
                                                        </button>
                                                    </div>
                                                </div>

                                                {{-- Action Buttons --}}
                                                <div class="mt-4 grid grid-cols-2 gap-2">
                                                    <a href="{{ route('public.card.qr', $card->slug) }}" download="{{ str_replace(' ', '_', $card->full_name) }}_qr.png" class="flex items-center justify-center gap-2 rounded-lg border border-gray-200 px-3 py-2.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                                        <x-phosphor-download-simple class="h-4 w-4" />
                                                        {{ __('Download QR') }}
                                                    </a>
                                                    <a href="{{ route('public.card.vcard', $card->slug) }}" class="flex items-center justify-center gap-2 rounded-lg border border-gray-200 px-3 py-2.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800">
                                                        <x-phosphor-address-book class="h-4 w-4" />
                                                        {{ __('Download vCard') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <form method="POST" action="{{ route('cards.toggle', $card) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" title="{{ $card->is_active ? __('Deactivate') : __('Activate') }}">
                                        @if($card->is_active)
                                            <x-phosphor-toggle-right class="h-4 w-4 text-green-500" />
                                        @else
                                            <x-phosphor-toggle-left class="h-4 w-4" />
                                        @endif
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('cards.duplicate', $card) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" title="{{ __('Duplicate') }}">
                                        <x-phosphor-copy class="h-4 w-4" />
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('cards.destroy', $card) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this card?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20" title="{{ __('Delete') }}">
                                        <x-phosphor-trash class="h-4 w-4" />
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($cards->hasPages())
                <div class="mt-2">
                    {{ $cards->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.app>
