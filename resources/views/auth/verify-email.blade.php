<x-layouts.auth :title="__('Verify your email')">
<div class="space-y-6">
    <x-auth-header :title="__('Check your email')" :description="__('We\'ve sent a verification link to your email address. Click it to verify your account.')" />

    @if (session('status') == 'verification-link-sent')
        <div class="rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 p-4">
            <p class="text-center text-sm font-medium text-emerald-700 dark:text-emerald-400">
                {{ __('A new verification link has been sent to your email address.') }}
            </p>
        </div>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <x-form method="post" action="{{ route('verification.store') }}">
            <x-button class="w-full">
                {{ __('Resend verification email') }}
            </x-button>
        </x-form>
        <x-form method="post" action="{{ route('logout') }}">
            <x-button variant="link">{{ __('Log out') }}</x-button>
        </x-form>
    </div>
</div>
</x-layouts.auth>
