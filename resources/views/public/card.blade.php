<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $card->full_name }} - BsnCard</title>
    @php
        $seoDesc = $card->job_title
            ? $card->job_title . ($card->company_name ? ' at ' . $card->company_name : '')
            : ($card->bio ? Str::limit($card->bio, 160) : $card->full_name . ' - Digital Business Card');
        $cardUrl = route('public.card.show', $card->slug);
        $profileImage = $card->getProfilePhotoUrl();
    @endphp
    <meta name="description" content="{{ $seoDesc }}">
    <link rel="canonical" href="{{ $cardUrl }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $card->full_name }}{{ $card->job_title ? ' - ' . $card->job_title : '' }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:type" content="profile">
    <meta property="og:url" content="{{ $cardUrl }}">
    @if($profileImage)
        <meta property="og:image" content="{{ $profileImage }}">
    @endif
    <meta property="og:site_name" content="BsnCard">
    <meta property="profile:first_name" content="{{ explode(' ', $card->full_name)[0] }}">
    @if(count(explode(' ', $card->full_name)) > 1)
        <meta property="profile:last_name" content="{{ collect(explode(' ', $card->full_name))->slice(1)->implode(' ') }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $card->full_name }}{{ $card->job_title ? ' - ' . $card->job_title : '' }}">
    <meta name="twitter:description" content="{{ $seoDesc }}">
    @if($profileImage)
        <meta name="twitter:image" content="{{ $profileImage }}">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        accent: '{{ $card->theme_color ?? '#3B82F6' }}',
                    }
                }
            }
        }
    </script>
    @php $tc = $card->theme_color ?? '#3B82F6'; @endphp
    <style>
        .accent-bg { background-color: {{ $tc }}; }
        .accent-text { color: {{ $tc }}; }
        .accent-border { border-color: {{ $tc }}; }
        .accent-bg-light { background-color: {{ $tc }}12; }
        .accent-bg-medium { background-color: {{ $tc }}20; }
        .accent-ring { box-shadow: 0 0 0 3px {{ $tc }}30; }
        .qr-glow { box-shadow: 0 8px 40px {{ $tc }}25; }
        .card-dark { background: linear-gradient(160deg, #1a1a2e 0%, #16213e 50%, #0f172a 100%); }
        .card-modern-dark { background: linear-gradient(160deg, #0c0c18 0%, #131328 50%, #0e1525 100%); }
        .glass-tile { background: rgba(255,255,255,0.06); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.06); }
    </style>

    {{-- JSON-LD Structured Data --}}
    <script type="application/ld+json">
    {!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        'name' => $card->full_name,
        'jobTitle' => $card->job_title,
        'worksFor' => $card->company_name ? ['@type' => 'Organization', 'name' => $card->company_name] : null,
        'email' => $card->email,
        'telephone' => $card->phone,
        'url' => $card->website,
        'image' => $card->getProfilePhotoUrl(),
        'description' => $card->bio,
        'sameAs' => $card->socialLinks->pluck('url')->values()->toArray() ?: null,
    ]), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
</head>
<body class="min-h-screen bg-[#0f172a] font-sans antialiased">
    <div class="mx-auto max-w-lg min-h-screen sm:shadow-2xl sm:shadow-black/10">

    @if(($card->layout_style ?? 'classic') === 'classic')
        {{-- ==================== CLASSIC LAYOUT ==================== --}}
        <div class="card-dark relative overflow-hidden px-6 pb-8 pt-10">
            <div class="absolute -top-20 -right-20 h-56 w-56 rounded-full opacity-15" style="background: radial-gradient(circle, {{ $tc }}, transparent 70%);"></div>
            <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full opacity-10" style="background: radial-gradient(circle, {{ $tc }}, transparent 70%);"></div>

            {{-- Top bar --}}
            <div class="relative flex items-center justify-between mb-8">
                @unless($card->hide_branding)
                <a href="{{ url('/') }}" class="flex items-center gap-1.5 opacity-50 hover:opacity-80 transition-opacity">
                    <div class="w-5 h-5 rounded bg-white/20 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-white/60">BsnCard</span>
                </a>
                @else
                <div></div>
                @endunless
                <span class="text-[10px] font-medium text-white/30 uppercase tracking-widest">Business Card</span>
            </div>

            {{-- Profile --}}
            <div class="relative flex items-start gap-5">
                <div class="flex-1 min-w-0">
                    <h1 class="text-[2rem] font-extrabold text-white leading-[1.1] tracking-tight mb-2">{{ $card->full_name }}</h1>
                    @if($card->job_title || $card->company_name)
                        <div class="space-y-0.5">
                            @if($card->job_title)
                                <p class="text-sm font-medium text-white/60">{{ $card->job_title }}</p>
                            @endif
                            @if($card->company_name)
                                <p class="text-xs font-semibold uppercase tracking-wider" style="color: {{ $tc }}aa;">{{ $card->company_name }}</p>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="shrink-0">
                    @if($card->getProfilePhotoUrl())
                        <img src="{{ $card->getProfilePhotoUrl() }}" alt="{{ $card->full_name }}"
                             class="h-20 w-20 rounded-2xl object-cover border-2 border-white/10 accent-ring">
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-2xl border-2 border-white/10 text-2xl font-extrabold text-white accent-ring"
                             style="background: linear-gradient(135deg, {{ $tc }}, {{ $tc }}88);">
                            {{ strtoupper(substr($card->full_name, 0, 2)) }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bio --}}
            @if($card->bio)
                <div class="mt-6">
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-white/30 mb-1.5">About</p>
                    <p class="text-sm leading-relaxed text-white/50">{{ $card->bio }}</p>
                </div>
            @endif

            {{-- Contact Info --}}
            <div class="mt-6 space-y-4">
                @if($card->email)
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-white/30 mb-1">Email</p>
                        <a href="mailto:{{ $card->email }}" class="group flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/5 group-hover:bg-white/10 transition-colors">
                                <svg class="h-4 w-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            </div>
                            <span class="text-sm font-medium text-white/80 group-hover:text-white transition-colors truncate">{{ $card->email }}</span>
                        </a>
                    </div>
                @endif
                @if($card->phone)
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-white/30 mb-1">Mobile</p>
                        <a href="tel:{{ $card->phone }}" class="group flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/5 group-hover:bg-white/10 transition-colors">
                                <svg class="h-4 w-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            </div>
                            <span class="text-sm font-medium text-white/80 group-hover:text-white transition-colors">{{ $card->phone }}</span>
                        </a>
                    </div>
                @endif
                @if($card->website)
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-widest text-white/30 mb-1">Website</p>
                        <a href="{{ $card->website }}" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/5 group-hover:bg-white/10 transition-colors">
                                <svg class="h-4 w-4 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                            </div>
                            <span class="text-sm font-medium text-white/80 group-hover:text-white transition-colors truncate">{{ str_replace(['https://', 'http://', 'www.'], '', $card->website) }}</span>
                        </a>
                    </div>
                @endif
            </div>

            {{-- Custom Fields --}}
            @if($card->customFields->isNotEmpty())
                <div class="mt-6 space-y-4">
                    @foreach($card->customFields as $field)
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-widest text-white/30 mb-1">{{ $field->field_name }}</p>
                            <p class="text-sm font-medium text-white/80">{{ $field->field_value }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- QR Code --}}
            <div class="mt-8 flex justify-center">
                <div class="rounded-2xl bg-white p-4 qr-glow">
                    <div class="w-44 h-44 flex items-center justify-center">
                        {!! $qrCode !!}
                    </div>
                    <p class="mt-2 text-center text-[10px] font-medium text-gray-400">Scan to share this card</p>
                </div>
            </div>

            {{-- Social & Actions --}}
            <div class="mt-8">
                @include('public._social_grid')
                @include('public._save_to_bsncard')
            </div>

            @unless($card->hide_branding)
            <div class="pt-4 border-t border-white/[0.06] text-center">
                <p class="text-xs text-white/20">
                    {{ __('Powered by') }}
                    <a href="{{ url('/') }}" class="accent-text font-semibold hover:underline">BsnCard</a>
                </p>
            </div>
            @endunless
        </div>

    @elseif(($card->layout_style ?? 'classic') === 'modern')
        {{-- ==================== MODERN LAYOUT ==================== --}}
        <div class="card-modern-dark relative overflow-hidden px-6 pb-8 pt-10">
            <div class="absolute top-0 right-0 h-56 w-56 rounded-full opacity-15" style="background: radial-gradient(circle, {{ $tc }}, transparent 70%);"></div>
            <div class="absolute bottom-0 left-0 h-40 w-40 rounded-full opacity-10" style="background: radial-gradient(circle, {{ $tc }}, transparent 70%);"></div>

            {{-- Top bar --}}
            <div class="relative flex items-center gap-2 mb-8">
                <div class="h-0.5 w-6 rounded-full" style="background-color: {{ $tc }};"></div>
                <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-white/30">Digital Card</span>
            </div>

            {{-- Profile: centered photo --}}
            <div class="relative text-center mb-6">
                @if($card->getProfilePhotoUrl())
                    <img src="{{ $card->getProfilePhotoUrl() }}" alt="{{ $card->full_name }}"
                         class="mx-auto h-24 w-24 rounded-2xl object-cover border-2 border-white/10 accent-ring">
                @else
                    <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-2xl border-2 border-white/10 text-3xl font-extrabold text-white accent-ring"
                         style="background: linear-gradient(135deg, {{ $tc }}, {{ $tc }}88);">
                        {{ strtoupper(substr($card->full_name, 0, 2)) }}
                    </div>
                @endif
                <h1 class="text-[1.75rem] font-extrabold text-white leading-tight tracking-tight mt-4">{{ $card->full_name }}</h1>
                @if($card->job_title)
                    <p class="text-sm font-medium text-white/50 mt-1">{{ $card->job_title }}</p>
                @endif
                @if($card->company_name)
                    <p class="text-xs font-semibold uppercase tracking-wider mt-0.5" style="color: {{ $tc }}aa;">{{ $card->company_name }}</p>
                @endif
            </div>

            {{-- Bio --}}
            @if($card->bio)
                <p class="text-sm text-white/40 leading-relaxed text-center mb-6 px-2">{{ $card->bio }}</p>
            @endif

            {{-- Contact tiles as floating glass cards --}}
            <div class="space-y-2">
                @if($card->email)
                    <a href="mailto:{{ $card->email }}" class="flex items-center gap-3 p-3.5 rounded-xl glass-tile group transition hover:bg-white/10">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg" style="background-color: {{ $tc }}20;">
                            <svg class="h-4 w-4" style="color: {{ $tc }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-semibold text-white/30 uppercase tracking-wider">Email</p>
                            <p class="text-sm font-medium text-white/80 truncate">{{ $card->email }}</p>
                        </div>
                    </a>
                @endif
                @if($card->phone)
                    <a href="tel:{{ $card->phone }}" class="flex items-center gap-3 p-3.5 rounded-xl glass-tile group transition hover:bg-white/10">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg" style="background-color: {{ $tc }}20;">
                            <svg class="h-4 w-4" style="color: {{ $tc }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-semibold text-white/30 uppercase tracking-wider">Mobile</p>
                            <p class="text-sm font-medium text-white/80 truncate">{{ $card->phone }}</p>
                        </div>
                    </a>
                @endif
                @if($card->website)
                    <a href="{{ $card->website }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-3.5 rounded-xl glass-tile group transition hover:bg-white/10">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg" style="background-color: {{ $tc }}20;">
                            <svg class="h-4 w-4" style="color: {{ $tc }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-semibold text-white/30 uppercase tracking-wider">Website</p>
                            <p class="text-sm font-medium text-white/80 truncate">{{ str_replace(['https://', 'http://', 'www.'], '', $card->website) }}</p>
                        </div>
                    </a>
                @endif
            </div>

            {{-- Custom Fields --}}
            @if($card->customFields->isNotEmpty())
                <div class="mt-2 space-y-2">
                    @foreach($card->customFields as $field)
                        <div class="flex items-center gap-3 p-3.5 rounded-xl glass-tile">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg" style="background-color: {{ $tc }}20;">
                                <svg class="h-4 w-4" style="color: {{ $tc }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-semibold text-white/30 uppercase tracking-wider">{{ $field->field_name }}</p>
                                <p class="text-sm font-medium text-white/80 truncate">{{ $field->field_value }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Social & Actions --}}
            <div class="mt-8">
                @include('public._social_grid')
                @include('public._save_to_bsncard')
            </div>

            @unless($card->hide_branding)
            <div class="pt-4 border-t border-white/[0.06] text-center">
                <p class="text-xs text-white/20">
                    {{ __('Powered by') }}
                    <a href="{{ url('/') }}" class="accent-text font-semibold hover:underline">BsnCard</a>
                </p>
            </div>
            @endunless
        </div>

    @else
        {{-- ==================== MINIMAL LAYOUT ==================== --}}
        {{-- Thin accent stripe --}}
        <div class="h-1" style="background: linear-gradient(90deg, transparent, {{ $tc }}, transparent);"></div>

        <div style="background: #111119;" class="px-6 pt-10 pb-8">
            {{-- Profile: horizontal --}}
            <div class="flex items-center gap-4 mb-6">
                @if($card->getProfilePhotoUrl())
                    <img src="{{ $card->getProfilePhotoUrl() }}" alt="{{ $card->full_name }}"
                         class="h-16 w-16 rounded-full object-cover border border-white/10 shrink-0">
                @else
                    <div class="flex h-16 w-16 items-center justify-center rounded-full text-lg font-bold text-white shrink-0 border border-white/10"
                         style="background-color: {{ $tc }};">
                        {{ strtoupper(substr($card->full_name, 0, 1)) }}
                    </div>
                @endif
                <div class="min-w-0">
                    <h1 class="text-xl font-bold text-white leading-tight">{{ $card->full_name }}</h1>
                    @if($card->job_title)
                        <p class="text-xs text-white/40 mt-0.5 truncate">
                            {{ $card->job_title }}
                            @if($card->company_name)
                                <span class="text-white/20 mx-1">&middot;</span>
                                <span style="color: {{ $tc }}99;">{{ $card->company_name }}</span>
                            @endif
                        </p>
                    @elseif($card->company_name)
                        <p class="text-xs mt-0.5" style="color: {{ $tc }}99;">{{ $card->company_name }}</p>
                    @endif
                </div>
            </div>

            {{-- Bio --}}
            @if($card->bio)
                <p class="text-sm text-white/30 leading-relaxed mb-6">{{ $card->bio }}</p>
            @endif

            {{-- Contact: clean list --}}
            @if($card->email || $card->phone || $card->website)
                <div class="rounded-xl bg-white/[0.04] border border-white/[0.06] divide-y divide-white/[0.04] mb-5 overflow-hidden">
                    @if($card->email)
                        <a href="mailto:{{ $card->email }}" class="flex items-center gap-3.5 px-4 py-3 transition hover:bg-white/[0.04]">
                            <svg class="h-4 w-4 shrink-0" style="color: {{ $tc }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <span class="text-sm text-white/60 truncate">{{ $card->email }}</span>
                        </a>
                    @endif
                    @if($card->phone)
                        <a href="tel:{{ $card->phone }}" class="flex items-center gap-3.5 px-4 py-3 transition hover:bg-white/[0.04]">
                            <svg class="h-4 w-4 shrink-0" style="color: {{ $tc }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            <span class="text-sm text-white/60 truncate">{{ $card->phone }}</span>
                        </a>
                    @endif
                    @if($card->website)
                        <a href="{{ $card->website }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3.5 px-4 py-3 transition hover:bg-white/[0.04]">
                            <svg class="h-4 w-4 shrink-0" style="color: {{ $tc }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/></svg>
                            <span class="text-sm text-white/60 truncate">{{ str_replace(['https://', 'http://', 'www.'], '', $card->website) }}</span>
                        </a>
                    @endif
                </div>
            @endif

            {{-- Custom Fields --}}
            @if($card->customFields->isNotEmpty())
                <div class="rounded-xl bg-white/[0.04] border border-white/[0.06] divide-y divide-white/[0.04] mb-5 overflow-hidden">
                    @foreach($card->customFields as $field)
                        <div class="flex items-center gap-3.5 px-4 py-3">
                            <svg class="h-4 w-4 shrink-0" style="color: {{ $tc }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                            <div class="min-w-0">
                                <p class="text-[10px] text-white/25 font-medium uppercase tracking-wider">{{ $field->field_name }}</p>
                                <p class="text-sm text-white/60 truncate">{{ $field->field_value }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Social: horizontal pills --}}
            @if($card->socialLinks->isNotEmpty())
                <div class="flex flex-wrap gap-2 mb-5">
                    @foreach($card->socialLinks as $link)
                        <a href="{{ route('public.card.track-link', [$card->slug, $link->id]) }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center h-8 rounded-lg px-3 text-xs font-semibold bg-white/[0.06] text-white/40 border border-white/[0.06] transition hover:bg-white/10 hover:text-white/60">
                            {{ ucfirst($link->platform) }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Save Contact --}}
            <a href="{{ route('public.card.vcard', $card->slug) }}"
               class="flex w-full items-center justify-center gap-2.5 rounded-xl px-6 py-3.5 text-sm font-bold text-white border transition hover:opacity-90"
               style="border-color: {{ $tc }}44; background-color: {{ $tc }};">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                {{ __('Save Contact') }}
            </a>

            @include('public._save_to_bsncard')

            @unless($card->hide_branding)
            <div class="mt-6 text-center">
                <p class="text-xs text-white/15 font-medium">
                    {{ __('Powered by') }}
                    <a href="{{ url('/') }}" class="font-bold hover:underline" style="color: {{ $tc }}66;">BsnCard</a>
                </p>
            </div>
            @endunless
        </div>
    @endif

    </div>
</body>
</html>
