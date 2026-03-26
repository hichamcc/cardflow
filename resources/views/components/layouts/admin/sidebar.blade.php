<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="layout sidebar min-h-screen bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300">
        {{-- Impersonation Banner --}}
        @if (session('impersonating_from'))
            <div class="bg-yellow-400 text-yellow-900 text-center py-2 px-4 text-sm font-semibold">
                You are impersonating {{ auth()->user()->name }}.
                <form method="POST" action="{{ route('impersonation.stop') }}" class="inline">
                    @csrf
                    <button type="submit" class="underline font-bold hover:text-yellow-800 ml-1">Stop Impersonating</button>
                </form>
            </div>
        @endif

        <x-sidebar sticky stashable class="border-r border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
            <x-sidebar.toggle class="lg:hidden w-10 p-0">
                <x-phosphor-x aria-hidden="true" width="20" height="20" />
            </x-sidebar.toggle>

            <a href="{{ route('admin.dashboard') }}" class="mr-5 flex items-center space-x-2">
                <x-app-logo />
                <span class="ml-1 text-xs font-bold uppercase tracking-wider text-red-500 dark:text-red-400">Admin</span>
            </a>

            <x-navlist>
                <x-navlist.item before="phosphor-chart-bar" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-navlist.item>

                <x-navlist.group :heading="__('Management')">
                    <x-navlist.item before="phosphor-users" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')">
                        {{ __('Users') }}
                    </x-navlist.item>
                </x-navlist.group>

                <x-navlist.group :heading="__('Support')">
                    <x-navlist.item before="phosphor-lifebuoy" :href="route('admin.tickets.index')" :current="request()->routeIs('admin.tickets.*')">
                        {{ __('Support Tickets') }}
                    </x-navlist.item>
                    <x-navlist.item before="phosphor-envelope-simple" :href="route('admin.contacts.index')" :current="request()->routeIs('admin.contacts.*')">
                        {{ __('Contact Messages') }}
                    </x-navlist.item>
                </x-navlist.group>
            </x-navlist>

            <x-spacer />

            <x-navlist>
                <x-navlist.item before="phosphor-arrow-left" :href="route('dashboard')">
                    {{ __('Back to App') }}
                </x-navlist.item>
            </x-navlist>

            <x-popover align="bottom" justify="left">
                <button type="button" class="w-full group flex items-center rounded-lg p-1.5 hover:bg-gray-800/5 dark:hover:bg-white/10 transition-colors">
                    <span class="shrink-0 size-8 rounded-full overflow-hidden bg-gradient-to-br from-red-500 to-orange-600 flex items-center justify-center">
                        <span class="text-xs font-semibold text-white">
                            {{ auth()->user()->initials() }}
                        </span>
                    </span>
                    <span class="ml-2 text-sm text-gray-600 dark:text-white/80 group-hover:text-gray-900 dark:group-hover:text-white font-medium truncate">
                        {{ auth()->user()->name }}
                    </span>
                </button>
                <x-slot:menu class="w-max">
                    <x-popover.item before="phosphor-arrow-left" href="{{ route('dashboard') }}">{{ __('Back to App') }}</x-popover.item>
                    <x-popover.separator />
                    <x-form method="post" action="{{ route('logout') }}" class="w-full flex">
                        <x-popover.item before="phosphor-sign-out">{{ __('Log Out') }}</x-popover.item>
                    </x-form>
                </x-slot:menu>
            </x-popover>
        </x-sidebar>

        <!-- Mobile Header -->
        <x-header class="lg:hidden">
            <x-container class="min-h-14 flex items-center">
                <x-sidebar.toggle class="lg:hidden w-10 p-0">
                    <x-phosphor-list aria-hidden="true" width="20" height="20" />
                </x-sidebar.toggle>
                <span class="ml-2 text-sm font-bold text-red-500">Admin Panel</span>
                <x-spacer />
            </x-container>
        </x-header>

        <x-container class="[grid-area:main] max-w-full py-6 lg:py-8">
            {{ $slot }}
        </x-container>

    </body>
</html>
