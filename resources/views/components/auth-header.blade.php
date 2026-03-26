@props([
    'title',
    'description',
])

<div class="text-center space-y-2">
    <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
</div>
