<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BsnCard - Digital Business Cards & Networking CRM</title>
    <meta name="description" content="Create beautiful digital business cards, share instantly via QR code, and manage your network with a built-in CRM. Free forever.">
    <link rel="canonical" href="{{ url('/') }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="BsnCard - Digital Business Cards & Networking CRM">
    <meta property="og:description" content="Create beautiful digital business cards, share instantly via QR code, and manage your network with a built-in CRM. Free forever.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:site_name" content="BsnCard">
    <meta property="og:image" content="{{ asset('images/og.png') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="BsnCard - Digital Business Cards & Networking CRM">
    <meta name="twitter:description" content="Create beautiful digital business cards, share instantly via QR code, and manage your network with a built-in CRM. Free forever.">
    <meta name="twitter:image" content="{{ asset('images/og.png') }}">

    {{-- JSON-LD Organization --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'BsnCard',
        'url' => url('/'),
        'logo' => asset('images/logo.png'),
        'description' => 'Create beautiful digital business cards, share instantly via QR code, and manage your network with a built-in CRM.',
        'sameAs' => [],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        .gradient-text { background: linear-gradient(135deg, #38bdf8, #0284c7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        #hero-glow-orb { position: absolute; top: -20%; left: 50%; width: 80%; height: 60%; transform: translateX(-50%); border-radius: 50%; pointer-events: none; z-index: 0; background: radial-gradient(ellipse at center, rgba(14,165,233,0.12), transparent 70%); }
        .glass-card { background: rgba(255,255,255,0.65); backdrop-filter: blur(16px) saturate(180%); -webkit-backdrop-filter: blur(16px) saturate(180%); border: 1px solid rgba(255,255,255,0.5); }
        .glass-card-dark { background: rgba(15,23,42,0.75); backdrop-filter: blur(16px) saturate(180%); -webkit-backdrop-filter: blur(16px) saturate(180%); border: 1px solid rgba(255,255,255,0.08); }
        .hero-right { position: relative; min-height: 600px; }
        .crm-float { position: absolute; z-index: 10; will-change: transform, opacity; }
        .magnetic-btn { transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1); }
        .reveal { opacity: 0; transform: translateY(30px); }
        #three-canvas { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 0; }
        /* Bento feature tiles */
        .bento-tile { position: relative; overflow: hidden; }
        .bento-tile::before { content: ''; position: absolute; inset: 0; opacity: 0; transition: opacity 0.4s; background: radial-gradient(600px circle at var(--mouse-x, 50%) var(--mouse-y, 50%), rgba(14,165,233,0.06), transparent 40%); }
        .bento-tile:hover::before { opacity: 1; }
    </style>
</head>
<body class="bg-white font-sans text-gray-900 antialiased overflow-x-hidden">

    {{-- Navigation --}}
    <nav class="fixed top-0 w-full z-50" id="nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-2">
                    <svg width="32" height="30" viewBox="0 0 38 36" fill="none">
                        <g transform="rotate(-14 19 18)"><rect x="6" y="7" width="22" height="16" rx="3" fill="#9CA3AF" opacity="0.3"/></g>
                        <g transform="rotate(-5 19 18)"><rect x="5" y="8" width="22" height="16" rx="3" fill="#0ea5e9" opacity="0.3"/></g>
                        <g transform="rotate(5 19 18)"><rect x="5" y="10" width="22" height="16" rx="3" fill="#0ea5e9"/><rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/><rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/><rect x="8.5" y="20.5" width="8" height="1.5" rx="0.75" fill="white" opacity="0.4"/></g>
                    </svg>
                    <span class="text-lg font-bold text-gray-900">bsn<span class="text-sky-500">Card</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Features</a>
                    <a href="#how-it-works" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">How It Works</a>
                    <a href="#pricing" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Pricing</a>
                    <a href="#faq" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">FAQ</a>
                </div>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="magnetic-btn inline-flex items-center px-5 py-2 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 shadow-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="magnetic-btn inline-flex items-center px-5 py-2 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800">
                                    Get started free
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden" id="hero">
        <div id="hero-glow-orb"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- Left: Copy --}}
                <div class="max-w-xl">
                    <div id="hero-badge" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-sky-50 border border-sky-100 mb-6 opacity-0">
                        <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                        <span class="text-xs font-semibold text-sky-700">Free forever plan available</span>
                    </div>

                    <h1 id="hero-title" class="text-4xl sm:text-5xl lg:text-[3.25rem] font-black leading-[1.08] tracking-tight mb-6 opacity-0">
                        Digital cards meet<br>
                        <span class="gradient-text">a smarter CRM.</span>
                    </h1>

                    <p id="hero-subtitle" class="text-lg text-gray-500 leading-relaxed mb-8 max-w-md opacity-0">
                        Create stunning business cards, share via QR, and manage contacts, deals & follow-ups — your all-in-one networking CRM.
                    </p>

                    <div id="hero-cta" class="flex flex-col sm:flex-row gap-3 mb-10 opacity-0">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="magnetic-btn inline-flex items-center justify-center px-7 py-3.5 bg-sky-600 text-white text-sm font-semibold rounded-xl hover:bg-sky-700 shadow-lg shadow-sky-600/25">
                                Start for free
                                <svg class="ml-2 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @endif
                        <a href="#how-it-works" class="magnetic-btn inline-flex items-center justify-center px-7 py-3.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200">
                            See how it works
                        </a>
                    </div>

                    <div id="hero-trust" class="flex items-center gap-5 text-sm text-gray-400 opacity-0">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            No credit card
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Setup in 2 min
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Cancel anytime
                        </div>
                    </div>
                </div>

                {{-- Right: Three.js Canvas + Floating CRM Cards --}}
                <div class="hidden lg:block hero-right" id="hero-scene">
                    <canvas id="three-canvas"></canvas>

                    {{-- CRM Card: Deal Pipeline --}}
                    <div class="crm-float -left-4 top-4 opacity-0" id="crm-deals">
                        <div class="w-[210px] rounded-2xl glass-card p-4 shadow-xl shadow-sky-500/5">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                                </div>
                                <span class="text-[11px] font-bold text-gray-900">Deal Pipeline</span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-sky-500"></div><span class="text-[10px] text-gray-600">Acme Corp</span></div>
                                    <span class="text-[10px] font-semibold text-gray-900">$12,000</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div><span class="text-[10px] text-gray-600">TechFlow Inc</span></div>
                                    <span class="text-[10px] font-semibold text-gray-900">$8,500</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-violet-500"></div><span class="text-[10px] text-gray-600">Nova Design</span></div>
                                    <span class="text-[10px] font-semibold text-gray-900">$5,200</span>
                                </div>
                            </div>
                            <div class="mt-3 pt-2.5 border-t border-gray-200/50 flex justify-between items-center">
                                <span class="text-[9px] text-gray-400 font-medium">3 active deals</span>
                                <span class="text-[10px] font-bold text-emerald-600">$25,700</span>
                            </div>
                        </div>
                    </div>

                    {{-- CRM Card: Contacts --}}
                    <div class="crm-float -right-2 top-12 opacity-0" id="crm-contacts">
                        <div class="w-[200px] rounded-2xl glass-card p-4 shadow-xl shadow-sky-500/5">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-7 h-7 rounded-lg bg-sky-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                                </div>
                                <span class="text-[11px] font-bold text-gray-900">Contacts</span>
                            </div>
                            <div class="space-y-2.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center text-[8px] font-bold text-white shrink-0">SC</div>
                                    <div class="min-w-0"><p class="text-[10px] font-semibold text-gray-900 truncate">Sarah Chen</p><p class="text-[9px] text-gray-400">Acme Technologies</p></div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-[8px] font-bold text-white shrink-0">JM</div>
                                    <div class="min-w-0"><p class="text-[10px] font-semibold text-gray-900 truncate">James Miller</p><p class="text-[9px] text-gray-400">Stripe</p></div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center text-[8px] font-bold text-white shrink-0">AL</div>
                                    <div class="min-w-0"><p class="text-[10px] font-semibold text-gray-900 truncate">Anna Lopez</p><p class="text-[9px] text-gray-400">Figma</p></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CRM Card: Follow-ups --}}
                    <div class="crm-float -left-2 bottom-16 opacity-0" id="crm-followups">
                        <div class="w-[220px] rounded-2xl glass-card p-4 shadow-xl shadow-sky-500/5">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-7 h-7 rounded-lg bg-rose-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                                </div>
                                <span class="text-[11px] font-bold text-gray-900">Follow-ups</span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between rounded-lg bg-amber-50/80 border border-amber-100 px-2.5 py-2">
                                    <div><p class="text-[10px] font-semibold text-gray-900">Call Sarah Chen</p><p class="text-[9px] text-amber-600 font-medium">Due today</p></div>
                                    <div class="w-5 h-5 rounded-full border-2 border-amber-400 flex items-center justify-center"><svg class="w-2.5 h-2.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/></svg></div>
                                </div>
                                <div class="flex items-center justify-between rounded-lg bg-gray-50/80 px-2.5 py-2">
                                    <div><p class="text-[10px] font-semibold text-gray-900">Send proposal to TechFlow</p><p class="text-[9px] text-gray-400">Tomorrow</p></div>
                                    <div class="w-5 h-5 rounded-full border-2 border-gray-300"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CRM Card: Stats --}}
                    <div class="crm-float right-0 bottom-8 opacity-0" id="crm-stats">
                        <div class="w-[170px] rounded-2xl glass-card-dark p-4 shadow-xl shadow-gray-900/20">
                            <p class="text-[9px] font-semibold uppercase tracking-wider text-gray-400 mb-2.5">This month</p>
                            <div class="space-y-2.5">
                                <div><p class="text-[18px] font-black text-white leading-none">247</p><p class="text-[9px] text-gray-500 mt-0.5">card views</p></div>
                                <div class="flex gap-3">
                                    <div><p class="text-[14px] font-extrabold text-emerald-400 leading-none">18</p><p class="text-[8px] text-gray-500 mt-0.5">contacts</p></div>
                                    <div><p class="text-[14px] font-extrabold text-sky-400 leading-none">5</p><p class="text-[8px] text-gray-500 mt-0.5">deals</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- Features --}}
    <section id="features" class="py-24 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal text-center max-w-2xl mx-auto mb-16">
                <p class="text-sm font-semibold text-sky-600 mb-3">Everything you need</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                    Cards, contacts, and CRM &mdash; unified.
                </h2>
                <p class="text-gray-500 leading-relaxed">
                    BsnCard replaces paper cards, scattered spreadsheets, and clunky CRMs with one elegant tool.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="features-grid">

                {{-- Card Builder — large tile with mini card visuals --}}
                <div class="bento-tile reveal md:col-span-2 group rounded-2xl border border-gray-100 bg-white p-7 transition-all hover:border-gray-200 hover:shadow-lg hover:shadow-gray-100/80">
                    <span class="text-[11px] font-bold text-sky-600 bg-sky-50 px-2.5 py-1 rounded-full">Core</span>
                    <h3 class="text-lg font-bold text-gray-900 mt-3">Card Builder</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mt-1 max-w-sm">Create multiple cards for different roles with custom themes, photos, social links, and contact details.</p>
                    <div class="mt-5 flex gap-4">
                        <div class="w-48 h-28 rounded-xl bg-gradient-to-br from-slate-900 to-slate-800 p-4 shadow-lg transform -rotate-3 transition-transform duration-300 group-hover:rotate-0 group-hover:scale-105">
                            <div class="w-5 h-5 rounded-full bg-sky-500/40 mb-2"></div>
                            <div class="h-2 w-20 rounded bg-white/80 mb-1.5"></div>
                            <div class="h-1.5 w-14 rounded bg-white/30 mb-3"></div>
                            <div class="h-1 w-24 rounded bg-white/15 mb-1"></div>
                            <div class="h-1 w-18 rounded bg-white/15"></div>
                        </div>
                        <div class="w-48 h-28 rounded-xl bg-gradient-to-br from-sky-600 to-sky-700 p-4 shadow-lg transform rotate-3 transition-transform duration-300 group-hover:rotate-0 group-hover:scale-105">
                            <div class="w-5 h-5 rounded-full bg-white/30 mb-2"></div>
                            <div class="h-2 w-20 rounded bg-white/80 mb-1.5"></div>
                            <div class="h-1.5 w-14 rounded bg-white/30 mb-3"></div>
                            <div class="h-1 w-24 rounded bg-white/15 mb-1"></div>
                            <div class="h-1 w-18 rounded bg-white/15"></div>
                        </div>
                        <div class="hidden lg:block w-48 h-28 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 p-4 shadow-lg transform rotate-1 transition-transform duration-300 group-hover:-rotate-1 group-hover:scale-105">
                            <div class="w-5 h-5 rounded-full bg-white/30 mb-2"></div>
                            <div class="h-2 w-20 rounded bg-white/80 mb-1.5"></div>
                            <div class="h-1.5 w-14 rounded bg-white/30 mb-3"></div>
                            <div class="h-1 w-24 rounded bg-white/15 mb-1"></div>
                            <div class="h-1 w-18 rounded bg-white/15"></div>
                        </div>
                    </div>
                </div>

                {{-- QR Code Sharing — tall tile with QR visual --}}
                <div class="bento-tile reveal md:row-span-2 group rounded-2xl border border-gray-100 bg-white p-7 transition-all hover:border-gray-200 hover:shadow-lg hover:shadow-gray-100/80 flex flex-col">
                    <span class="text-[11px] font-bold text-violet-600 bg-violet-50 px-2.5 py-1 rounded-full w-fit">Sharing</span>
                    <h3 class="text-lg font-bold text-gray-900 mt-3">QR Code Sharing</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mt-1">Scan, view, and save — your card shared in seconds.</p>
                    <div class="mt-auto pt-6 flex justify-center">
                        <div class="relative group-hover:scale-105 transition-transform duration-300">
                            <div class="w-40 h-40 bg-white border-2 border-gray-100 rounded-2xl p-3.5 shadow-sm">
                                <div class="w-full h-full grid grid-cols-9 grid-rows-9 gap-[2px]">
                                    @php
                                        $qr = [
                                            [1,1,1,1,1,0,1,1,1],
                                            [1,0,0,0,1,0,0,1,0],
                                            [1,0,1,0,1,0,1,0,1],
                                            [1,0,0,0,1,0,1,1,1],
                                            [1,1,1,1,1,0,0,0,0],
                                            [0,0,0,0,0,0,1,0,1],
                                            [1,0,1,1,0,1,1,1,1],
                                            [0,1,0,0,1,0,1,0,0],
                                            [1,1,1,0,1,0,1,0,1],
                                        ];
                                    @endphp
                                    @foreach($qr as $row)
                                        @foreach($row as $cell)
                                            <div class="rounded-[1px] {{ $cell ? 'bg-gray-900' : 'bg-transparent' }}"></div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-9 h-9 rounded-xl bg-sky-600 flex items-center justify-center shadow-lg shadow-sky-600/30">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5z"/></svg>
                            </div>
                            <div class="absolute -top-1 -left-1 w-3 h-3 rounded-full bg-sky-400 animate-ping opacity-75"></div>
                        </div>
                    </div>
                </div>

                {{-- Contact Management — avatar stack --}}
                <div class="bento-tile reveal group rounded-2xl border border-gray-100 bg-white p-7 transition-all hover:border-gray-200 hover:shadow-lg hover:shadow-gray-100/80">
                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">CRM</span>
                    <h3 class="text-base font-bold text-gray-900 mt-3">Contact Management</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mt-1">Folders, tags, and full-text search across your network.</p>
                    <div class="mt-5 flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center text-[11px] font-bold text-white border-2 border-white shadow-sm">SC</div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-[11px] font-bold text-white border-2 border-white shadow-sm -ml-2.5">JM</div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center text-[11px] font-bold text-white border-2 border-white shadow-sm -ml-2.5">AL</div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center text-[11px] font-bold text-white border-2 border-white shadow-sm -ml-2.5">KR</div>
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-[11px] font-semibold text-gray-500 border-2 border-white shadow-sm -ml-2.5">+47</div>
                    </div>
                </div>

                {{-- Deal Pipeline — mini pipeline bars --}}
                <div class="bento-tile reveal group rounded-2xl border border-gray-100 bg-white p-7 transition-all hover:border-gray-200 hover:shadow-lg hover:shadow-gray-100/80">
                    <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">CRM</span>
                    <h3 class="text-base font-bold text-gray-900 mt-3">Deal Pipeline</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mt-1">Track opportunities from first contact to close.</p>
                    <div class="mt-5 space-y-3">
                        <div>
                            <div class="flex justify-between text-[10px] mb-1"><span class="font-semibold text-gray-600">Lead</span><span class="text-gray-400">4 deals</span></div>
                            <div class="h-2 rounded-full bg-gray-100 overflow-hidden"><div class="h-2 rounded-full bg-sky-500 transition-all duration-700 group-hover:w-[90%]" style="width:75%"></div></div>
                        </div>
                        <div>
                            <div class="flex justify-between text-[10px] mb-1"><span class="font-semibold text-gray-600">Proposal</span><span class="text-gray-400">2 deals</span></div>
                            <div class="h-2 rounded-full bg-gray-100 overflow-hidden"><div class="h-2 rounded-full bg-amber-500 transition-all duration-700 group-hover:w-[65%]" style="width:45%"></div></div>
                        </div>
                        <div>
                            <div class="flex justify-between text-[10px] mb-1"><span class="font-semibold text-gray-600">Won</span><span class="font-bold text-emerald-600">$25.7k</span></div>
                            <div class="h-2 rounded-full bg-gray-100 overflow-hidden"><div class="h-2 rounded-full bg-emerald-500 transition-all duration-700 group-hover:w-full" style="width:100%"></div></div>
                        </div>
                    </div>
                </div>

                {{-- Follow-up Reminders — timeline visual, wide --}}
                <div class="bento-tile reveal md:col-span-2 group rounded-2xl border border-gray-100 bg-white p-7 transition-all hover:border-gray-200 hover:shadow-lg hover:shadow-gray-100/80">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-6">
                        <div class="flex-1">
                            <span class="text-[11px] font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">Automation</span>
                            <h3 class="text-lg font-bold text-gray-900 mt-3">Follow-ups & Reminders</h3>
                            <p class="text-sm text-gray-500 leading-relaxed mt-1">Never let a warm lead go cold. Set reminders with automated email notifications.</p>
                        </div>
                        <div class="flex flex-col gap-0 shrink-0 pt-2">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-sky-500 ring-4 ring-sky-500/10"></div>
                                <div class="text-[11px]"><span class="font-semibold text-gray-700">Call Sarah Chen</span> <span class="text-sky-600 font-medium ml-1">today</span></div>
                            </div>
                            <div class="w-px h-5 bg-gray-200 ml-[5px]"></div>
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-amber-400 ring-4 ring-amber-400/10"></div>
                                <div class="text-[11px]"><span class="font-semibold text-gray-700">Send proposal</span> <span class="text-amber-600 font-medium ml-1">tomorrow</span></div>
                            </div>
                            <div class="w-px h-5 bg-gray-200 ml-[5px]"></div>
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                                <div class="text-[11px]"><span class="font-semibold text-gray-500">Review contracts</span> <span class="text-gray-400 ml-1">Friday</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Notes & Calendar — mini calendar --}}
                <div class="bento-tile reveal group rounded-2xl border border-gray-100 bg-white p-7 transition-all hover:border-gray-200 hover:shadow-lg hover:shadow-gray-100/80">
                    <span class="text-[11px] font-bold text-sky-600 bg-sky-50 px-2.5 py-1 rounded-full">Productivity</span>
                    <h3 class="text-base font-bold text-gray-900 mt-3">Notes & Calendar</h3>
                    <p class="text-sm text-gray-500 leading-relaxed mt-1">Schedule meetings, attach notes to any contact.</p>
                    <div class="mt-5 grid grid-cols-7 gap-1 text-center">
                        @foreach(['M','T','W','T','F','S','S'] as $d)
                            <div class="text-[8px] font-bold text-gray-400 uppercase pb-1">{{ $d }}</div>
                        @endforeach
                        @for($i = 1; $i <= 14; $i++)
                            <div class="w-7 h-7 rounded-lg text-[10px] flex items-center justify-center transition-colors duration-200
                                {{ in_array($i, [3,8,12]) ? 'bg-sky-500 text-white font-bold shadow-sm shadow-sky-500/30' : ($i == 5 ? 'bg-amber-100 text-amber-700 font-bold' : ($i == 10 ? 'bg-emerald-100 text-emerald-700 font-bold' : 'text-gray-500 hover:bg-gray-50')) }}">{{ $i }}</div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- App Showcase --}}
    <section class="py-24 lg:py-32 bg-gray-50" x-data="{ active: 'create-card' }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal text-center max-w-2xl mx-auto mb-14">
                <p class="text-sm font-semibold text-sky-600 mb-3">See it in action</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                    Powerful tools, beautifully simple
                </h2>
                <p class="text-gray-500 leading-relaxed">
                    From contact management to deal tracking &mdash; everything in one place.
                </p>
            </div>

            <div class="reveal flex justify-center flex-wrap gap-2 mb-10">
                @php
                    $tabs = [
                        ['create-card', 'Card Builder'],
                        ['contacts', 'Contacts'],
                        ['deals', 'Deals'],
                        ['calendar', 'Calendar'],
                        ['notes', 'Notes'],
                        ['follow-ups', 'Follow-ups'],
                        ['projects', 'Projects'],
                    ];
                @endphp
                @foreach ($tabs as [$key, $label])
                    <button
                        @click="active = '{{ $key }}'"
                        :class="active === '{{ $key }}' ? 'bg-gray-900 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                        class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200"
                    >{{ $label }}</button>
                @endforeach
            </div>

            <div class="reveal max-w-5xl mx-auto">
                <div class="rounded-2xl border border-gray-200 bg-white shadow-2xl shadow-gray-200/60 overflow-hidden">
                    <div class="flex items-center gap-2 px-5 py-3.5 bg-gray-100/80 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#FF5F57]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#FEBC2E]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#28C840]"></div>
                        </div>
                        <div class="flex-1 flex justify-center">
                            <div class="px-4 py-1 rounded-md bg-white/60 border border-gray-200/80 text-xs text-gray-400 font-medium flex items-center gap-1.5">
                                <svg class="w-3 h-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                app.bsncard.com
                            </div>
                        </div>
                        <div class="w-[52px]"></div>
                    </div>
                    <div class="relative bg-gray-50">
                        <img x-show="active === 'contacts'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" src="{{ asset('images/bsncard/Contacts-BsnCard.png') }}" alt="Contacts Management" class="w-full block">
                        <img x-show="active === 'create-card'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" src="{{ asset('images/bsncard/Create-Card-BsnCard.png') }}" alt="Card Builder" class="w-full block">
                        <img x-show="active === 'deals'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" src="{{ asset('images/bsncard/Deals-BsnCard.png') }}" alt="Deal Pipeline" class="w-full block">
                        <img x-show="active === 'calendar'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" src="{{ asset('images/bsncard/Calendar-BsnCard.png') }}" alt="Calendar & Events" class="w-full block">
                        <img x-show="active === 'notes'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" src="{{ asset('images/bsncard/Notes-BsnCard.png') }}" alt="Notes" class="w-full block">
                        <img x-show="active === 'follow-ups'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" src="{{ asset('images/bsncard/Follow-ups-BsnCard.png') }}" alt="Follow-up Reminders" class="w-full block">
                        <img x-show="active === 'projects'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" src="{{ asset('images/bsncard/Projects-BsnCard.png') }}" alt="Project Management" class="w-full block">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="py-24 lg:py-32">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal text-center max-w-xl mx-auto mb-20">
                <p class="text-sm font-semibold text-sky-600 mb-3">Simple setup</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                    Up and running in minutes
                </h2>
                <p class="text-gray-500">Three steps to a smarter way of networking.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-12" id="steps-grid">
                @php
                    $steps = [
                        ['Create', 'Add your info, choose a theme, upload a photo. Your card is live in under 2 minutes.', '<path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'],
                        ['Share', 'Show your QR code at events, drop a link in emails, or text it to someone new.', '<path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/>'],
                        ['Grow', 'Save contacts, track deals, set reminders. Build relationships that convert.', '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>'],
                    ];
                @endphp
                @foreach ($steps as $i => $step)
                    <div class="reveal text-center">
                        <div class="relative inline-flex mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                                <svg class="w-7 h-7 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">{!! $step[2] !!}</svg>
                            </div>
                            <div class="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-sky-600 text-white flex items-center justify-center text-xs font-bold shadow-md">{{ $i + 1 }}</div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $step[0] }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">{{ $step[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Pricing --}}
    <section id="pricing" class="py-24 lg:py-32">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal text-center max-w-xl mx-auto mb-16">
                <p class="text-sm font-semibold text-sky-600 mb-3">Pricing</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                    Start free, scale when ready
                </h2>
                <p class="text-gray-500">No hidden fees. Upgrade or cancel anytime.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 items-start" id="pricing-grid">
                {{-- Free --}}
                <div class="reveal rounded-2xl border border-gray-200 bg-white p-8">
                    <h3 class="text-lg font-bold text-gray-900">Free</h3>
                    <p class="text-sm text-gray-400 mt-1 mb-6">For individuals getting started</p>
                    <div class="mb-6"><span class="text-4xl font-black text-gray-900">$0</span><span class="text-gray-400 text-sm">/month</span></div>
                    <ul class="space-y-3 mb-8 text-sm text-gray-600">
                        @foreach (['3 business cards', 'Unlimited contacts', 'Folders, tags & search', 'Notes & calendar', '20 interactions/month', 'QR code sharing'] as $f)
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>{{ $f }}</li>
                        @endforeach
                    </ul>
                    @auth
                        <a href="{{ route('dashboard') }}" class="magnetic-btn block w-full text-center py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:border-gray-300 hover:bg-gray-50">Go to Dashboard</a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="magnetic-btn block w-full text-center py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:border-gray-300 hover:bg-gray-50">Get started free</a>
                        @endif
                    @endauth
                </div>

                {{-- Pro --}}
                <div class="reveal rounded-2xl bg-gray-900 p-8 text-white relative shadow-2xl shadow-gray-900/20 md:-mt-4 md:mb-[-16px]">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2"><span class="px-4 py-1 rounded-full bg-sky-500 text-white text-[11px] font-bold uppercase tracking-wider shadow-lg">Most popular</span></div>
                    <h3 class="text-lg font-bold">Pro</h3>
                    <p class="text-sm text-gray-400 mt-1 mb-6">For professionals who network seriously</p>
                    <div class="mb-6"><span class="text-4xl font-black">$12</span><span class="text-gray-500 text-sm">/month</span></div>
                    <ul class="space-y-3 mb-8 text-sm text-gray-300">
                        @foreach (['Unlimited business cards', 'Unlimited interactions', 'Deal pipeline tracking', 'Follow-up reminders', 'Full calendar & scheduling', 'Advanced notes', 'Custom branding', 'Priority support'] as $f)
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>{{ $f }}</li>
                        @endforeach
                    </ul>
                    @auth
                        <a href="{{ route('upgrade') }}" class="magnetic-btn block w-full text-center py-3 rounded-xl bg-sky-600 text-white font-semibold text-sm hover:bg-sky-700 shadow-lg shadow-sky-600/30">Upgrade to Pro</a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="magnetic-btn block w-full text-center py-3 rounded-xl bg-sky-600 text-white font-semibold text-sm hover:bg-sky-700 shadow-lg shadow-sky-600/30">Start 14-day trial</a>
                        @endif
                    @endauth
                </div>

                {{-- Business --}}
                <div class="reveal rounded-2xl border border-gray-200 bg-white p-8 relative opacity-75">
                    <div class="absolute top-4 right-4 inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Coming Soon</div>
                    <h3 class="text-lg font-bold text-gray-900">Business</h3>
                    <p class="text-sm text-gray-400 mt-1 mb-6">For teams that grow together</p>
                    <div class="mb-6"><span class="text-4xl font-black text-gray-900">$29</span><span class="text-gray-400 text-sm">/month</span></div>
                    <ul class="space-y-3 mb-8 text-sm text-gray-600">
                        @foreach (['Everything in Pro', 'Team features (5 users)', 'Shared contact database', 'Advanced pipeline', 'Weekly digest reports', 'API access', 'Custom domain', 'Dedicated onboarding'] as $f)
                            <li class="flex items-center gap-2.5"><svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>{{ $f }}</li>
                        @endforeach
                    </ul>
                    <span class="block w-full text-center py-3 rounded-xl border-2 border-gray-200 text-gray-400 font-semibold text-sm cursor-not-allowed">Coming Soon</span>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="py-24 lg:py-32 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal text-center mb-14">
                <p class="text-sm font-semibold text-sky-600 mb-3">FAQ</p>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Common questions</h2>
            </div>
            <div class="reveal space-y-3" x-data="{ open: 0 }">
                @php
                    $faqs = [
                        ['What does BsnCard do?', 'BsnCard lets you create digital business cards and share them via QR code or link. It also includes a lightweight CRM with contact management, folders, tags, deal tracking, notes, calendar, and follow-up reminders.'],
                        ['Is there really a free plan?', 'Yes. The free plan includes 3 business cards, unlimited contacts, folders, tags, notes, calendar, QR sharing, and 20 interactions per month. No credit card required.'],
                        ['Is my data secure?', 'Your data is encrypted in transit and at rest. We never share or sell your information. You can export or delete your data at any time.'],
                        ['Can I cancel anytime?', 'Absolutely. There are no contracts or commitments. You can upgrade, downgrade, or cancel at any time from your account settings.'],
                        ['How is this different from a CRM?', 'BsnCard is purpose-built for networking. It starts with your business card and naturally extends into contact management. Think of it as the tool between exchanging cards and needing Salesforce.'],
                    ];
                @endphp
                @foreach ($faqs as $i => [$q, $a])
                    <div class="rounded-xl bg-white border border-gray-200 overflow-hidden">
                        <button @click="open = open === {{ $i }} ? null : {{ $i }}" class="w-full flex items-center justify-between px-6 py-5 text-left">
                            <span class="text-sm font-semibold text-gray-900 pr-4">{{ $q }}</span>
                            <svg :class="open === {{ $i }} ? 'rotate-45' : ''" class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                        </button>
                        <div x-show="open === {{ $i }}" x-collapse>
                            <div class="px-6 pb-5"><p class="text-sm text-gray-500 leading-relaxed">{{ $a }}</p></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-24 lg:py-32">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="reveal">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-5">Ready to ditch the paper cards?</h2>
                <p class="text-lg text-gray-500 mb-8 max-w-xl mx-auto">Join thousands of professionals who manage their entire network with BsnCard.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="magnetic-btn inline-flex items-center justify-center px-8 py-4 bg-sky-600 text-white text-sm font-semibold rounded-xl hover:bg-sky-700 shadow-lg shadow-sky-600/25">
                            Get started for free
                            <svg class="ml-2 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    @endif
                    <a href="#contact-form" class="magnetic-btn inline-flex items-center justify-center px-8 py-4 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200">Contact us</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Form --}}
    <section id="contact-form" class="py-24 lg:py-32 bg-gray-950 relative overflow-hidden">
        {{-- Background accents --}}
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-sky-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-violet-500/5 rounded-full blur-3xl"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-5 gap-12 lg:gap-16 items-start">

                {{-- Left: Info --}}
                <div class="lg:col-span-2 reveal">
                    <p class="text-sm font-semibold text-sky-400 mb-3">Contact us</p>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-4">
                        Let's start a conversation
                    </h2>
                    <p class="text-gray-400 leading-relaxed mb-10">
                        Have a question, feedback, or want to learn more? Drop us a message and we'll get back to you quickly.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">Email us</p>
                                <p class="text-sm text-gray-400 mt-0.5">hello@bsncard.com</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">Response time</p>
                                <p class="text-sm text-gray-400 mt-0.5">Usually within 24 hours</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-white">Privacy first</p>
                                <p class="text-sm text-gray-400 mt-0.5">Your data stays safe with us</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Form card --}}
                <div class="lg:col-span-3">
                    @if (session('contact_success'))
                        <div class="reveal mb-6 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 p-6 text-center">
                            <div class="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-white">{{ session('contact_success') }}</p>
                            <p class="text-xs text-gray-400 mt-1">We'll be in touch soon.</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="reveal rounded-2xl bg-white/[0.03] border border-white/10 p-8 backdrop-blur-sm">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label for="contact_name" class="block text-xs font-semibold text-gray-300 mb-2">Name <span class="text-sky-400">*</span></label>
                                <div class="relative">
                                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    </div>
                                    <input type="text" name="name" id="contact_name" value="{{ old('name') }}" required class="w-full rounded-xl border border-white/10 bg-white/5 pl-10 pr-4 py-3 text-sm text-white placeholder-gray-500 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:bg-white/[0.07] transition" placeholder="Your name">
                                </div>
                                @error('name') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="contact_email" class="block text-xs font-semibold text-gray-300 mb-2">Email <span class="text-sky-400">*</span></label>
                                <div class="relative">
                                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    </div>
                                    <input type="email" name="email" id="contact_email" value="{{ old('email') }}" required class="w-full rounded-xl border border-white/10 bg-white/5 pl-10 pr-4 py-3 text-sm text-white placeholder-gray-500 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:bg-white/[0.07] transition" placeholder="you@example.com">
                                </div>
                                @error('email') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="mt-5">
                            <label for="contact_subject" class="block text-xs font-semibold text-gray-300 mb-2">Subject</label>
                            <div class="relative">
                                <div class="absolute left-3.5 top-1/2 -translate-y-1/2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                                </div>
                                <input type="text" name="subject" id="contact_subject" value="{{ old('subject') }}" class="w-full rounded-xl border border-white/10 bg-white/5 pl-10 pr-4 py-3 text-sm text-white placeholder-gray-500 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:bg-white/[0.07] transition" placeholder="What's this about?">
                            </div>
                            @error('subject') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div class="mt-5">
                            <label for="contact_message" class="block text-xs font-semibold text-gray-300 mb-2">Message <span class="text-sky-400">*</span></label>
                            <textarea name="message" id="contact_message" rows="5" required class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white placeholder-gray-500 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 focus:bg-white/[0.07] transition resize-none" placeholder="Tell us how we can help...">{{ old('message') }}</textarea>
                            @error('message') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="magnetic-btn w-full mt-6 py-3.5 bg-sky-600 text-white text-sm font-semibold rounded-xl hover:bg-sky-700 shadow-lg shadow-sky-600/20 transition-colors flex items-center justify-center gap-2">
                            Send message
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-5 gap-10 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg width="32" height="30" viewBox="0 0 38 36" fill="none">
                            <g transform="rotate(-14 19 18)"><rect x="6" y="7" width="22" height="16" rx="3" fill="#9CA3AF" opacity="0.3"/></g>
                            <g transform="rotate(-5 19 18)"><rect x="5" y="8" width="22" height="16" rx="3" fill="#0ea5e9" opacity="0.3"/></g>
                            <g transform="rotate(5 19 18)"><rect x="5" y="10" width="22" height="16" rx="3" fill="#0ea5e9"/><rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/><rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/><rect x="8.5" y="20.5" width="8" height="1.5" rx="0.75" fill="white" opacity="0.4"/></g>
                        </svg>
                        <span class="text-lg font-bold text-gray-900">bsn<span class="text-sky-500">Card</span></span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-xs">Digital business cards with a built-in CRM. Network smarter, close faster.</p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Product</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#features" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Features</a></li>
                        <li><a href="#pricing" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Pricing</a></li>
                        <li><a href="#faq" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Support</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#contact-form" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Contact Us</a></li>
                        <li><a href="#faq" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Help Center</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Legal</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('legal.privacy') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Privacy</a></li>
                        <li><a href="{{ route('legal.terms') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Terms</a></li>
                        <li><a href="{{ route('legal.refund') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Refunds</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 text-center">
                <p class="text-sm text-gray-400">&copy; {{ date('Y') }} BsnCard. All rights reserved.</p>
                <a href="https://fazier.com/launches/bsncard.com" target="_blank"><img src="https://fazier.com/api/v1//public/badges/launch_badges.svg?badge_type=launched&theme=light" width=120 alt="Fazier badge" /></a>
            </div>
            <div class="text-center border-t border-gray-800 pt-4"><p class="text-gray-400 text-sm">Created with ❤️ by<!-- --> <a href="https://codebyhicham.com/" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 font-medium transition-colors duration-200">CodeByHicham</a></p></div>
        </div>
    </footer>

    {{-- Libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        gsap.registerPlugin(ScrollTrigger);

        /* ─── Mouse state ─── */
        const mouse = { x: 0, y: 0, nx: 0, ny: 0 };
        window.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
            mouse.nx = (e.clientX / window.innerWidth) * 2 - 1;
            mouse.ny = -(e.clientY / window.innerHeight) * 2 + 1;
        });

        /* ═══════════════════════════════════════════
           THREE.JS — 3D Business Card (fixed overlay)
           ═══════════════════════════════════════════ */
        const canvas = document.getElementById('three-canvas');
        if (canvas) {
            const scene = new THREE.Scene();
            const container = document.getElementById('hero-scene');
            const w = container.offsetWidth, h = container.offsetHeight;
            const camera = new THREE.PerspectiveCamera(40, w / h, 0.1, 100);
            camera.position.z = 5;

            const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
            renderer.setSize(w, h);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

            // Card texture via CanvasTexture
            const texCanvas = document.createElement('canvas');
            texCanvas.width = 512; texCanvas.height = 320;
            const ctx = texCanvas.getContext('2d');

            // Background
            const grad = ctx.createLinearGradient(0, 0, 512, 320);
            grad.addColorStop(0, '#1a1a2e');
            grad.addColorStop(0.5, '#16213e');
            grad.addColorStop(1, '#0f172a');
            ctx.fillStyle = grad;
            ctx.beginPath();
            const r = 24;
            ctx.moveTo(r, 0); ctx.lineTo(512 - r, 0); ctx.quadraticCurveTo(512, 0, 512, r);
            ctx.lineTo(512, 320 - r); ctx.quadraticCurveTo(512, 320, 512 - r, 320);
            ctx.lineTo(r, 320); ctx.quadraticCurveTo(0, 320, 0, 320 - r);
            ctx.lineTo(0, r); ctx.quadraticCurveTo(0, 0, r, 0);
            ctx.closePath(); ctx.fill();

            // Accent orb
            const orbGrad = ctx.createRadialGradient(430, 40, 0, 430, 40, 120);
            orbGrad.addColorStop(0, 'rgba(14,165,233,0.2)');
            orbGrad.addColorStop(1, 'transparent');
            ctx.fillStyle = orbGrad;
            ctx.fillRect(0, 0, 512, 320);

            // BsnCard logo
            ctx.fillStyle = 'rgba(255,255,255,0.3)';
            ctx.font = '600 11px Inter, sans-serif';
            ctx.fillText('BsnCard', 32, 38);

            // Name
            ctx.fillStyle = '#ffffff';
            ctx.font = '800 30px Inter, sans-serif';
            ctx.fillText('DR. Kevin', 32, 100);

            // Title
            ctx.fillStyle = 'rgba(255,255,255,0.5)';
            ctx.font = '500 14px Inter, sans-serif';
            ctx.fillText('Head of Partnerships', 32, 124);

            // Company
            ctx.fillStyle = 'rgba(56,189,248,0.7)';
            ctx.font = '700 11px Inter, sans-serif';
            ctx.fillText('ACME TECHNOLOGIES', 32, 146);

            // Divider
            ctx.strokeStyle = 'rgba(255,255,255,0.08)';
            ctx.lineWidth = 1;
            ctx.beginPath(); ctx.moveTo(32, 168); ctx.lineTo(480, 168); ctx.stroke();

            // Contact details
            ctx.fillStyle = 'rgba(255,255,255,0.6)';
            ctx.font = '500 13px Inter, sans-serif';
            ctx.fillText('sarah@acmetech.com', 32, 198);
            ctx.fillText('+1 (555) 234-5678', 32, 224);
            ctx.fillText('acmetech.com', 32, 250);

            // Social icons placeholder
            ctx.fillStyle = 'rgba(255,255,255,0.12)';
            [0, 1, 2].forEach(i => {
                const x = 32 + i * 52;
                ctx.beginPath();
                ctx.moveTo(x + 8, 274); ctx.lineTo(x + 36, 274); ctx.quadraticCurveTo(x + 44, 274, x + 44, 282);
                ctx.lineTo(x + 44, 302); ctx.quadraticCurveTo(x + 44, 310, x + 36, 310);
                ctx.lineTo(x + 8, 310); ctx.quadraticCurveTo(x, 310, x, 302);
                ctx.lineTo(x, 282); ctx.quadraticCurveTo(x, 274, x + 8, 274);
                ctx.closePath(); ctx.fill();
            });
            ctx.fillStyle = 'rgba(255,255,255,0.35)';
            ctx.font = '700 9px Inter, sans-serif';
            ctx.fillText('in', 52, 296); ctx.fillText('X', 105, 296); ctx.fillText('gh', 153, 296);

            // Initials circle
            ctx.save();
            ctx.beginPath(); ctx.arc(440, 95, 34, 0, Math.PI * 2); ctx.closePath();
            const circGrad = ctx.createLinearGradient(406, 61, 474, 129);
            circGrad.addColorStop(0, '#0ea5e9'); circGrad.addColorStop(1, '#0369a1');
            ctx.fillStyle = circGrad; ctx.fill();
            ctx.fillStyle = '#fff'; ctx.font = '800 22px Inter, sans-serif';
            ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
            ctx.fillText('SC', 440, 97);
            ctx.restore();

            const texture = new THREE.CanvasTexture(texCanvas);
            texture.anisotropy = renderer.capabilities.getMaxAnisotropy();

            // Card mesh
            const cardW = 3.2, cardH = 2.0, cardD = 0.04;
            const geometry = new THREE.BoxGeometry(cardW, cardH, cardD, 1, 1, 1);

            const frontMat = new THREE.MeshPhysicalMaterial({
                map: texture, roughness: 0.3, metalness: 0.1, clearcoat: 0.6, clearcoatRoughness: 0.2,
            });
            const sideMat = new THREE.MeshPhysicalMaterial({ color: 0x1a1a2e, roughness: 0.4, metalness: 0.3 });
            const backMat = new THREE.MeshPhysicalMaterial({ color: 0x0f172a, roughness: 0.4, metalness: 0.2 });

            const materials = [sideMat, sideMat, sideMat, sideMat, frontMat, backMat];
            const card = new THREE.Mesh(geometry, materials);
            card.rotation.y = 0.15;
            card.rotation.x = -0.08;
            scene.add(card);

            // Lights
            scene.add(new THREE.AmbientLight(0xffffff, 0.6));
            const dirLight = new THREE.DirectionalLight(0xffffff, 0.8);
            dirLight.position.set(3, 4, 5);
            scene.add(dirLight);
            const pointLight = new THREE.PointLight(0x0ea5e9, 0.5, 10);
            pointLight.position.set(-2, 2, 3);
            scene.add(pointLight);

            // Ambient particles
            const particlesGeo = new THREE.BufferGeometry();
            const pCount = 40;
            const positions = new Float32Array(pCount * 3);
            for (let i = 0; i < pCount * 3; i++) positions[i] = (Math.random() - 0.5) * 8;
            particlesGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            const particlesMat = new THREE.PointsMaterial({ color: 0x0ea5e9, size: 0.02, transparent: true, opacity: 0.4 });
            const particles = new THREE.Points(particlesGeo, particlesMat);
            scene.add(particles);

            // Animate loop
            let time = 0;
            const targetRotX = { v: -0.08 }, targetRotY = { v: 0.15 };
            function animate() {
                requestAnimationFrame(animate);
                time += 0.01;
                card.position.y = Math.sin(time * 0.8) * 0.08;
                targetRotY.v = 0.15 + mouse.nx * 0.25;
                targetRotX.v = -0.08 + mouse.ny * 0.15;
                card.rotation.y += (targetRotY.v - card.rotation.y) * 0.05;
                card.rotation.x += (targetRotX.v - card.rotation.x) * 0.05;
                particles.rotation.y = time * 0.05;
                particles.rotation.x = time * 0.03;
                renderer.render(scene, camera);
            }
            animate();

            // Entrance animation
            card.scale.set(0, 0, 0);
            gsap.to(card.scale, { x: 1, y: 1, z: 1, duration: 1.2, delay: 0.6, ease: 'elastic.out(1, 0.5)' });

            // Resize handler
            window.addEventListener('resize', () => {
                const nw = container.offsetWidth, nh = container.offsetHeight;
                camera.aspect = nw / nh;
                camera.updateProjectionMatrix();
                renderer.setSize(nw, nh);
            });

        }

        /* ═══════════════════════════════════════════
           GSAP — Hero entrance
           ═══════════════════════════════════════════ */
        const heroTl = gsap.timeline({ defaults: { ease: 'power3.out' } });
        heroTl
            .to('#hero-badge', { opacity: 1, y: 0, duration: 0.6 }, 0.1)
            .fromTo('#hero-title', { opacity: 0, y: 40 }, { opacity: 1, y: 0, duration: 0.8 }, 0.2)
            .fromTo('#hero-subtitle', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.7 }, 0.4)
            .fromTo('#hero-cta', { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.7 }, 0.55)
            .fromTo('#hero-trust', { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.6 }, 0.7);

        /* ═══════════════════════════════════════════
           GSAP — CRM Cards (parallax slide-in)
           ═══════════════════════════════════════════ */
        gsap.fromTo('#crm-deals', { opacity: 0, x: -80, y: 40 }, {
            opacity: 1, x: 0, y: 0, duration: 1, delay: 0.9, ease: 'power2.out',
        });
        gsap.fromTo('#crm-contacts', { opacity: 0, x: 80, y: -30 }, {
            opacity: 1, x: 0, y: 0, duration: 1, delay: 1.1, ease: 'power2.out',
        });
        gsap.fromTo('#crm-followups', { opacity: 0, x: -60, y: 60 }, {
            opacity: 1, x: 0, y: 0, duration: 1, delay: 1.3, ease: 'power2.out',
        });
        gsap.fromTo('#crm-stats', { opacity: 0, x: 60, y: 40 }, {
            opacity: 1, x: 0, y: 0, duration: 1, delay: 1.5, ease: 'power2.out',
        });

        ['#crm-deals', '#crm-contacts', '#crm-followups', '#crm-stats'].forEach((sel, i) => {
            gsap.to(sel, {
                y: '+=8', duration: 2.5 + i * 0.4, repeat: -1, yoyo: true, ease: 'sine.inOut', delay: 1.5 + i * 0.2,
            });
        });

        /* ═══════════════════════════════════════════
           GSAP — Hero glow follows mouse
           ═══════════════════════════════════════════ */
        const glowOrb = document.getElementById('hero-glow-orb');
        if (glowOrb) {
            window.addEventListener('mousemove', (e) => {
                gsap.to(glowOrb, {
                    left: e.clientX, top: e.clientY - 200,
                    duration: 1.5, ease: 'power2.out', overwrite: true,
                });
            });
        }

        /* ═══════════════════════════════════════════
           GSAP — ScrollTrigger reveals
           ═══════════════════════════════════════════ */
        gsap.utils.toArray('.reveal').forEach((el) => {
            gsap.to(el, {
                scrollTrigger: { trigger: el, start: 'top 88%', toggleActions: 'play none none none' },
                opacity: 1, y: 0, duration: 0.7, ease: 'power2.out',
            });
        });

        // Stagger bento tiles
        ScrollTrigger.batch('#features-grid > div', {
            start: 'top 88%',
            onEnter: (batch) => gsap.to(batch, { opacity: 1, y: 0, stagger: 0.08, duration: 0.6, ease: 'power2.out' }),
        });

        // Stagger steps
        ScrollTrigger.batch('#steps-grid > div', {
            start: 'top 88%',
            onEnter: (batch) => gsap.to(batch, { opacity: 1, y: 0, stagger: 0.15, duration: 0.7, ease: 'power2.out' }),
        });

        // Stagger pricing cards
        ScrollTrigger.batch('#pricing-grid > div', {
            start: 'top 88%',
            onEnter: (batch) => gsap.to(batch, { opacity: 1, y: 0, stagger: 0.12, duration: 0.6, ease: 'power2.out' }),
        });

        /* ═══════════════════════════════════════════
           Bento tile mouse-glow effect
           ═══════════════════════════════════════════ */
        document.querySelectorAll('.bento-tile').forEach((tile) => {
            tile.addEventListener('mousemove', (e) => {
                const rect = tile.getBoundingClientRect();
                tile.style.setProperty('--mouse-x', ((e.clientX - rect.left) / rect.width * 100) + '%');
                tile.style.setProperty('--mouse-y', ((e.clientY - rect.top) / rect.height * 100) + '%');
            });
        });

        /* ═══════════════════════════════════════════
           Magnetic buttons
           ═══════════════════════════════════════════ */
        document.querySelectorAll('.magnetic-btn').forEach((btn) => {
            btn.addEventListener('mousemove', (e) => {
                const rect = btn.getBoundingClientRect();
                const dx = e.clientX - (rect.left + rect.width / 2);
                const dy = e.clientY - (rect.top + rect.height / 2);
                gsap.to(btn, { x: dx * 0.25, y: dy * 0.25, duration: 0.3, ease: 'power2.out' });
            });
            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, { x: 0, y: 0, duration: 0.5, ease: 'elastic.out(1, 0.4)' });
            });
        });

        /* ═══════════════════════════════════════════
           Nav background on scroll
           ═══════════════════════════════════════════ */
        ScrollTrigger.create({
            start: 20,
            onUpdate: (self) => {
                const nav = document.getElementById('nav');
                if (self.scroll() > 20) {
                    nav.style.background = 'rgba(255,255,255,0.85)';
                    nav.style.backdropFilter = 'blur(12px)';
                    nav.style.borderBottom = '1px solid rgba(0,0,0,0.06)';
                } else {
                    nav.style.background = 'transparent';
                    nav.style.backdropFilter = 'none';
                    nav.style.borderBottom = '1px solid transparent';
                }
            },
        });
    });
    </script>
</body>
</html>
