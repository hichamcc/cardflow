<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BsnCard vs {{ $competitor['name'] }} — Best Digital Business Card Alternative</title>
    <meta name="description" content="{{ $competitor['meta_description'] }}">
    <link rel="canonical" href="{{ url('/compare/bsncard-vs-' . $competitor['slug']) }}">

    <meta property="og:title" content="BsnCard vs {{ $competitor['name'] }}">
    <meta property="og:description" content="{{ $competitor['meta_description'] }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url('/compare/bsncard-vs-' . $competitor['slug']) }}">
    <meta property="og:site_name" content="BsnCard">

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type'    => 'WebPage',
        'name'        => 'BsnCard vs ' . $competitor['name'],
        'description' => $competitor['meta_description'],
        'url'         => url('/compare/bsncard-vs-' . $competitor['slug']),
        'breadcrumb'  => [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',    'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Compare', 'item' => url('/compare')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => 'BsnCard vs ' . $competitor['name'], 'item' => url('/compare/bsncard-vs-' . $competitor['slug'])],
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } }
            }
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

    {{-- Breadcrumb --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 pt-6">
        <nav class="flex items-center gap-1.5 text-xs text-gray-400">
            <a href="/" class="hover:text-gray-600">Home</a>
            <span>/</span>
            <a href="{{ url('/compare') }}" class="hover:text-gray-600">Compare</a>
            <span>/</span>
            <span class="text-gray-600">BsnCard vs {{ $competitor['name'] }}</span>
        </nav>
    </div>

    {{-- Hero --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 pt-12 pb-10 text-center">
        <div class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-medium text-gray-500 mb-6">
            Alternative Comparison
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 mb-4">
            BsnCard vs {{ $competitor['name'] }}
        </h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">
            {{ $competitor['tagline'] }} Here's how it compares to BsnCard.
        </p>
    </section>

    {{-- VS Badge --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 pb-12">
        <div class="flex items-center justify-center gap-6 sm:gap-12">
            {{-- BsnCard --}}
            <div class="flex flex-col items-center gap-3">
                <div class="h-16 w-16 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-center">
                    <svg width="36" height="34" viewBox="0 0 38 36" fill="none">
                        <g transform="rotate(-14 19 18)"><rect x="6" y="7" width="22" height="16" rx="3" fill="#9CA3AF" opacity="0.3"/></g>
                        <g transform="rotate(-5 19 18)"><rect x="5" y="8" width="22" height="16" rx="3" fill="#0ea5e9" opacity="0.3"/></g>
                        <g transform="rotate(5 19 18)"><rect x="5" y="10" width="22" height="16" rx="3" fill="#0ea5e9"/><rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/><rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/><rect x="8.5" y="20.5" width="8" height="1.5" rx="0.75" fill="white" opacity="0.4"/></g>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-gray-900">BsnCard</span>
                <span class="rounded-full bg-sky-100 text-sky-700 text-xs font-semibold px-2.5 py-0.5">Recommended</span>
            </div>

            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-400">vs</div>

            {{-- Competitor --}}
            <div class="flex flex-col items-center gap-3">
                <div class="h-16 w-16 rounded-2xl border border-gray-200 bg-gray-50 flex items-center justify-center">
                    <span class="text-2xl font-black" style="color: {{ $competitor['color'] }}">{{ substr($competitor['name'], 0, 1) }}</span>
                </div>
                <span class="text-sm font-semibold text-gray-900">{{ $competitor['name'] }}</span>
                <span class="rounded-full bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-0.5">Competitor</span>
            </div>
        </div>
    </section>

    {{-- Feature Comparison Table --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 pb-16">
        <h2 class="text-xl font-bold text-gray-900 mb-6 text-center">Feature Comparison</h2>
        <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left px-5 py-3.5 font-semibold text-gray-600 w-1/2">Feature</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-sky-600">BsnCard</th>
                        <th class="text-center px-5 py-3.5 font-semibold text-gray-500">{{ $competitor['name'] }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($features as $row)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5 text-gray-700">{{ $row['label'] }}</td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($row['bsn'])
                                    <svg class="inline-block h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <svg class="inline-block h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($row['competitor'])
                                    <svg class="inline-block h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <svg class="inline-block h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- Why Switch --}}
    <section class="bg-gray-50 border-y border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-14">
            <div class="grid md:grid-cols-2 gap-10 items-start">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Why switch from {{ $competitor['name'] }} to BsnCard?</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $competitor['why_switch'] }}</p>
                    <a href="{{ route('register') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-sky-600 text-white font-semibold text-sm rounded-xl hover:bg-sky-700 transition-colors shadow-md shadow-sky-600/20">
                        Try BsnCard for free
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">What {{ $competitor['name'] }} does well</h3>
                        <ul class="space-y-2">
                            @foreach ($competitor['pros'] as $pro)
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <svg class="h-4 w-4 mt-0.5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    {{ $pro }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">Where {{ $competitor['name'] }} falls short</h3>
                        <ul class="space-y-2">
                            @foreach ($competitor['cons'] as $con)
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <svg class="h-4 w-4 mt-0.5 text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    {{ $con }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 py-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-4 max-w-2xl mx-auto">
            @foreach ($competitor['faqs'] as $faq)
                <div class="rounded-xl border border-gray-200 bg-white p-5">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $faq['q'] }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gray-900 text-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-16 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold mb-3">Ready to upgrade from {{ $competitor['name'] }}?</h2>
            <p class="text-gray-400 mb-8 max-w-xl mx-auto">Create your digital business card and start managing your network — free, no credit card required.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-sky-500 text-white font-semibold rounded-xl hover:bg-sky-400 transition-colors shadow-lg shadow-sky-500/25">
                Get started free
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

    {{-- Other comparisons --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 py-12">
        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-400 mb-4">More comparisons</h3>
        <div class="flex flex-wrap gap-2">
            @foreach (['hihello', 'linktree', 'blinq', 'popl', 'haystack'] as $slug)
                @if ($slug !== $competitor['slug'])
                    <a href="{{ url('/compare/bsncard-vs-' . $slug) }}" class="rounded-full border border-gray-200 px-4 py-1.5 text-sm text-gray-600 hover:border-sky-300 hover:text-sky-600 transition-colors">
                        BsnCard vs {{ ucfirst($slug) }}
                    </a>
                @endif
            @endforeach
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} BsnCard. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="{{ route('legal.privacy') }}" class="text-sm text-gray-400 hover:text-gray-600">Privacy</a>
                <a href="{{ route('legal.terms') }}" class="text-sm text-gray-400 hover:text-gray-600">Terms</a>
                <a href="{{ url('/compare') }}" class="text-sm text-gray-400 hover:text-gray-600">Compare</a>
            </div>
        </div>
    </footer>

</body>
</html>
