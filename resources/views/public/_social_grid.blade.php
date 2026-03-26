{{-- Social Links Grid --}}
@if($card->socialLinks->isNotEmpty())
    <div class="mb-6">
        <div class="grid grid-cols-3 gap-2.5">
            {{-- Save Contact (first tile, accent colored) --}}
            <a href="{{ route('public.card.vcard', $card->slug) }}"
               class="accent-bg flex flex-col items-center justify-center gap-2 rounded-2xl p-4 text-white transition hover:opacity-90 aspect-square">
                @if($card->getProfilePhotoUrl())
                    <img src="{{ $card->getProfilePhotoUrl() }}" alt="" class="h-10 w-10 rounded-xl object-cover border-2 border-white/20">
                @else
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                @endif
                <span class="text-[11px] font-bold leading-tight text-center">Save<br>Contact</span>
            </a>

            {{-- Social link tiles --}}
            @foreach($card->socialLinks as $link)
                <a href="{{ route('public.card.track-link', [$card->slug, $link->id]) }}" target="_blank" rel="noopener noreferrer"
                   class="flex flex-col items-center justify-center gap-2 rounded-2xl p-4 bg-white/[0.07] text-white/60 transition hover:bg-white/[0.12] aspect-square">
                    @include('public._social_icon', ['platform' => $link->platform, 'class' => 'h-7 w-7'])
                    <span class="text-[11px] font-semibold">{{ ucfirst($link->platform) }}</span>
                </a>
            @endforeach
        </div>
    </div>
@else
    {{-- No social links: standalone save button --}}
    <div class="mb-6">
        <a href="{{ route('public.card.vcard', $card->slug) }}"
           class="accent-bg flex w-full items-center justify-center gap-2.5 rounded-2xl px-6 py-4 text-base font-bold text-white shadow-lg transition hover:opacity-90">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
            {{ __('Save Contact') }}
        </a>
    </div>
@endif
