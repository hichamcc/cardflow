<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms of Service - BsnCard</title>
    <meta name="description" content="BsnCard Terms of Service. Read our terms and conditions for using our digital business card platform.">
    <link rel="canonical" href="{{ url('/terms') }}">

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
            <h1 class="text-3xl sm:text-4xl font-extrabold text-navy-900 mb-2 tracking-tight">Terms of Service</h1>
            <p class="text-sm text-navy-700/50 mb-10">Last updated: {{ date('F j, Y') }}</p>

            <div class="prose prose-navy max-w-none space-y-8 text-sm leading-relaxed text-navy-700/70">

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">1. Acceptance of Terms</h2>
                    <p>By accessing or using BsnCard ("Service"), operated by code by hicham ("we", "us", or "our"), you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use the Service.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">2. Description of Service</h2>
                    <p>BsnCard is a software-as-a-service (SaaS) platform that allows users to create digital business cards, share them via QR codes or links, and manage contacts with built-in CRM features including deal tracking, follow-ups, notes, and calendar management.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">3. Account Registration</h2>
                    <p>To use certain features, you must create an account. You agree to:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li>Provide accurate and complete registration information</li>
                        <li>Maintain the security of your password and account</li>
                        <li>Promptly update your account information if it changes</li>
                        <li>Accept responsibility for all activities that occur under your account</li>
                    </ul>
                    <p class="mt-2">You must be at least 18 years old to create an account and use the Service.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">4. Subscription Plans and Billing</h2>
                    <p>BsnCard offers free and paid subscription tiers. By subscribing to a paid plan, you agree to the following:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li><strong>Billing cycle:</strong> Paid plans are billed monthly or annually, as selected at the time of purchase.</li>
                        <li><strong>Automatic renewal:</strong> Subscriptions automatically renew at the end of each billing period unless cancelled before the renewal date.</li>
                        <li><strong>Payment processing:</strong> Payments are processed securely through our payment provider, Paddle. By subscribing, you also agree to <a href="https://www.paddle.com/legal/terms" target="_blank" class="text-brand-500 hover:text-brand-600 underline">Paddle's Terms of Service</a>.</li>
                        <li><strong>Price changes:</strong> We may change subscription prices with at least 30 days' prior notice. Continued use of the Service after a price change constitutes acceptance.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">5. Free Plan Limitations</h2>
                    <p>The free plan includes limited features as described on our pricing page, including a maximum of 3 business cards and 20 CRM interactions per month. We reserve the right to modify free plan limits at any time.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">6. Acceptable Use</h2>
                    <p>You agree not to use the Service to:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li>Violate any applicable laws or regulations</li>
                        <li>Infringe on the intellectual property rights of others</li>
                        <li>Upload or share content that is unlawful, defamatory, obscene, or harmful</li>
                        <li>Distribute spam, phishing, or malicious content through your digital business cards</li>
                        <li>Attempt to gain unauthorized access to the Service or its related systems</li>
                        <li>Use the Service for any fraudulent or misleading purposes</li>
                        <li>Interfere with or disrupt the integrity or performance of the Service</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">7. Intellectual Property</h2>
                    <p>The Service, including its design, features, code, and branding, is owned by code by hicham and protected by intellectual property laws. You retain ownership of any content you upload (photos, text, logos). By uploading content, you grant us a limited license to display and process it as part of the Service.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">8. Data and Privacy</h2>
                    <p>Your use of the Service is also governed by our <a href="{{ route('legal.privacy') }}" class="text-brand-500 hover:text-brand-600 underline">Privacy Policy</a>. You are responsible for ensuring that any personal data you collect via your business cards (e.g. contact information from people who save your card) complies with applicable data protection laws.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">9. Cancellation and Termination</h2>
                    <ul class="list-disc pl-5 space-y-1.5">
                        <li><strong>By you:</strong> You may cancel your subscription at any time from your account settings. Cancellation takes effect at the end of the current billing period. See our <a href="{{ route('legal.refund') }}" class="text-brand-500 hover:text-brand-600 underline">Refund Policy</a> for details on refunds.</li>
                        <li><strong>By us:</strong> We may suspend or terminate your account if you violate these Terms, with or without notice. In the event of termination for cause, you will not be entitled to a refund.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">10. Service Availability</h2>
                    <p>We strive to maintain high availability but do not guarantee uninterrupted access. The Service may be temporarily unavailable for maintenance, updates, or due to circumstances beyond our control. We are not liable for any losses resulting from service downtime.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">11. Limitation of Liability</h2>
                    <p>To the maximum extent permitted by law, code by hicham shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to loss of profits, data, or business opportunities, arising from your use of the Service. Our total liability shall not exceed the amount you paid us in the 12 months preceding the claim.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">12. Disclaimer of Warranties</h2>
                    <p>The Service is provided "as is" and "as available" without any warranties of any kind, whether express or implied, including but not limited to implied warranties of merchantability, fitness for a particular purpose, and non-infringement.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">13. Changes to These Terms</h2>
                    <p>We may update these Terms from time to time. We will notify you of significant changes by posting a notice on the Service or sending you an email. Continued use of the Service after changes are posted constitutes acceptance of the revised Terms.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">14. Governing Law</h2>
                    <p>These Terms shall be governed by and construed in accordance with applicable laws, without regard to conflict of law provisions. Any disputes arising under these Terms shall be resolved through good-faith negotiation, and if necessary, binding arbitration.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">15. Contact Us</h2>
                    <p>If you have questions about these Terms, please contact us at:</p>
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
