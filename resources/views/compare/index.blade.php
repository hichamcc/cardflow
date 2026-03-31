<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BsnCard Alternatives & Comparisons — Digital Business Card Tools</title>
    <meta name="description" content="See how BsnCard compares to HiHello, Linktree, Blinq, Popl, and Haystack. Find out which digital business card tool is best for professionals.">
    <link rel="canonical" href="{{ url('/compare') }}">

    <meta property="og:title" content="BsnCard vs Other Digital Business Card Tools">
    <meta property="og:description" content="In-depth comparisons between BsnCard and popular alternatives. Find out why professionals choose BsnCard.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/compare') }}">
    <meta property="og:site_name" content="BsnCard">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="bg-white font-sans text-gray-900 antialiased">

    {{-- Nav --}}
    <nav class="border-b border-gray-100 bg-white/90 backdrop-blur sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <svg width="28" height="26" viewBox="0 0 38 36" fill="none">
                    <g transform="rotate(-14 19 18)"><rect x="6" y="7" width="22" height="16" rx="3" fill="#9CA3AF" opacity="0.3"/></g>
                    <g transform="rotate(-5 19 18)"><rect x="5" y="8" width="22" height="16" rx="3" fill="#0ea5e9" opacity="0.3"/></g>
                    <g transform="rotate(5 19 18)"><rect x="5" y="10" width="22" height="16" rx="3" fill="#0ea5e9"/><rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/><rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/><rect x="8.5" y="20.5" width="8" height="1.5" rx="0.75" fill="white" opacity="0.4"/></g>
                </svg>
                <span class="text-base font-bold text-gray-900">bsn<span class="text-sky-500">Card</span></span>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900">Log in</a>
                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-1.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800">Get started free</a>
            </div>
        </div>
    </nav>

    {{-- Header --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 pt-14 pb-10 text-center">
        <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-medium text-gray-500 mb-5">
            Comparisons
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 mb-4">
            BsnCard vs The Competition
        </h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">
            See how BsnCard stacks up against the most popular digital business card tools — feature by feature.
        </p>
    </section>

    {{-- Cards grid --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 pb-20">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($competitors as $slug => $competitor)
                <a href="{{ url('/compare/bsncard-vs-' . $slug) }}" class="group relative rounded-2xl border border-gray-200 bg-white p-6 hover:border-sky-300 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl border border-gray-100 bg-gray-50 flex items-center justify-center">
                                <span class="text-lg font-black" style="color: {{ $competitor['color'] }}">{{ substr($competitor['name'], 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">BsnCard vs</p>
                                <p class="font-bold text-gray-900">{{ $competitor['name'] }}</p>
                            </div>
                        </div>
                        <svg class="h-4 w-4 text-gray-300 group-hover:text-sky-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $competitor['tagline'] }}</p>
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        @foreach (array_slice($competitor['cons'], 0, 2) as $con)
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-50 text-red-600 text-xs px-2 py-0.5">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                {{ Str::limit($con, 28) }}
                            </span>
                        @endforeach
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Bottom CTA --}}
    <section class="bg-gray-900 text-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-14 text-center">
            <h2 class="text-2xl font-bold mb-3">Make the switch to BsnCard</h2>
            <p class="text-gray-400 mb-7 max-w-xl mx-auto">Digital business cards with a built-in CRM. Free to start, no credit card required.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-sky-500 text-white font-semibold rounded-xl hover:bg-sky-400 transition-colors shadow-lg shadow-sky-500/25">
                Get started free
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} BsnCard. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="{{ route('legal.privacy') }}" class="text-sm text-gray-400 hover:text-gray-600">Privacy</a>
                <a href="{{ route('legal.terms') }}" class="text-sm text-gray-400 hover:text-gray-600">Terms</a>
                <a href="{{ route('contact') }}" class="text-sm text-gray-400 hover:text-gray-600">Contact</a>
            </div>
        </div>
    </footer>

</body>
</html>
