<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>bsnCard - Logo Options</title>
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
</head>
<body class="min-h-screen bg-gray-100 font-sans antialiased py-12 px-4">

    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-2 text-center">bsnCard Logo Options</h1>
        <p class="text-sm text-gray-500 text-center mb-10">Each option shown on light & dark backgrounds + compact sidebar size. Pick your favorite.</p>

        <div class="grid gap-8">

            {{-- ============================================================ --}}
            {{-- OPTION A: Card icon + clean "bsnCard" wordmark --}}
            {{-- ============================================================ --}}
            <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm">
                <div class="border-b border-gray-100 px-6 py-3 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Option A</span>
                    <span class="text-xs text-gray-400">Card icon + clean wordmark</span>
                </div>
                <div class="grid md:grid-cols-2">
                    <div class="flex items-center justify-center py-16 px-8 bg-white">
                        <div class="flex items-center gap-2.5">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="5" width="24" height="28" rx="4" fill="#3B82F6" opacity="0.15"/>
                                <rect x="6" y="3" width="24" height="28" rx="4" fill="#3B82F6"/>
                                <rect x="10" y="8" width="16" height="2.5" rx="1.25" fill="white" opacity="0.9"/>
                                <rect x="10" y="13" width="10" height="2" rx="1" fill="white" opacity="0.5"/>
                                <rect x="10" y="17" width="13" height="2" rx="1" fill="white" opacity="0.5"/>
                                <circle cx="23" cy="25" r="3.5" fill="white" opacity="0.8"/>
                            </svg>
                            <span class="text-[22px] font-extrabold tracking-tight text-gray-900">bsn<span class="text-blue-500">Card</span></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center py-16 px-8 bg-gray-900">
                        <div class="flex items-center gap-2.5">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="5" width="24" height="28" rx="4" fill="#3B82F6" opacity="0.25"/>
                                <rect x="6" y="3" width="24" height="28" rx="4" fill="#3B82F6"/>
                                <rect x="10" y="8" width="16" height="2.5" rx="1.25" fill="white" opacity="0.9"/>
                                <rect x="10" y="13" width="10" height="2" rx="1" fill="white" opacity="0.5"/>
                                <rect x="10" y="17" width="13" height="2" rx="1" fill="white" opacity="0.5"/>
                                <circle cx="23" cy="25" r="3.5" fill="white" opacity="0.8"/>
                            </svg>
                            <span class="text-[22px] font-extrabold tracking-tight text-white">bsn<span class="text-blue-400">Card</span></span>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 flex items-center gap-8">
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium shrink-0">Compact</span>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1.5">
                            <svg width="22" height="22" viewBox="0 0 36 36" fill="none"><rect x="2" y="5" width="24" height="28" rx="4" fill="#3B82F6" opacity="0.15"/><rect x="6" y="3" width="24" height="28" rx="4" fill="#3B82F6"/><rect x="10" y="8" width="16" height="2.5" rx="1.25" fill="white" opacity="0.9"/><rect x="10" y="13" width="10" height="2" rx="1" fill="white" opacity="0.5"/><rect x="10" y="17" width="13" height="2" rx="1" fill="white" opacity="0.5"/></svg>
                            <span class="text-sm font-extrabold tracking-tight text-gray-900">bsn<span class="text-blue-500">Card</span></span>
                        </div>
                        <div class="bg-gray-900 rounded-lg px-3 py-1.5 flex items-center gap-1.5">
                            <svg width="22" height="22" viewBox="0 0 36 36" fill="none"><rect x="2" y="5" width="24" height="28" rx="4" fill="#3B82F6" opacity="0.25"/><rect x="6" y="3" width="24" height="28" rx="4" fill="#3B82F6"/><rect x="10" y="8" width="16" height="2.5" rx="1.25" fill="white" opacity="0.9"/><rect x="10" y="13" width="10" height="2" rx="1" fill="white" opacity="0.5"/><rect x="10" y="17" width="13" height="2" rx="1" fill="white" opacity="0.5"/></svg>
                            <span class="text-sm font-extrabold tracking-tight text-white">bsn<span class="text-blue-400">Card</span></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- OPTION B: The "d" in "Card" shaped as a business card --}}
            {{-- ============================================================ --}}
            <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm">
                <div class="border-b border-gray-100 px-6 py-3 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Option B</span>
                    <span class="text-xs text-gray-400">Last "d" shaped as a business card</span>
                </div>
                <div class="grid md:grid-cols-2">
                    <div class="flex items-center justify-center py-16 px-8 bg-white">
                        <div class="flex items-baseline gap-0">
                            <span class="text-[26px] font-extrabold tracking-tight text-gray-900">bsnCar</span>
                            <span class="relative inline-flex items-end" style="margin-left: -1px;">
                                <svg width="22" height="28" viewBox="0 0 22 28" fill="none" xmlns="http://www.w3.org/2000/svg" class="relative" style="top: 2px;">
                                    {{-- Card body forming the "d" bowl --}}
                                    <rect x="0" y="5" width="17" height="23" rx="3" fill="#3B82F6"/>
                                    {{-- Stem of "d" --}}
                                    <rect x="13.5" y="0" width="4.5" height="28" rx="2.25" fill="#3B82F6"/>
                                    {{-- Card detail lines --}}
                                    <rect x="3" y="10" width="8" height="1.8" rx="0.9" fill="white" opacity="0.75"/>
                                    <rect x="3" y="13.5" width="5.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                                    <rect x="3" y="17" width="7" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                                    {{-- Small avatar circle --}}
                                    <circle cx="11.5" cy="22.5" r="2.5" fill="white" opacity="0.55"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center py-16 px-8 bg-gray-900">
                        <div class="flex items-baseline gap-0">
                            <span class="text-[26px] font-extrabold tracking-tight text-white">bsnCar</span>
                            <span class="relative inline-flex items-end" style="margin-left: -1px;">
                                <svg width="22" height="28" viewBox="0 0 22 28" fill="none" xmlns="http://www.w3.org/2000/svg" class="relative" style="top: 2px;">
                                    <rect x="0" y="5" width="17" height="23" rx="3" fill="#3B82F6"/>
                                    <rect x="13.5" y="0" width="4.5" height="28" rx="2.25" fill="#3B82F6"/>
                                    <rect x="3" y="10" width="8" height="1.8" rx="0.9" fill="white" opacity="0.75"/>
                                    <rect x="3" y="13.5" width="5.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                                    <rect x="3" y="17" width="7" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                                    <circle cx="11.5" cy="22.5" r="2.5" fill="white" opacity="0.55"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 flex items-center gap-8">
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium shrink-0">Compact</span>
                    <div class="flex items-center gap-6">
                        <div class="flex items-baseline gap-0">
                            <span class="text-sm font-extrabold tracking-tight text-gray-900">bsnCar</span>
                            <svg width="12" height="16" viewBox="0 0 22 28" fill="none" class="relative" style="top: 1px;"><rect x="0" y="5" width="17" height="23" rx="3" fill="#3B82F6"/><rect x="13.5" y="0" width="4.5" height="28" rx="2.25" fill="#3B82F6"/><rect x="3" y="10" width="8" height="1.8" rx="0.9" fill="white" opacity="0.75"/><rect x="3" y="13.5" width="5.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/></svg>
                        </div>
                        <div class="bg-gray-900 rounded-lg px-3 py-1.5 flex items-baseline gap-0">
                            <span class="text-sm font-extrabold tracking-tight text-white">bsnCar</span>
                            <svg width="12" height="16" viewBox="0 0 22 28" fill="none" class="relative" style="top: 1px;"><rect x="0" y="5" width="17" height="23" rx="3" fill="#3B82F6"/><rect x="13.5" y="0" width="4.5" height="28" rx="2.25" fill="#3B82F6"/><rect x="3" y="10" width="8" height="1.8" rx="0.9" fill="white" opacity="0.75"/><rect x="3" y="13.5" width="5.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- OPTION C: Stacked/tilted cards icon + bsnCard --}}
            {{-- ============================================================ --}}
            <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm">
                <div class="border-b border-gray-100 px-6 py-3 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Option C</span>
                    <span class="text-xs text-gray-400">Stacked/tilted cards icon + wordmark</span>
                </div>
                <div class="grid md:grid-cols-2">
                    <div class="flex items-center justify-center py-16 px-8 bg-white">
                        <div class="flex items-center gap-2.5">
                            <svg width="38" height="36" viewBox="0 0 38 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                {{-- Back card (grey, most tilted) --}}
                                <g transform="rotate(-14 19 18)">
                                    <rect x="6" y="7" width="22" height="16" rx="3" fill="#9CA3AF" opacity="0.3"/>
                                </g>
                                {{-- Middle card (light blue) --}}
                                <g transform="rotate(-5 19 18)">
                                    <rect x="5" y="8" width="22" height="16" rx="3" fill="#3B82F6" opacity="0.3"/>
                                </g>
                                {{-- Front card (solid blue with details) --}}
                                <g transform="rotate(5 19 18)">
                                    <rect x="5" y="10" width="22" height="16" rx="3" fill="#3B82F6"/>
                                    <rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/>
                                    <rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                                    <rect x="8.5" y="20.5" width="8" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                                </g>
                            </svg>
                            <span class="text-[22px] font-extrabold tracking-tight text-gray-900">bsn<span class="text-blue-500">Card</span></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center py-16 px-8 bg-gray-900">
                        <div class="flex items-center gap-2.5">
                            <svg width="38" height="36" viewBox="0 0 38 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g transform="rotate(-14 19 18)">
                                    <rect x="6" y="7" width="22" height="16" rx="3" fill="#6B7280" opacity="0.35"/>
                                </g>
                                <g transform="rotate(-5 19 18)">
                                    <rect x="5" y="8" width="22" height="16" rx="3" fill="#3B82F6" opacity="0.35"/>
                                </g>
                                <g transform="rotate(5 19 18)">
                                    <rect x="5" y="10" width="22" height="16" rx="3" fill="#3B82F6"/>
                                    <rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/>
                                    <rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                                    <rect x="8.5" y="20.5" width="8" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                                </g>
                            </svg>
                            <span class="text-[22px] font-extrabold tracking-tight text-white">bsn<span class="text-blue-400">Card</span></span>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 flex items-center gap-8">
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium shrink-0">Compact</span>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1.5">
                            <svg width="22" height="22" viewBox="0 0 38 36" fill="none"><g transform="rotate(-14 19 18)"><rect x="6" y="7" width="22" height="16" rx="3" fill="#9CA3AF" opacity="0.3"/></g><g transform="rotate(-5 19 18)"><rect x="5" y="8" width="22" height="16" rx="3" fill="#3B82F6" opacity="0.3"/></g><g transform="rotate(5 19 18)"><rect x="5" y="10" width="22" height="16" rx="3" fill="#3B82F6"/><rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/><rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/></g></svg>
                            <span class="text-sm font-extrabold tracking-tight text-gray-900">bsn<span class="text-blue-500">Card</span></span>
                        </div>
                        <div class="bg-gray-900 rounded-lg px-3 py-1.5 flex items-center gap-1.5">
                            <svg width="22" height="22" viewBox="0 0 38 36" fill="none"><g transform="rotate(-14 19 18)"><rect x="6" y="7" width="22" height="16" rx="3" fill="#6B7280" opacity="0.35"/></g><g transform="rotate(-5 19 18)"><rect x="5" y="8" width="22" height="16" rx="3" fill="#3B82F6" opacity="0.35"/></g><g transform="rotate(5 19 18)"><rect x="5" y="10" width="22" height="16" rx="3" fill="#3B82F6"/><rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/><rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/></g></svg>
                            <span class="text-sm font-extrabold tracking-tight text-white">bsn<span class="text-blue-400">Card</span></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- OPTION D: "BC" monogram in gradient card shape --}}
            {{-- ============================================================ --}}
            <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm">
                <div class="border-b border-gray-100 px-6 py-3 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Option D</span>
                    <span class="text-xs text-gray-400">BC monogram inside gradient card shape</span>
                </div>
                <div class="grid md:grid-cols-2">
                    <div class="flex items-center justify-center py-16 px-8 bg-white">
                        <div class="flex items-center gap-2.5">
                            <div class="relative w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-sm shadow-blue-500/25">
                                <span class="text-[13px] font-black text-white tracking-tight" style="letter-spacing: -0.5px;">BC</span>
                                <div class="absolute top-[3px] right-[3px] w-[7px] h-[5px] bg-white/25 rounded-sm"></div>
                            </div>
                            <span class="text-[22px] font-extrabold tracking-tight text-gray-900">bsnCard</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center py-16 px-8 bg-gray-900">
                        <div class="flex items-center gap-2.5">
                            <div class="relative w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-sm shadow-blue-500/25">
                                <span class="text-[13px] font-black text-white tracking-tight" style="letter-spacing: -0.5px;">BC</span>
                                <div class="absolute top-[3px] right-[3px] w-[7px] h-[5px] bg-white/25 rounded-sm"></div>
                            </div>
                            <span class="text-[22px] font-extrabold tracking-tight text-white">bsnCard</span>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 flex items-center gap-8">
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium shrink-0">Compact</span>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1.5">
                            <div class="relative w-6 h-6 rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                <span class="text-[9px] font-black text-white" style="letter-spacing: -0.3px;">BC</span>
                            </div>
                            <span class="text-sm font-extrabold tracking-tight text-gray-900">bsnCard</span>
                        </div>
                        <div class="bg-gray-900 rounded-lg px-3 py-1.5 flex items-center gap-1.5">
                            <div class="relative w-6 h-6 rounded-lg bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                <span class="text-[9px] font-black text-white" style="letter-spacing: -0.3px;">BC</span>
                            </div>
                            <span class="text-sm font-extrabold tracking-tight text-white">bsnCard</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- OPTION E: Folded-corner card icon + bsnCard with "Card" colored --}}
            {{-- ============================================================ --}}
            <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm">
                <div class="border-b border-gray-100 px-6 py-3 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Option E</span>
                    <span class="text-xs text-gray-400">Folded-corner card icon + "Card" accented</span>
                </div>
                <div class="grid md:grid-cols-2">
                    <div class="flex items-center justify-center py-16 px-8 bg-white">
                        <div class="flex items-center gap-2.5">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 7C4 5.343 5.343 4 7 4H25C26.657 4 28 5.343 28 7V25C28 26.657 26.657 28 25 28H7C5.343 28 4 26.657 4 25V7Z" fill="#3B82F6"/>
                                <path d="M20 4H25C26.657 4 28 5.343 28 7V12L20 4Z" fill="#2563EB"/>
                                <path d="M20 4V9C20 10.657 21.343 12 23 12H28L20 4Z" fill="#60A5FA"/>
                                <rect x="8" y="15" width="12" height="2" rx="1" fill="white" opacity="0.8"/>
                                <rect x="8" y="19" width="8" height="1.5" rx="0.75" fill="white" opacity="0.45"/>
                                <rect x="8" y="22.5" width="10" height="1.5" rx="0.75" fill="white" opacity="0.45"/>
                            </svg>
                            <span class="text-[22px] font-extrabold tracking-tight text-gray-900">bsn<span class="text-blue-600">Card</span></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center py-16 px-8 bg-gray-900">
                        <div class="flex items-center gap-2.5">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 7C4 5.343 5.343 4 7 4H25C26.657 4 28 5.343 28 7V25C28 26.657 26.657 28 25 28H7C5.343 28 4 26.657 4 25V7Z" fill="#3B82F6"/>
                                <path d="M20 4H25C26.657 4 28 5.343 28 7V12L20 4Z" fill="#2563EB"/>
                                <path d="M20 4V9C20 10.657 21.343 12 23 12H28L20 4Z" fill="#60A5FA"/>
                                <rect x="8" y="15" width="12" height="2" rx="1" fill="white" opacity="0.8"/>
                                <rect x="8" y="19" width="8" height="1.5" rx="0.75" fill="white" opacity="0.45"/>
                                <rect x="8" y="22.5" width="10" height="1.5" rx="0.75" fill="white" opacity="0.45"/>
                            </svg>
                            <span class="text-[22px] font-extrabold tracking-tight text-white">bsn<span class="text-blue-400">Card</span></span>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 flex items-center gap-8">
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium shrink-0">Compact</span>
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1.5">
                            <svg width="20" height="20" viewBox="0 0 32 32" fill="none"><path d="M4 7C4 5.343 5.343 4 7 4H25C26.657 4 28 5.343 28 7V25C28 26.657 26.657 28 25 28H7C5.343 28 4 26.657 4 25V7Z" fill="#3B82F6"/><path d="M20 4H25C26.657 4 28 5.343 28 7V12L20 4Z" fill="#2563EB"/><path d="M20 4V9C20 10.657 21.343 12 23 12H28L20 4Z" fill="#60A5FA"/><rect x="8" y="15" width="12" height="2" rx="1" fill="white" opacity="0.8"/><rect x="8" y="19" width="8" height="1.5" rx="0.75" fill="white" opacity="0.45"/></svg>
                            <span class="text-sm font-extrabold tracking-tight text-gray-900">bsn<span class="text-blue-600">Card</span></span>
                        </div>
                        <div class="bg-gray-900 rounded-lg px-3 py-1.5 flex items-center gap-1.5">
                            <svg width="20" height="20" viewBox="0 0 32 32" fill="none"><path d="M4 7C4 5.343 5.343 4 7 4H25C26.657 4 28 5.343 28 7V25C28 26.657 26.657 28 25 28H7C5.343 28 4 26.657 4 25V7Z" fill="#3B82F6"/><path d="M20 4H25C26.657 4 28 5.343 28 7V12L20 4Z" fill="#2563EB"/><path d="M20 4V9C20 10.657 21.343 12 23 12H28L20 4Z" fill="#60A5FA"/><rect x="8" y="15" width="12" height="2" rx="1" fill="white" opacity="0.8"/><rect x="8" y="19" width="8" height="1.5" rx="0.75" fill="white" opacity="0.45"/></svg>
                            <span class="text-sm font-extrabold tracking-tight text-white">bsn<span class="text-blue-400">Card</span></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- OPTION F: Text-only with dot accent on the "i" replaced by card --}}
            {{-- ============================================================ --}}
            <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden shadow-sm">
                <div class="border-b border-gray-100 px-6 py-3 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Option F</span>
                    <span class="text-xs text-gray-400">Text-only, "Card" bold + blue, minimal</span>
                </div>
                <div class="grid md:grid-cols-2">
                    <div class="flex items-center justify-center py-16 px-8 bg-white">
                        <div class="flex items-baseline gap-0">
                            <span class="text-[26px] font-bold tracking-tight text-gray-400">bsn</span>
                            <span class="text-[26px] font-extrabold tracking-tight text-gray-900">Car</span>
                            <span class="relative inline-block text-[26px] font-extrabold tracking-tight text-gray-900">d<span class="absolute -bottom-[1px] -right-[1px] w-[7px] h-[7px] rounded-[2px] bg-blue-500"></span></span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center py-16 px-8 bg-gray-900">
                        <div class="flex items-baseline gap-0">
                            <span class="text-[26px] font-bold tracking-tight text-gray-500">bsn</span>
                            <span class="text-[26px] font-extrabold tracking-tight text-white">Car</span>
                            <span class="relative inline-block text-[26px] font-extrabold tracking-tight text-white">d<span class="absolute -bottom-[1px] -right-[1px] w-[7px] h-[7px] rounded-[2px] bg-blue-500"></span></span>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 flex items-center gap-8">
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium shrink-0">Compact</span>
                    <div class="flex items-center gap-6">
                        <div class="flex items-baseline gap-0">
                            <span class="text-sm font-bold tracking-tight text-gray-400">bsn</span>
                            <span class="text-sm font-extrabold tracking-tight text-gray-900">Car</span>
                            <span class="relative inline-block text-sm font-extrabold tracking-tight text-gray-900">d<span class="absolute -bottom-[0px] -right-[1px] w-[4px] h-[4px] rounded-[1px] bg-blue-500"></span></span>
                        </div>
                        <div class="bg-gray-900 rounded-lg px-3 py-1.5 flex items-baseline gap-0">
                            <span class="text-sm font-bold tracking-tight text-gray-500">bsn</span>
                            <span class="text-sm font-extrabold tracking-tight text-white">Car</span>
                            <span class="relative inline-block text-sm font-extrabold tracking-tight text-white">d<span class="absolute -bottom-[0px] -right-[1px] w-[4px] h-[4px] rounded-[1px] bg-blue-500"></span></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <p class="text-center text-xs text-gray-400 mt-10">Tell me which option (A-F) you want and I'll apply it across the entire app.</p>
    </div>

</body>
</html>
