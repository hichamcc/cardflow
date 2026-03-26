{{-- Save to BsnCard (logged in users) --}}
@auth
    @if(auth()->id() !== $card->user_id)
        <form method="POST" action="{{ route('contacts.save-public', $card->slug) }}" class="mb-6">
            @csrf
            <button type="submit"
               class="flex w-full items-center justify-center gap-2 rounded-2xl border border-white/10 bg-white/[0.06] px-6 py-3.5 text-sm font-bold text-white/60 transition hover:bg-white/10">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/></svg>
                {{ __('Save to BsnCard') }}
            </button>
        </form>
    @endif
@endauth
