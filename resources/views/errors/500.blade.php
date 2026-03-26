<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Server Error - BsnCard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } } }</script>
</head>
<body class="min-h-screen bg-gray-50 font-sans antialiased flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="flex justify-center mb-8">
            <svg width="64" height="60" viewBox="0 0 38 36" fill="none" class="opacity-20">
                <g transform="rotate(-14 19 18)"><rect x="6" y="7" width="22" height="16" rx="3" fill="#9CA3AF" opacity="0.3"/></g>
                <g transform="rotate(-5 19 18)"><rect x="5" y="8" width="22" height="16" rx="3" fill="#3B82F6" opacity="0.3"/></g>
                <g transform="rotate(5 19 18)"><rect x="5" y="10" width="22" height="16" rx="3" fill="#3B82F6"/><rect x="8.5" y="14" width="10" height="2" rx="1" fill="white" opacity="0.8"/><rect x="8.5" y="17.5" width="6.5" height="1.5" rx="0.75" fill="white" opacity="0.4"/><rect x="8.5" y="20.5" width="8" height="1.5" rx="0.75" fill="white" opacity="0.4"/></g>
            </svg>
        </div>
        <p class="text-8xl font-black text-gray-200 mb-2">500</p>
        <h1 class="text-xl font-bold text-gray-900 mb-2">Something went wrong</h1>
        <p class="text-sm text-gray-500 mb-8 leading-relaxed">We're having trouble processing your request. Please try again in a moment.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition-colors">
                Go home
            </a>
            <a href="javascript:location.reload()" class="inline-flex items-center justify-center px-6 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                Try again
            </a>
        </div>
    </div>
</body>
</html>
