<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-gray-950">
        <div class="relative grid min-h-dvh lg:grid-cols-2">

            {{-- Left Panel - Branding --}}
            <div class="relative hidden lg:flex flex-col overflow-hidden" style="background: linear-gradient(135deg, #082f49 0%, #0c4a6e 25%, #0369a1 55%, #0ea5e9 100%);">
                {{-- Dot grid --}}
                <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.07) 1px, transparent 1px); background-size: 32px 32px;"></div>

                {{-- Blur orbs --}}
                <div class="absolute -top-32 -right-32 w-80 h-80 bg-sky-400/15 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-brand-300/10 rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/3 w-48 h-48 bg-sky-300/5 rounded-full blur-2xl"></div>

                {{-- Content --}}
                <div class="relative z-10 flex flex-col justify-between h-full p-12">
                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Bsn<span class="text-sky-300">Card</span></span>
                    </a>

                    {{-- Center Content --}}
                    <div class="flex-1 flex flex-col items-center justify-center max-w-md mx-auto text-center">
                        {{-- Card mockup --}}
                        <div class="mb-10 w-full max-w-[280px]">
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl border border-white/15 p-6 shadow-2xl" style="animation: float 6s ease-in-out infinite;">
                                <div class="flex items-center gap-4 mb-5">
                                    <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center text-xl font-bold text-white">
                                        JD
                                    </div>
                                    <div class="text-left">
                                        <p class="text-white font-semibold">Jane Doe</p>
                                        <p class="text-sky-200 text-sm">Head of Partnerships</p>
                                        <p class="text-sky-300/60 text-xs">Acme Technologies</p>
                                    </div>
                                </div>
                                <div class="space-y-2.5">
                                    <div class="flex items-center gap-3 text-sm text-sky-100/80">
                                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3.5 h-3.5 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        </div>
                                        jane@acmetech.com
                                    </div>
                                    <div class="flex items-center gap-3 text-sm text-sky-100/80">
                                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3.5 h-3.5 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        </div>
                                        +1 (555) 123-4567
                                    </div>
                                    <div class="flex items-center gap-3 text-sm text-sky-100/80">
                                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3.5 h-3.5 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                                        </div>
                                        acmetech.com
                                    </div>
                                </div>
                                <div class="mt-5 flex gap-2">
                                    <div class="flex-1 py-2 bg-white/20 rounded-lg text-center text-sm font-medium text-white">Save Contact</div>
                                    <div class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-sky-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="text-2xl font-bold text-white mb-3">Never lose a connection again</h2>
                        <p class="text-sky-100/70 leading-relaxed text-sm">
                            Create stunning digital business cards, share them instantly, and manage your contacts with built-in CRM tools.
                        </p>

                        {{-- Trust indicators --}}
                        <div class="flex items-center justify-center gap-6 mt-8 text-xs text-sky-200/60">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Free forever
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                No credit card
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                2 min setup
                            </div>
                        </div>
                    </div>

                </div>

                <style>
                    @keyframes float { 0%,100% { transform: translateY(0) rotate(-0.5deg); } 50% { transform: translateY(-8px) rotate(0.5deg); } }
                </style>
            </div>

            {{-- Right Panel - Form --}}
            <div class="flex flex-col items-center justify-center px-6 py-12 sm:px-8 lg:px-12 bg-white dark:bg-gray-950">
                <div class="w-full max-w-sm">
                    {{-- Mobile logo (hidden on desktop) --}}
                    <a href="{{ route('home') }}" class="flex items-center justify-center gap-2.5 mb-10 lg:hidden">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center shadow-lg shadow-sky-500/25">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">Bsn<span class="text-sky-600 dark:text-sky-400">Card</span></span>
                    </a>

                    <div class="space-y-6">
                        {{ $slot }}
                    </div>

                    {{-- Footer --}}
                    <p class="mt-10 text-center text-xs text-gray-400 dark:text-gray-600">
                        &copy; {{ date('Y') }} BsnCard. All rights reserved.
                    </p>
                </div>
            </div>

        </div>
    </body>
</html>
