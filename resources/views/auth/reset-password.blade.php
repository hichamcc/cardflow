<x-layouts.auth :title="__('Reset password')">
<div class="space-y-6">
    <x-auth-header :title="__('Set a new password')" :description="__('Choose a strong password for your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <x-form method="post" action="{{ route('password.store') }}" class="space-y-5">
        <input type="hidden" name="token" value="{{ $request->token }}">

        <!-- Email Address -->
        <x-input
            type="email"
            :label="__('Email')"
            name="email"
            :value="$request->email"
            required
            autocomplete="email"
        />

        <!-- Password -->
        <x-input
            type="password"
            :label="__('New password')"
            name="password"
            required
            autocomplete="new-password"
            placeholder="Enter new password"
        />

        <!-- Confirm Password -->
        <x-input
            type="password"
            :label="__('Confirm new password')"
            name="password_confirmation"
            required
            autocomplete="new-password"
            placeholder="Confirm new password"
        />

        <x-button class="w-full">{{ __('Reset password') }}</x-button>
    </x-form>
</div>
</x-layouts.auth>
