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

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2">
                <x-app-logo />
            </a>

            <x-navlist>
                {{-- Main --}}
                <x-navlist.item before="phosphor-squares-four" :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-navlist.item>
                <x-navlist.item before="phosphor-chart-line-up" :href="route('analytics.index')" :current="request()->routeIs('analytics.*')">
                    {{ __('Analytics') }}
                </x-navlist.item>

                {{-- Cards --}}
                <x-navlist.group :heading="__('Cards')">
                    <x-navlist.item before="phosphor-identification-card" :href="route('cards.index')" :current="request()->routeIs('cards.*')">
                        {{ __('My Cards') }}
                    </x-navlist.item>
                </x-navlist.group>

                {{-- Contacts --}}
                <x-navlist.group :heading="__('Contacts')">
                    <x-navlist.item before="phosphor-address-book" :href="route('contacts.index', ['type' => 'saved'])" :current="request()->routeIs('contacts.*') && request('type') === 'saved'">
                        {{ __('Saved Cards') }}
                    </x-navlist.item>
                    <x-navlist.item before="phosphor-users" :href="route('contacts.index', ['type' => 'manual'])" :current="request()->routeIs('contacts.*') && request('type') === 'manual'">
                        {{ __('Contacts') }}
                    </x-navlist.item>
                    <x-navlist.item before="phosphor-folder-simple" :href="route('folders.index')" :current="request()->routeIs('folders.*')">
                        {{ __('Folders') }}
                    </x-navlist.item>
                    <x-navlist.item before="phosphor-tag-simple" :href="route('tags.index')" :current="request()->routeIs('tags.*')">
                        {{ __('Tags') }}
                    </x-navlist.item>
                </x-navlist.group>

                {{-- CRM --}}
                <x-navlist.group :heading="__('CRM')">
                    <x-navlist.item before="phosphor-notepad" :href="route('notes.index')" :current="request()->routeIs('notes.*')">
                        {{ __('Notes') }}
                    </x-navlist.item>
                    <x-navlist.item before="phosphor-calendar-dots" :href="route('calendar.index')" :current="request()->routeIs('calendar.*') || request()->routeIs('events.*')">
                        {{ __('Calendar') }}
                    </x-navlist.item>
                    <x-navlist.item before="phosphor-clock-countdown" :href="route('follow-ups.index')" :current="request()->routeIs('follow-ups.*')">
                        <span class="flex items-center gap-2">{{ __('Follow-ups') }}@if(auth()->user()->isFree())<span class="inline-flex items-center rounded-full bg-blue-100 px-1.5 py-0.5 text-[10px] font-bold text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">PRO</span>@endif</span>
                    </x-navlist.item>
                    <x-navlist.item before="phosphor-currency-circle-dollar" :href="route('deals.index')" :current="request()->routeIs('deals.*')">
                        <span class="flex items-center gap-2">{{ __('Deals') }}@if(auth()->user()->isFree())<span class="inline-flex items-center rounded-full bg-blue-100 px-1.5 py-0.5 text-[10px] font-bold text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">PRO</span>@endif</span>
                    </x-navlist.item>
                    <x-navlist.item before="phosphor-kanban" :href="route('projects.index')" :current="request()->routeIs('projects.*')">
                        <span class="flex items-center gap-2">{{ __('Projects') }}@if(auth()->user()->isFree())<span class="inline-flex items-center rounded-full bg-blue-100 px-1.5 py-0.5 text-[10px] font-bold text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">PRO</span>@endif</span>
                    </x-navlist.item>
                </x-navlist.group>

                {{-- Support --}}
                <x-navlist.group :heading="__('Support')">
                    <x-navlist.item before="phosphor-lifebuoy" :href="route('support.index')" :current="request()->routeIs('support.*')">
                        {{ __('Support Tickets') }}
                    </x-navlist.item>
                </x-navlist.group>
            </x-navlist>

            <x-spacer />

            <x-navlist>
                @if (auth()->user()->isAdmin())
                    <x-navlist.item before="phosphor-shield-check" :href="route('admin.dashboard')" :current="request()->routeIs('admin.*')">
                        {{ __('Admin Panel') }}
                    </x-navlist.item>
                @endif
                <x-navlist.item before="phosphor-gear-six" :href="route('settings.profile.edit')" :current="request()->routeIs('settings.*')">
                    {{ __('Settings') }}
                </x-navlist.item>
            </x-navlist>

            <x-popover align="bottom" justify="left">
                <button type="button" class="w-full group flex items-center rounded-lg p-1.5 hover:bg-gray-800/5 dark:hover:bg-white/10 transition-colors">
                    <span class="shrink-0 size-8 rounded-full overflow-hidden bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-xs font-semibold text-white">
                            {{ auth()->user()->initials() }}
                        </span>
                    </span>
                    <span class="ml-2 text-sm text-gray-600 dark:text-white/80 group-hover:text-gray-900 dark:group-hover:text-white font-medium truncate">
                        {{ auth()->user()->name }}
                    </span>
                    <span class="shrink-0 ml-auto size-8 flex justify-center items-center">
                        <x-phosphor-caret-up-down aria-hidden="true" width="14" height="14" class="text-gray-400 dark:text-white/50 group-hover:text-gray-600 dark:group-hover:text-white/80" />
                    </span>
                </button>
                <x-slot:menu class="w-max">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-full">
                            <span class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600 text-white text-xs font-semibold">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>
                        <div class="grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs text-gray-500">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                    <x-popover.separator />
                    <x-popover.item before="phosphor-gear-six" href="/settings/profile">{{ __('Settings') }}</x-popover.item>
                    <x-popover.separator />
                    <x-form method="post" action="{{ route('logout') }}" class="w-full flex">
                        <x-popover.item before="phosphor-sign-out">{{ __('Log Out') }}</x-popover.item>
                    </x-form>
                </x-slot:menu>
            </x-popover>
        </x-sidebar>

        <!-- Mobile User Menu -->
        <x-header class="lg:hidden">
            <x-container class="min-h-14 flex items-center">
                <x-sidebar.toggle class="lg:hidden w-10 p-0">
                    <x-phosphor-list aria-hidden="true" width="20" height="20" />
                </x-sidebar.toggle>

                <x-spacer />

                <x-popover align="top" justify="right">
                    <button type="button" class="w-full group flex items-center rounded-lg p-1 hover:bg-gray-800/5 dark:hover:bg-white/10">
                        <span class="shrink-0 size-8 rounded-full overflow-hidden bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-xs font-semibold text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>
                        <span class="shrink-0 ml-auto size-8 flex justify-center items-center">
                            <x-phosphor-caret-down width="16" height="16" class="text-gray-400 dark:text-white/80 group-hover:text-gray-800 dark:group-hover:text-white" />
                        </span>
                    </button>
                    <x-slot:menu>
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-full">
                                <span class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600 text-white text-xs font-semibold">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>
                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <x-popover.separator />
                        <x-popover.item before="phosphor-gear-six" href="/settings/profile">{{ __('Settings') }}</x-popover.item>
                        <x-popover.separator />
                        <x-form method="post" action="{{ route('logout') }}" class="w-full flex">
                            <x-popover.item before="phosphor-sign-out">{{ __('Log Out') }}</x-popover.item>
                        </x-form>
                    </x-slot:menu>
                </x-popover>
            </x-container>
        </x-header>

        {{ $slot }}

    </body>
</html>
