<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Refund Policy - BsnCard</title>
    <meta name="description" content="BsnCard Refund Policy. Learn about our refund and cancellation process for paid subscriptions.">
    <link rel="canonical" href="{{ url('/refund') }}">

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
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-navy-900 mb-2 tracking-tight">Refund Policy</h1>
            <p class="text-sm text-navy-700/50 mb-10">Last updated: {{ date('F j, Y') }}</p>

            <div class="prose prose-navy max-w-none space-y-8 text-sm leading-relaxed text-navy-700/70">

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">1. Overview</h2>
                    <p>At BsnCard, we want you to be completely satisfied with your subscription. This Refund Policy outlines when and how you can request a refund for paid plans.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">2. Free Plan</h2>
                    <p>BsnCard offers a free-forever plan with core features. Since no payment is involved, no refund applies. We encourage you to try the free plan before upgrading to a paid subscription.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">3. Paid Subscriptions &mdash; 14-Day Money-Back Guarantee</h2>
                    <p>All paid subscriptions (Pro and Business plans) come with a <strong>14-day money-back guarantee</strong> from the date of your initial purchase or upgrade.</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li>If you are not satisfied with the Service for any reason, you may request a full refund within 14 days of your first payment.</li>
                        <li>Refund requests must be submitted via email to <strong>support@bsncard.app</strong> or through a <a href="{{ url('/support') }}" class="text-brand-500 hover:text-brand-600 underline">support ticket</a>.</li>
                        <li>Refunds are processed within 5&ndash;10 business days and returned to the original payment method.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">4. After the 14-Day Period</h2>
                    <p>After the initial 14-day guarantee period:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li><strong>No partial refunds</strong> are issued for the remaining time in a billing cycle.</li>
                        <li>You may <strong>cancel your subscription at any time</strong> from your account settings. Cancellation takes effect at the end of the current billing period, and you will retain access to paid features until then.</li>
                        <li>We do not provide refunds for unused portions of a billing period after cancellation.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">5. Renewal Refunds</h2>
                    <p>Subscriptions renew automatically. If you forget to cancel before a renewal:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li>You may request a refund within <strong>48 hours</strong> of the renewal charge, provided you have not actively used the Service during that renewal period.</li>
                        <li>After 48 hours, the renewal charge is non-refundable, but you may cancel to prevent future renewals.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">6. Annual Subscriptions</h2>
                    <p>For annual subscriptions:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li>The 14-day money-back guarantee applies from the date of purchase.</li>
                        <li>After the 14-day period, no refunds or prorated credits are issued for annual plans.</li>
                        <li>You may cancel at any time, and access continues until the end of the annual billing period.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">7. Exceptions</h2>
                    <p>We reserve the right to deny refund requests in the following cases:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li>Evidence of abuse, fraud, or violation of our <a href="{{ route('legal.terms') }}" class="text-brand-500 hover:text-brand-600 underline">Terms of Service</a></li>
                        <li>Repeated subscription and refund cycles (e.g., subscribing and requesting refunds multiple times)</li>
                        <li>Accounts terminated for cause due to policy violations</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">8. How to Request a Refund</h2>
                    <p>To request a refund, please contact us with your account email and reason for the request:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li><strong>Email:</strong> support@bsncard.app</li>
                        <li><strong>Support ticket:</strong> Log in and create a ticket from the <a href="{{ url('/support') }}" class="text-brand-500 hover:text-brand-600 underline">Support</a> page</li>
                    </ul>
                    <p class="mt-2">We aim to respond to all refund requests within 2 business days.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">9. Payment Processor</h2>
                    <p>All payments and refunds are processed through Paddle, our merchant of record. Refunds will appear on your statement from Paddle. For payment-related questions, you may also contact <a href="https://www.paddle.com/support" target="_blank" class="text-brand-500 hover:text-brand-600 underline">Paddle Support</a>.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">10. Changes to This Policy</h2>
                    <p>We may update this Refund Policy from time to time. Changes will be posted on this page with an updated "Last updated" date. Continued use of the Service after changes constitutes acceptance.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">11. Contact Us</h2>
                    <p>If you have any questions about this Refund Policy, please reach out to us:</p>
                    <ul class="list-none mt-2 space-y-1">
                        <li><strong>Email:</strong> support@bsncard.app</li>
                        <li><strong>Contact form:</strong> <a href="{{ url('/#contact-form') }}" class="text-brand-500 hover:text-brand-600 underline">bsncard.app/contact</a></li>
                    </ul>
                </section>
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
