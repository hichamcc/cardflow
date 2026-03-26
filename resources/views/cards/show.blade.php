<x-layouts.app :title="$card->card_name">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <x-heading size="xl" level="1">{{ $card->card_name }}</x-heading>
                <x-subheading>{{ __('Preview and share your business card.') }}</x-subheading>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('cards.edit', $card) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <x-phosphor-pencil-simple class="h-4 w-4" />
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('cards.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <x-phosphor-arrow-left class="h-4 w-4" />
                    {{ __('Back') }}
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Mobile Preview (2 cols) --}}
            <div class="lg:col-span-2 flex flex-col items-center justify-start">
                <p class="mb-4 text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500">{{ __('Mobile Preview') }}</p>

                {{-- Phone Frame --}}
                <div class="relative mx-auto" style="width: 320px;">
                    {{-- Phone shell --}}
                    <div class="relative rounded-[3rem] border-[8px] border-gray-800 dark:border-gray-600 bg-gray-800 dark:bg-gray-600 shadow-2xl shadow-black/30">
                        {{-- Notch --}}
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 h-6 w-28 rounded-b-2xl bg-gray-800 dark:bg-gray-600 z-10"></div>
                        {{-- Side buttons --}}
                        <div class="absolute -right-3 top-24 h-12 w-1.5 rounded-full bg-gray-700 dark:bg-gray-500"></div>
                        <div class="absolute -left-3 top-20 h-8 w-1.5 rounded-full bg-gray-700 dark:bg-gray-500"></div>
                        <div class="absolute -left-3 top-32 h-8 w-1.5 rounded-full bg-gray-700 dark:bg-gray-500"></div>
                        {{-- Screen --}}
                        <div class="overflow-hidden rounded-[2.4rem] bg-black" style="height: 580px;">
                            <iframe
                                src="{{ route('public.card.show', $card->slug) }}"
                                class="w-full h-full border-0"
                                title="{{ __('Card Preview') }}"
                                loading="lazy"
                                sandbox="allow-same-origin allow-scripts"
                            ></iframe>
                        </div>
                    </div>
                    {{-- Bottom bar --}}
                    <div class="mx-auto mt-3 h-1 w-24 rounded-full bg-gray-300 dark:bg-gray-600"></div>
                </div>

                <a href="{{ route('public.card.show', $card->slug) }}" target="_blank" rel="noopener" class="mt-5 inline-flex items-center gap-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    <x-phosphor-arrow-square-out class="h-3.5 w-3.5" />
                    {{ __('Open public page') }}
                </a>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Status & Stats --}}
                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('Card Stats') }}</h3>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Status') }}</span>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $card->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                {{ $card->is_active ? __('Active') : __('Inactive') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Views') }}</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($card->view_count) }}</span>
                        </div>
                        @if(isset($card->saved_cards_count))
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Saves') }}</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($card->saved_cards_count) }}</span>
                            </div>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Created') }}</span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $card->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Sharing --}}
                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('Share') }}</h3>
                    <div class="mt-4 space-y-3">
                        {{-- Public URL --}}
                        <div>
                            <label class="mb-1.5 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Public URL') }}</label>
                            <div class="flex items-center gap-2" x-data="{ copied: false }">
                                <input type="text" value="{{ $card->getPublicUrl() }}" readonly class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300" />
                                <button type="button" @click="navigator.clipboard.writeText('{{ $card->getPublicUrl() }}'); copied = true; setTimeout(() => copied = false, 2000)" class="flex-shrink-0 rounded-lg border border-gray-200 bg-white p-2 text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700" title="{{ __('Copy URL') }}">
                                    <x-phosphor-check class="h-4 w-4 text-green-500" x-show="copied" x-cloak />
                                    <x-phosphor-copy class="h-4 w-4" x-show="!copied" />
                                </button>
                            </div>
                        </div>

                        {{-- QR Code inline toggle --}}
                        <div x-data="{ showQr: false }">
                            <button type="button" @click="showQr = !showQr" class="flex w-full items-center justify-between gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                <span class="flex items-center gap-2">
                                    <x-phosphor-qr-code class="h-4 w-4" />
                                    {{ __('Show QR Code') }}
                                </span>
                                <x-phosphor-caret-down class="h-4 w-4 transition-transform duration-200" ::class="showQr ? 'rotate-180' : ''" />
                            </button>

                            <div x-show="showQr" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                                <div class="mt-2 rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                                    <div class="flex justify-center [&_svg]:w-full [&_svg]:h-auto">
                                        {!! $qrCode !!}
                                    </div>
                                    <p class="mt-2 text-center text-xs text-gray-400 dark:text-gray-500">{{ __('Scan to view this card') }}</p>
                                    <a href="{{ route('public.card.qr', $card->slug) }}" download="{{ $card->slug }}-qr.svg" class="mt-3 flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                        <x-phosphor-download-simple class="h-3.5 w-3.5" />
                                        {{ __('Download QR') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- vCard Download --}}
                        <a href="{{ route('public.card.vcard', $card->slug) }}" class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-download-simple class="h-4 w-4" />
                            {{ __('Download vCard') }}
                        </a>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('Actions') }}</h3>
                    <div class="mt-4 space-y-2">
                        <a href="{{ route('cards.edit', $card) }}" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800">
                            <x-phosphor-pencil-simple class="h-4 w-4 text-gray-400" />
                            {{ __('Edit Card') }}
                        </a>

                        <form method="POST" action="{{ route('cards.duplicate', $card) }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800">
                                <x-phosphor-copy class="h-4 w-4 text-gray-400" />
                                {{ __('Duplicate Card') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('cards.toggle', $card) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800">
                                @if($card->is_active)
                                    <x-phosphor-toggle-right class="h-4 w-4 text-green-500" />
                                    {{ __('Deactivate Card') }}
                                @else
                                    <x-phosphor-toggle-left class="h-4 w-4 text-gray-400" />
                                    {{ __('Activate Card') }}
                                @endif
                            </button>
                        </form>

                        <div class="border-t border-gray-100 pt-2 dark:border-gray-800">
                            <form method="POST" action="{{ route('cards.destroy', $card) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this card? This action cannot be undone.') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">
                                    <x-phosphor-trash class="h-4 w-4" />
                                    {{ __('Delete Card') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
