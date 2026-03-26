<x-layouts.app :title="__('Projects')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('Projects') }}</x-heading>
                <x-subheading>{{ __('Organize work with tasks, deadlines, and progress tracking.') }}</x-subheading>
            </div>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                <x-phosphor-plus class="h-4 w-4" />
                {{ __('New Project') }}
            </a>
        </div>

        {{-- Filters --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
            <form method="GET" action="{{ route('projects.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Search') }}</label>
                    <div class="relative">
                        <x-phosphor-magnifying-glass class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search projects...') }}"
                            class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-10 pr-4 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                    </div>
                </div>
                <div class="min-w-[140px]">
                    <label for="status" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</label>
                    <select id="status" name="status"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="">{{ __('All') }}</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="on_hold" {{ request('status') === 'on_hold' ? 'selected' : '' }}>{{ __('On Hold') }}</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                        <x-phosphor-funnel class="h-4 w-4" />
                        {{ __('Filter') }}
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-x class="h-4 w-4" />
                            {{ __('Clear') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Projects Grid --}}
        @if($projects->isNotEmpty())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($projects as $project)
                    @php
                        $statusColors = [
                            'active' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                            'completed' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                            'on_hold' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                        ];
                        $priorityColors = [
                            'low' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
                            'medium' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                            'high' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                        ];
                        $progress = $project->progressPercent();
                        $completedCount = $project->tasks->where('is_completed', true)->count();
                        $totalCount = $project->tasks->count();
                    @endphp
                    <a href="{{ route('projects.show', $project) }}"
                       class="group rounded-xl border border-gray-200 bg-white p-5 transition hover:border-blue-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-900 dark:hover:border-blue-600">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400 truncate">
                                {{ $project->name }}
                            </h3>
                            <span class="inline-flex shrink-0 items-center rounded-full px-2 py-0.5 text-[10px] font-medium {{ $statusColors[$project->status] }}">
                                {{ str_replace('_', ' ', ucfirst($project->status)) }}
                            </span>
                        </div>

                        <div class="mt-2 flex flex-wrap items-center gap-1.5">
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium {{ $priorityColors[$project->priority] }}">
                                {{ ucfirst($project->priority) }}
                            </span>
                            @if($project->savedCard)
                                <span class="inline-flex items-center gap-1 text-xs text-gray-400 dark:text-gray-500">
                                    <x-phosphor-user class="h-3 w-3" />
                                    {{ $project->savedCard->getFullName() }}
                                </span>
                            @endif
                        </div>

                        @if($project->due_date)
                            <div class="mt-2 flex items-center gap-1 text-xs {{ $project->isOverdue() ? 'text-red-500' : 'text-gray-400 dark:text-gray-500' }}">
                                <x-phosphor-calendar class="h-3 w-3" />
                                {{ $project->due_date->format('M d, Y') }}
                                @if($project->isOverdue())
                                    <span class="font-medium">({{ __('Overdue') }})</span>
                                @endif
                            </div>
                        @endif

                        {{-- Progress Bar --}}
                        <div class="mt-3">
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                <span>{{ $completedCount }}/{{ $totalCount }} {{ __('tasks') }}</span>
                                <span>{{ $progress }}%</span>
                            </div>
                            <div class="h-1.5 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                <div class="h-1.5 rounded-full {{ $progress === 100 ? 'bg-green-500' : 'bg-blue-500' }} transition-all" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-2">{{ $projects->withQueryString()->links() }}</div>
        @else
            <div class="rounded-xl border border-gray-200 bg-white px-6 py-16 text-center dark:border-gray-700 dark:bg-gray-900">
                <x-phosphor-kanban class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" />
                <h3 class="mt-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('No projects yet') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Create your first project to start tracking work.') }}</p>
                <a href="{{ route('projects.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                    <x-phosphor-plus class="h-4 w-4" />
                    {{ __('New Project') }}
                </a>
            </div>
        @endif
    </div>
</x-layouts.app>
