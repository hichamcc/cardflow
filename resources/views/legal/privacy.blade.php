<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - BsnCard</title>
    <meta name="description" content="BsnCard Privacy Policy. Learn how we collect, use, and protect your personal data.">
    <link rel="canonical" href="{{ url('/privacy') }}">

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
                <a href="/" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-navy-900">BsnCard</span>
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
            <h1 class="text-3xl sm:text-4xl font-extrabold text-navy-900 mb-2 tracking-tight">Privacy Policy</h1>
            <p class="text-sm text-navy-700/50 mb-10">Last updated: {{ date('F j, Y') }}</p>

            <div class="prose prose-navy max-w-none space-y-8 text-sm leading-relaxed text-navy-700/70">

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">1. Introduction</h2>
                    <p>BsnCard ("we", "us", or "our") respects your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your personal data when you use our digital business card and CRM platform ("Service"). By using the Service, you consent to the practices described in this policy.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">2. Information We Collect</h2>

                    <h3 class="text-base font-semibold text-navy-900 mb-2 mt-4">2.1 Information You Provide</h3>
                    <ul class="list-disc pl-5 space-y-1.5">
                        <li><strong>Account information:</strong> Name, email address, and password when you register.</li>
                        <li><strong>Business card content:</strong> Job title, company, phone number, social media links, profile photos, and any other information you add to your digital cards.</li>
                        <li><strong>CRM data:</strong> Contact details, notes, follow-ups, deal information, events, and interaction logs you create within the Service.</li>
                        <li><strong>Payment information:</strong> Billing details are processed by our payment provider (Paddle) and are not stored on our servers.</li>
                        <li><strong>Support communications:</strong> Messages you send through support tickets or the contact form.</li>
                    </ul>

                    <h3 class="text-base font-semibold text-navy-900 mb-2 mt-4">2.2 Information Collected Automatically</h3>
                    <ul class="list-disc pl-5 space-y-1.5">
                        <li><strong>Usage data:</strong> Pages visited, features used, clicks, and interactions within the Service.</li>
                        <li><strong>Device information:</strong> Browser type, operating system, IP address, and device identifiers.</li>
                        <li><strong>Card analytics:</strong> View counts, QR code scans, and vCard downloads for your business cards.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">3. How We Use Your Information</h2>
                    <p>We use collected information to:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li>Provide, operate, and maintain the Service</li>
                        <li>Process your transactions and manage your subscription</li>
                        <li>Send transactional emails (follow-up reminders, weekly digests, ticket replies)</li>
                        <li>Provide customer support and respond to inquiries</li>
                        <li>Generate analytics and insights about your card performance</li>
                        <li>Improve the Service based on usage patterns</li>
                        <li>Detect and prevent fraud, abuse, or security threats</li>
                        <li>Comply with legal obligations</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">4. Data Sharing and Disclosure</h2>
                    <p>We do not sell your personal data. We may share your information with:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li><strong>Service providers:</strong> Third-party vendors that help us operate the Service (e.g., hosting, email delivery, payment processing via Paddle).</li>
                        <li><strong>Public card viewers:</strong> Information on your public business cards is visible to anyone with the card link or QR code. Only include information you are comfortable sharing publicly.</li>
                        <li><strong>Legal requirements:</strong> When required by law, subpoena, or to protect our rights, safety, or property.</li>
                        <li><strong>Business transfers:</strong> In connection with a merger, acquisition, or sale of assets, your data may be transferred to the acquiring entity.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">5. Data Security</h2>
                    <p>We implement industry-standard security measures to protect your data, including:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li>Encryption of data in transit (TLS/SSL)</li>
                        <li>Secure password hashing</li>
                        <li>Regular security audits and updates</li>
                        <li>Access controls to limit data access to authorized personnel</li>
                    </ul>
                    <p class="mt-2">While we take reasonable measures to protect your data, no method of electronic storage or transmission is 100% secure.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">6. Data Retention</h2>
                    <p>We retain your data for as long as your account is active or as needed to provide the Service. If you delete your account, we will delete your personal data within 30 days, except where we are required to retain it for legal, tax, or accounting purposes.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">7. Your Rights</h2>
                    <p>Depending on your jurisdiction, you may have the right to:</p>
                    <ul class="list-disc pl-5 space-y-1.5 mt-2">
                        <li><strong>Access:</strong> Request a copy of the personal data we hold about you.</li>
                        <li><strong>Rectification:</strong> Correct inaccurate or incomplete data.</li>
                        <li><strong>Erasure:</strong> Request deletion of your personal data.</li>
                        <li><strong>Portability:</strong> Export your data in a machine-readable format (vCard export is available for contacts).</li>
                        <li><strong>Objection:</strong> Object to certain processing activities.</li>
                        <li><strong>Withdraw consent:</strong> Where processing is based on consent, you may withdraw it at any time.</li>
                    </ul>
                    <p class="mt-2">To exercise any of these rights, please contact us at support@bsncard.app.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">8. Cookies and Tracking</h2>
                    <p>We use essential cookies to maintain your session and remember your preferences. We do not use third-party advertising cookies. Session cookies are deleted when you close your browser. Persistent cookies (such as authentication tokens) remain until they expire or you delete them.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">9. Third-Party Services</h2>
                    <p>The Service may contain links to third-party websites or integrate with third-party services. We are not responsible for the privacy practices of these third parties. We encourage you to review their privacy policies.</p>
                    <p class="mt-2">Our payment processing is handled by Paddle. Please refer to <a href="https://www.paddle.com/legal/privacy" target="_blank" class="text-brand-500 hover:text-brand-600 underline">Paddle's Privacy Policy</a> for information about how they handle your payment data.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">10. Children's Privacy</h2>
                    <p>The Service is not directed to individuals under the age of 18. We do not knowingly collect personal data from children. If you believe a child has provided us with personal data, please contact us and we will promptly delete it.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">11. International Data Transfers</h2>
                    <p>Your data may be processed and stored in countries outside your jurisdiction. We ensure appropriate safeguards are in place to protect your data in accordance with applicable laws.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">12. Changes to This Policy</h2>
                    <p>We may update this Privacy Policy from time to time. We will notify you of significant changes by posting a notice on the Service or sending an email. The "Last updated" date at the top of this page indicates when this policy was last revised.</p>
                </section>

                <section>
                    <h2 class="text-lg font-bold text-navy-900 mb-3">13. Contact Us</h2>
                    <p>If you have questions or concerns about this Privacy Policy or our data practices, please contact us at:</p>
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
