<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - BsnCard</title>
    <meta name="description" content="Get in touch with the BsnCard team. We're here to help.">
    <link rel="canonical" href="{{ url('/contact') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        cream: { 50: '#FEFDFB', 100: '#FBF8F3', 200: '#F7F0E6', 300: '#EDE4D3' },
                        navy: { 600: '#243B53', 700: '#1E3A5F', 800: '#172E4A', 900: '#0F2035', 950: '#0A1628' },
                        brand: { 50: '#EFF6FF', 100: '#DBEAFE', 200: '#BFDBFE', 300: '#93C5FD', 400: '#60A5FA', 500: '#3B82F6', 600: '#2563EB', 700: '#1D4ED8', 800: '#1E40AF', 900: '#1E3A8A' },
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream-100 font-sans text-navy-900 antialiased">

    {{-- Navigation --}}
    <nav class="fixed top-0 w-full bg-cream-100/80 backdrop-blur-xl z-50 border-b border-cream-300/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-2">
                    <svg width="32" height="30" viewBox="0 0 38 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g transform="rotate(-14 19 18)"><rect x="6" y="7" width="22" height="16" rx="3" fill="#9CA3AF" opacity="0.3"/></g>
                        <g transform="rotate(-5 19 18)"><rect x="5" y="8" width="22" height="16" rx="3" fill="#3B82F6" opacity="0.3"/></g>
                        <g transform="rotate(5 19 18)">
                            <rect x="5" y="10" width="22" height="16" rx="3" fill="#3B82F6"/>
                            <rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/>
                            <rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                            <rect x="8.5" y="20.5" width="8" height="1.5" rx="0.75" fill="white" opacity="0.4"/>
                        </g>
                    </svg>
                    <span class="text-lg font-bold text-navy-900">bsn<span class="text-brand-500">Card</span></span>
                </a>
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-5 py-2 bg-brand-500 text-white text-sm font-semibold rounded-full hover:bg-brand-600 transition-all">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-navy-700/70 hover:text-navy-900 transition-colors">Sign in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2 border-2 border-navy-900 text-navy-900 text-sm font-semibold rounded-full hover:bg-navy-900 hover:text-white transition-all">Sign up</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main class="pt-28 pb-20">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-navy-900 mb-2 tracking-tight">Contact Us</h1>
            <p class="text-sm text-navy-700/50 mb-10">We typically reply within one business day.</p>

            @if (session('contact_success'))
                <div class="mb-8 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                    {{ session('contact_success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-navy-900 mb-1.5">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full rounded-xl border border-cream-300 bg-white px-4 py-2.5 text-sm text-navy-900 placeholder-navy-700/30 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition"
                        placeholder="Your name"
                    >
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-navy-900 mb-1.5">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-xl border border-cream-300 bg-white px-4 py-2.5 text-sm text-navy-900 placeholder-navy-700/30 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-navy-900 mb-1.5">Subject <span class="text-navy-700/40 font-normal">(optional)</span></label>
                    <input
                        type="text"
                        id="subject"
                        name="subject"
                        value="{{ old('subject') }}"
                        class="w-full rounded-xl border border-cream-300 bg-white px-4 py-2.5 text-sm text-navy-900 placeholder-navy-700/30 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition"
                        placeholder="What's this about?"
                    >
                    @error('subject')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-navy-900 mb-1.5">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="5"
                        required
                        class="w-full rounded-xl border border-cream-300 bg-white px-4 py-2.5 text-sm text-navy-900 placeholder-navy-700/30 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition resize-none"
                        placeholder="How can we help you?"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-brand-500 text-white font-semibold text-sm hover:bg-brand-600 transition-colors shadow-lg shadow-brand-500/25"
                >
                    Send Message
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-cream-300/60">
                <p class="text-sm text-navy-700/50">You can also reach us directly at <a href="mailto:support@bsncard.app" class="text-brand-500 hover:text-brand-600">support@bsncard.app</a></p>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="py-12 border-t border-cream-300/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-navy-700/40">&copy; {{ date('Y') }} BsnCard. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('legal.privacy') }}" class="text-sm text-navy-700/50 hover:text-navy-900 transition-colors">Privacy Policy</a>
                    <a href="{{ route('legal.terms') }}" class="text-sm text-navy-700/50 hover:text-navy-900 transition-colors">Terms of Service</a>
                    <a href="{{ route('legal.refund') }}" class="text-sm text-navy-700/50 hover:text-navy-900 transition-colors">Refund Policy</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
