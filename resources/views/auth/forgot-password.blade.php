<x-layouts.auth :title="__('Forgot password')">
<div class="space-y-6">
    <x-auth-header :title="__('Forgot your password?')" :description="__('No worries. Enter your email and we\'ll send you a reset link.')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <x-form method="post" action="{{ route('password.email') }}" class="space-y-5">
        <!-- Email Address -->
        <x-input
            type="email"
            :label="__('Email address')"
            name="email"
            required
            autofocus
            placeholder="you@example.com"
        />

        <x-button class="w-full">{{ __('Send reset link') }}</x-button>
    </x-form>

    <div class="relative">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200 dark:border-gray-800"></div></div>
        <div class="relative flex justify-center text-xs"><span class="bg-white dark:bg-gray-900 px-3 text-gray-400">or</span></div>
    </div>

    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
        {{ __('Remember your password?') }}
        <x-link :href="route('login')" class="font-semibold">{{ __('Back to login') }}</x-link>
    </p>
</div>
</x-layouts.auth>
