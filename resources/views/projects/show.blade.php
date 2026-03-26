<x-layouts.app :title="$project->name">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Projects') }}
            </a>
        </div>

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

        <div class="mx-auto w-full max-w-2xl space-y-6">
            {{-- Project Header --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 p-6 dark:border-gray-700">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ $project->name }}</h1>
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$project->status] }}">
                                    {{ str_replace('_', ' ', ucfirst($project->status)) }}
                                </span>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $priorityColors[$project->priority] }}">
                                    {{ ucfirst($project->priority) }} {{ __('priority') }}
                                </span>
                                @if($project->savedCard)
                                    <a href="{{ route('contacts.show', $project->savedCard) }}" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline dark:text-blue-400">
                                        <x-phosphor-user class="h-3 w-3" />
                                        {{ $project->savedCard->getFullName() }}
                                    </a>
                                @endif
                                @if($project->due_date)
                                    <span class="inline-flex items-center gap-1 text-xs {{ $project->isOverdue() ? 'text-red-500 font-medium' : 'text-gray-400 dark:text-gray-500' }}">
                                        <x-phosphor-calendar class="h-3 w-3" />
                                        {{ $project->due_date->format('M d, Y') }}
                                        @if($project->isOverdue())
                                            ({{ __('Overdue') }})
                                        @endif
                                    </span>
                                @endif
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Created') }} {{ $project->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('projects.edit', $project) }}" class="rounded-lg border border-gray-300 bg-white p-2 text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700" title="{{ __('Edit') }}">
                                <x-phosphor-pencil class="h-4 w-4" />
                            </a>
                            <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('{{ __('Delete this project and all its tasks?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-gray-300 bg-white p-2 text-red-600 transition hover:bg-red-50 dark:border-gray-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20" title="{{ __('Delete') }}">
                                    <x-phosphor-trash class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if($project->description)
                    <div class="border-b border-gray-200 p-6 dark:border-gray-700">
                        <div class="prose prose-sm max-w-none text-gray-700 dark:prose-invert dark:text-gray-300">
                            {!! nl2br(e($project->description)) !!}
                        </div>
                    </div>
                @endif

                {{-- Progress --}}
                <div class="p-6">
                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                        <span>{{ __('Progress') }}</span>
                        <span>{{ $completedCount }}/{{ $totalCount }} {{ __('tasks') }} ({{ $progress }}%)</span>
                    </div>
                    <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                        <div class="h-2 rounded-full {{ $progress === 100 ? 'bg-green-500' : 'bg-blue-500' }} transition-all" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Tasks Section --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 p-6 dark:border-gray-700">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('Tasks') }}</h2>
                </div>

                {{-- Add Task Form --}}
                <div class="border-b border-gray-200 p-4 dark:border-gray-700">
                    <form method="POST" action="{{ route('projects.tasks.store', $project) }}" class="flex gap-2">
                        @csrf
                        <input type="text" name="title" required placeholder="{{ __('Add a new task...') }}"
                            class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                        @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                            <x-phosphor-plus class="h-4 w-4" />
                            {{ __('Add') }}
                        </button>
                    </form>
                </div>

                {{-- Task List --}}
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($project->tasks as $task)
                        <div class="flex items-center gap-3 px-6 py-3">
                            <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="flex items-center justify-center" title="{{ $task->is_completed ? __('Mark incomplete') : __('Mark complete') }}">
                                    @if($task->is_completed)
                                        <x-phosphor-check-circle-fill class="h-5 w-5 text-green-500" />
                                    @else
                                        <x-phosphor-circle class="h-5 w-5 text-gray-300 hover:text-blue-400 dark:text-gray-600 dark:hover:text-blue-400" />
                                    @endif
                                </button>
                            </form>
                            <span class="flex-1 text-sm {{ $task->is_completed ? 'text-gray-400 line-through dark:text-gray-500' : 'text-gray-900 dark:text-white' }}">
                                {{ $task->title }}
                            </span>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('{{ __('Delete this task?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded p-1 text-gray-400 transition hover:text-red-500 dark:text-gray-500 dark:hover:text-red-400" title="{{ __('Delete task') }}">
                                    <x-phosphor-x class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No tasks yet. Add one above.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
