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
            {{-- Card Preview (2 cols) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Main Card Preview --}}
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                    {{-- Theme Banner --}}
                    <div class="relative h-32" style="background: linear-gradient(135deg, {{ $card->theme_color }}, {{ $card->theme_color }}cc)">
                        @if($card->getCompanyLogoUrl())
                            <img src="{{ $card->getCompanyLogoUrl() }}" alt="{{ $card->company_name }}" class="absolute bottom-3 right-4 h-10 w-10 rounded-lg bg-white/90 object-contain p-1 shadow-sm">
                        @endif
                    </div>

                    <div class="relative px-6 pb-6">
                        {{-- Profile Photo --}}
                        <div class="-mt-12 mb-4">
                            @if($card->getProfilePhotoUrl())
                                <img src="{{ $card->getProfilePhotoUrl() }}" alt="{{ $card->full_name }}" class="h-24 w-24 rounded-xl border-4 border-white object-cover shadow-sm dark:border-gray-900">
                            @else
                                <div class="flex h-24 w-24 items-center justify-center rounded-xl border-4 border-white text-2xl font-bold text-white shadow-sm dark:border-gray-900" style="background-color: {{ $card->theme_color }}">
                                    {{ strtoupper(substr($card->full_name, 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Name & Title --}}
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $card->full_name }}</h2>
                        @if($card->job_title)
                            <p class="mt-0.5 text-sm font-medium" style="color: {{ $card->theme_color }}">{{ $card->job_title }}</p>
                        @endif
                        @if($card->company_name)
                            <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">{{ $card->company_name }}</p>
                        @endif

                        {{-- Bio --}}
                        @if($card->bio)
                            <p class="mt-4 text-sm leading-relaxed text-gray-600 dark:text-gray-300">{{ $card->bio }}</p>
                        @endif

                        {{-- Contact Info --}}
                        <div class="mt-5 space-y-2.5">
                            @if($card->email)
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg" style="background-color: {{ $card->theme_color }}15">
                                        <x-phosphor-envelope class="h-4 w-4" style="color: {{ $card->theme_color }}" />
                                    </div>
                                    <a href="mailto:{{ $card->email }}" class="text-gray-700 hover:underline dark:text-gray-300">{{ $card->email }}</a>
                                </div>
                            @endif
                            @if($card->phone)
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg" style="background-color: {{ $card->theme_color }}15">
                                        <x-phosphor-phone class="h-4 w-4" style="color: {{ $card->theme_color }}" />
                                    </div>
                                    <a href="tel:{{ $card->phone }}" class="text-gray-700 hover:underline dark:text-gray-300">{{ $card->phone }}</a>
                                </div>
                            @endif
                            @if($card->website)
                                <div class="flex items-center gap-3 text-sm">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg" style="background-color: {{ $card->theme_color }}15">
                                        <x-phosphor-globe class="h-4 w-4" style="color: {{ $card->theme_color }}" />
                                    </div>
                                    <a href="{{ $card->website }}" target="_blank" rel="noopener" class="text-gray-700 hover:underline dark:text-gray-300">{{ $card->website }}</a>
                                </div>
                            @endif
                        </div>

                        {{-- Social Links --}}
                        @if($card->socialLinks->isNotEmpty())
                            <div class="mt-5 border-t border-gray-100 pt-5 dark:border-gray-800">
                                <h4 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Social') }}</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($card->socialLinks as $link)
                                        <a href="{{ $link->url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800" title="{{ $link->link_clicks }} clicks">
                                            @switch($link->platform)
                                                @case('linkedin')
                                                    <x-phosphor-linkedin-logo class="h-4 w-4" />
                                                    @break
                                                @case('twitter')
                                                    <x-phosphor-x-logo class="h-4 w-4" />
                                                    @break
                                                @case('instagram')
                                                    <x-phosphor-instagram-logo class="h-4 w-4" />
                                                    @break
                                                @case('facebook')
                                                    <x-phosphor-facebook-logo class="h-4 w-4" />
                                                    @break
                                                @case('github')
                                                    <x-phosphor-github-logo class="h-4 w-4" />
                                                    @break
                                                @case('youtube')
                                                    <x-phosphor-youtube-logo class="h-4 w-4" />
                                                    @break
                                                @case('tiktok')
                                                    <x-phosphor-tiktok-logo class="h-4 w-4" />
                                                    @break
                                                @case('dribbble')
                                                    <x-phosphor-dribbble-logo class="h-4 w-4" />
                                                    @break
                                                @case('behance')
                                                    <x-phosphor-behance-logo class="h-4 w-4" />
                                                    @break
                                                @default
                                                    <x-phosphor-link class="h-4 w-4" />
                                            @endswitch
                                            {{ ucfirst($link->platform) }}
                                            @if($link->link_clicks > 0)
                                                <span class="ml-1 inline-flex items-center rounded-full bg-gray-100 px-1.5 py-0.5 text-[10px] font-medium text-gray-500 dark:bg-gray-700 dark:text-gray-400">{{ $link->link_clicks }}</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Custom Fields --}}
                        @if($card->customFields->isNotEmpty())
                            <div class="mt-5 border-t border-gray-100 pt-5 dark:border-gray-800">
                                <h4 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Additional Info') }}</h4>
                                <div class="space-y-2">
                                    @foreach($card->customFields as $field)
                                        <div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2 dark:bg-gray-800">
                                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $field->field_name }}</span>
                                            <span class="text-sm text-gray-900 dark:text-white">{{ $field->field_value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
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

                        {{-- QR Code --}}
                        <div x-data="{ showQr: false }">
                            <button type="button" @click="showQr = true" class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                <x-phosphor-qr-code class="h-4 w-4" />
                                {{ __('View QR Code') }}
                            </button>

                            {{-- QR Modal --}}
                            <div x-show="showQr" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4" @keydown.escape.window="showQr = false">
                                <div class="fixed inset-0 bg-black/50" @click="showQr = false"></div>
                                <div class="relative z-10 w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900" @click.stop>
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('QR Code') }}</h3>
                                        <button type="button" @click="showQr = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300">
                                            <x-phosphor-x class="h-5 w-5" />
                                        </button>
                                    </div>
                                    <div class="flex justify-center rounded-xl bg-gray-50 p-6 dark:bg-gray-800">
                                        <img src="{{ route('public.card.qr', $card->slug) }}" alt="{{ __('QR Code for :name', ['name' => $card->full_name]) }}" class="w-48 h-48">
                                    </div>
                                    <p class="mt-3 text-center text-xs text-gray-500 dark:text-gray-400">{{ __('Scan to view this card') }}</p>
                                    <a href="{{ route('public.card.qr', $card->slug) }}" download="{{ $card->slug }}-qr.png" class="mt-4 flex w-full items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                        <x-phosphor-download-simple class="h-4 w-4" />
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
