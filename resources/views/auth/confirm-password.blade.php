<x-layouts.auth :title="__('Confirm password')">
<div class="space-y-6">
    <x-auth-header
        :title="__('Confirm your password')"
        :description="__('This is a secure area. Please confirm your password before continuing.')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <x-form method="post" action="{{ route('confirmation.store') }}" class="space-y-5">
        <!-- Password -->
        <x-input
            type="password"
            :label="__('Password')"
            name="password"
            required
            autocomplete="new-password"
            placeholder="Enter your password"
        />

        <x-button class="w-full">{{ __('Confirm') }}</x-button>
    </x-form>
</div>
</x-layouts.auth>
