<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased">
        {{-- Background --}}
        <div class="fixed inset-0 bg-gradient-to-br from-slate-50 via-sky-50/30 to-white dark:from-gray-950 dark:via-gray-900 dark:to-gray-950"></div>
        <div class="fixed inset-0 opacity-40 dark:opacity-20" style="background-image: radial-gradient(rgba(14,165,233,0.08) 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="relative flex min-h-svh flex-col items-center justify-center p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center justify-center gap-2.5 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center shadow-lg shadow-sky-500/25">
                        <svg class="w-5.5 h-5.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">Bsn<span class="text-sky-600 dark:text-sky-400">Card</span></span>
                </a>

                {{-- Card --}}
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/80 dark:border-gray-800 shadow-xl shadow-gray-200/40 dark:shadow-none p-8 sm:p-10">
                    <div class="space-y-6">
                        {{ $slot }}
                    </div>
                </div>

                {{-- Footer --}}
                <p class="mt-8 text-center text-xs text-gray-400 dark:text-gray-600">
                    &copy; {{ date('Y') }} BsnCard. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
