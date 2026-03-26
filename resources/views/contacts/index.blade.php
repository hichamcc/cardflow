<x-layouts.app :title="__('Contacts')">
    <div x-data="{
        selected: [],
        selectAll: false,
        allIds: @js($contacts->pluck('id')->toArray()),
        showBulkBar: false,
        bulkAction: '',
        toggleAll() {
            if (this.selectAll) {
                this.selected = [...this.allIds];
            } else {
                this.selected = [];
            }
        },
        toggleOne(id) {
            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(i => i !== id);
            } else {
                this.selected.push(id);
            }
            this.selectAll = this.selected.length === this.allIds.length;
        },
        submitBulk(action, extraData = {}) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = action;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            this.selected.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });

            Object.entries(extraData).forEach(([key, value]) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }
    }" x-effect="showBulkBar = selected.length > 0" class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <x-heading size="xl" level="1">{{ __('Contacts') }}</x-heading>
                <x-subheading>{{ $folder ? __('Folder: :name', ['name' => $folder->name]) : __('Manage your saved business contacts.') }}</x-subheading>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('contacts.export', request()->query()) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <x-phosphor-download class="h-4 w-4" />
                    {{ __('Export') }}
                </a>
                <a href="{{ route('contacts.import') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <x-phosphor-upload class="h-4 w-4" />
                    {{ __('Import') }}
                </a>
                <a href="{{ route('contacts.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                    <x-phosphor-plus class="h-4 w-4" />
                    {{ __('New Contact') }}
                </a>
            </div>
        </div>

        {{-- Search & Filters --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900">
            <form method="GET" action="{{ route('contacts.index') }}" class="flex flex-col gap-3 lg:flex-row lg:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Search') }}</label>
                    <div class="relative">
                        <x-phosphor-magnifying-glass class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search contacts...') }}"
                            class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-10 pr-4 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                    </div>
                </div>

                <div class="min-w-[140px]">
                    <label for="folder" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Folder') }}</label>
                    <select id="folder" name="folder"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="">{{ __('All Folders') }}</option>
                        @foreach($folders as $f)
                            <option value="{{ $f->id }}" {{ ($folder ?? null)?->id == $f->id || request()->query('folder') == $f->id ? 'selected' : '' }}>{{ $f->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-[140px]">
                    <label for="tag" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Tag') }}</label>
                    <select id="tag" name="tag"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="">{{ __('All Tags') }}</option>
                        @foreach($tags as $t)
                            <option value="{{ $t->id }}" {{ request('tag') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-[140px]">
                    <label for="status" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</label>
                    <select id="status" name="status"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="lead" {{ request('status') === 'lead' ? 'selected' : '' }}>{{ __('Lead') }}</option>
                        <option value="prospect" {{ request('status') === 'prospect' ? 'selected' : '' }}>{{ __('Prospect') }}</option>
                        <option value="client" {{ request('status') === 'client' ? 'selected' : '' }}>{{ __('Client') }}</option>
                        <option value="partner" {{ request('status') === 'partner' ? 'selected' : '' }}>{{ __('Partner') }}</option>
                        <option value="other" {{ request('status') === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                    </select>
                </div>

                <div class="min-w-[160px]">
                    <label for="sort" class="mb-1 block text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Sort By') }}</label>
                    <select id="sort" name="sort"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>{{ __('Name A-Z') }}</option>
                        <option value="last_contacted" {{ request('sort') === 'last_contacted' ? 'selected' : '' }}>{{ __('Last Contacted') }}</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                        <x-phosphor-funnel class="h-4 w-4" />
                        {{ __('Filter') }}
                    </button>
                    @if(request()->hasAny(['search', 'folder', 'tag', 'status', 'sort']))
                        <a href="{{ route('contacts.index') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-x class="h-4 w-4" />
                            {{ __('Clear') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Select All --}}
        @if($contacts->isNotEmpty())
            <div class="flex items-center gap-3">
                <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800">
                    {{ __('Select All') }}
                </label>
                <span x-show="selected.length > 0" x-cloak class="text-xs text-gray-500 dark:text-gray-400" x-text="selected.length + ' selected'"></span>
            </div>
        @endif

        {{-- Contacts Grid --}}
        @if($contacts->isNotEmpty())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($contacts as $contact)
                    <div class="group relative rounded-xl border border-gray-200 bg-white p-5 transition hover:border-blue-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-900 dark:hover:border-blue-600"
                         :class="{ 'ring-2 ring-blue-500 border-blue-300 dark:border-blue-600': selected.includes({{ $contact->id }}) }">
                        {{-- Checkbox --}}
                        <div class="absolute right-3 top-3 z-10" @click.stop>
                            <input type="checkbox"
                                   :checked="selected.includes({{ $contact->id }})"
                                   @change="toggleOne({{ $contact->id }})"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800">
                        </div>

                        <a href="{{ route('contacts.show', $contact) }}" class="block">
                            <div class="flex items-start gap-3 pr-6">
                                @if($contact->getProfilePhotoUrl())
                                    <img src="{{ $contact->getProfilePhotoUrl() }}" alt="{{ $contact->getFullName() }}"
                                        class="h-12 w-12 shrink-0 rounded-full object-cover">
                                @else
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gray-100 text-lg font-bold text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                        {{ strtoupper(substr($contact->getFullName(), 0, 1)) }}
                                    </div>
                                @endif

                                <div class="min-w-0 flex-1">
                                    <h3 class="truncate text-sm font-semibold text-gray-900 group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400">
                                        {{ $contact->getFullName() }}
                                    </h3>
                                    @if($contact->getJobTitle())
                                        <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $contact->getJobTitle() }}</p>
                                    @endif
                                    @if($contact->getCompanyName())
                                        <p class="truncate text-xs text-gray-400 dark:text-gray-500">{{ $contact->getCompanyName() }}</p>
                                    @endif
                                </div>

                                @if($contact->isManualClient())
                                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-1.5 py-0.5 text-[10px] font-medium text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">{{ __('Manual') }}</span>
                                @endif
                            </div>

                            <div class="mt-3 flex flex-wrap items-center gap-1.5">
                                @if($contact->relationship_status)
                                    @php
                                        $statusColors = [
                                            'lead' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'prospect' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                            'client' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'partner' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                            'other' => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $statusColors[$contact->relationship_status] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ ucfirst($contact->relationship_status) }}
                                    </span>
                                @endif

                                @foreach($contact->tags->take(2) as $tag)
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400"
                                          @if($tag->color) style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}" @endif>
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                                @if($contact->tags->count() > 2)
                                    <span class="text-xs text-gray-400">+{{ $contact->tags->count() - 2 }}</span>
                                @endif
                            </div>

                            <div class="mt-3 flex items-center justify-between border-t border-gray-100 pt-3 dark:border-gray-800">
                                @if($contact->folder)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-400 dark:text-gray-500">
                                        <x-phosphor-folder class="h-3 w-3" />
                                        {{ $contact->folder->name }}
                                    </span>
                                @else
                                    <span></span>
                                @endif
                                @if($contact->last_contacted_at)
                                    <span class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ __('Contacted') }} {{ $contact->last_contacted_at->diffForHumans() }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Never contacted') }}</span>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-2">
                {{ $contacts->withQueryString()->links() }}
            </div>
        @else
            <div class="rounded-xl border border-gray-200 bg-white px-6 py-16 text-center dark:border-gray-700 dark:bg-gray-900">
                <x-phosphor-address-book class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" />
                <h3 class="mt-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('No contacts found') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    @if(request()->hasAny(['search', 'folder', 'tag', 'status']))
                        {{ __('Try adjusting your filters or search terms.') }}
                    @else
                        {{ __('Add a contact manually or save business cards to start building your network.') }}
                    @endif
                </p>
                <div class="mt-4 flex items-center justify-center gap-3">
                    @if(request()->hasAny(['search', 'folder', 'tag', 'status']))
                        <a href="{{ route('contacts.index') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                            {{ __('Clear Filters') }}
                        </a>
                    @else
                        <a href="{{ route('contacts.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                            <x-phosphor-plus class="h-4 w-4" />
                            {{ __('New Contact') }}
                        </a>
                        <a href="{{ route('contacts.import') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-upload class="h-4 w-4" />
                            {{ __('Import CSV') }}
                        </a>
                    @endif
                </div>
            </div>
        @endif

        {{-- Floating Bulk Action Bar --}}
        <div x-show="showBulkBar" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-full opacity-0"
             class="fixed inset-x-0 bottom-0 z-50 border-t border-gray-200 bg-white px-4 py-3 shadow-lg dark:border-gray-700 dark:bg-gray-900">
            <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-3">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="selected.length + ' contact(s) selected'"></span>

                <div class="flex flex-wrap items-center gap-2">
                    {{-- Move to Folder --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-folder class="h-4 w-4" />
                            {{ __('Move') }}
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute bottom-full left-0 mb-2 w-48 rounded-lg border border-gray-200 bg-white py-1 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                            <button @click="submitBulk('{{ route('contacts.bulk.move') }}', { folder_id: '' }); open = false" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700">{{ __('No Folder') }}</button>
                            @foreach($folders as $f)
                                <button @click="submitBulk('{{ route('contacts.bulk.move') }}', { folder_id: '{{ $f->id }}' }); open = false" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700">{{ $f->name }}</button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Add Tag --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-tag class="h-4 w-4" />
                            {{ __('Tag') }}
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute bottom-full left-0 mb-2 max-h-48 w-48 overflow-y-auto rounded-lg border border-gray-200 bg-white py-1 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                            @foreach($tags as $t)
                                <button @click="submitBulk('{{ route('contacts.bulk.tag') }}', { tag_id: '{{ $t->id }}' }); open = false" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700">{{ $t->name }}</button>
                            @endforeach
                            @if($tags->isEmpty())
                                <p class="px-4 py-2 text-sm text-gray-400">{{ __('No tags created yet.') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Change Status --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <x-phosphor-flag class="h-4 w-4" />
                            {{ __('Status') }}
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute bottom-full left-0 mb-2 w-40 rounded-lg border border-gray-200 bg-white py-1 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                            @foreach(['lead', 'prospect', 'client', 'partner', 'other'] as $s)
                                <button @click="submitBulk('{{ route('contacts.bulk.status') }}', { relationship_status: '{{ $s }}' }); open = false" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700">{{ ucfirst($s) }}</button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Export Selected --}}
                    <button @click="submitBulk('{{ route('contacts.bulk.export') }}')" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        <x-phosphor-download class="h-4 w-4" />
                        {{ __('Export') }}
                    </button>

                    {{-- Delete --}}
                    <button @click="if (confirm('{{ __('Are you sure you want to delete the selected contacts? This cannot be undone.') }}')) submitBulk('{{ route('contacts.bulk.delete') }}')"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-red-300 bg-white px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50 dark:border-red-700 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">
                        <x-phosphor-trash class="h-4 w-4" />
                        {{ __('Delete') }}
                    </button>

                    {{-- Deselect --}}
                    <button @click="selected = []; selectAll = false" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-sm font-medium text-gray-500 transition hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <x-phosphor-x class="h-4 w-4" />
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
