<x-layouts.app :title="__('New Contact')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('contacts.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Contacts') }}
            </a>
        </div>

        <div>
            <x-heading size="xl" level="1">{{ __('New Contact') }}</x-heading>
            <x-subheading>{{ __('Manually add a new contact to your CRM.') }}</x-subheading>
        </div>

        <x-form method="post" action="{{ route('contacts.store') }}" :upload="true">
            <div class="grid gap-6 lg:grid-cols-2">
                {{-- Left: Contact Details --}}
                <div class="space-y-6">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
                        <h2 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('Contact Details') }}</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="full_name" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Full Name') }} <span class="text-red-500">*</span></label>
                                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                                @error('full_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="email" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Phone') }}</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="company_name" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Company') }}</label>
                                <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="job_title" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Job Title') }}</label>
                                <input type="text" id="job_title" name="job_title" value="{{ old('job_title') }}"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="website" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Website') }}</label>
                                <input type="url" id="website" name="website" value="{{ old('website') }}" placeholder="https://"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="profile_photo" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Profile Photo') }}</label>
                                <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-400 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Organization --}}
                <div class="space-y-6">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
                        <h2 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('Organization') }}</h2>
                        <div class="space-y-4">
                            <div x-data="{ showForm: false, name: '', saving: false, error: '' }">
                                <div class="mb-1 flex items-center justify-between">
                                    <label for="folder_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Folder') }}</label>
                                    <button type="button" @click="showForm = !showForm; $nextTick(() => showForm && $refs.folderInput.focus())"
                                        class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        <x-phosphor-plus-circle class="h-3.5 w-3.5" />
                                        {{ __('New folder') }}
                                    </button>
                                </div>

                                {{-- Inline create form --}}
                                <div x-show="showForm" x-collapse x-cloak class="mb-2">
                                    <div class="flex gap-2">
                                        <input x-ref="folderInput" x-model="name" type="text" placeholder="{{ __('Folder name') }}"
                                            @keydown.enter.prevent="
                                                if (!name.trim()) return;
                                                saving = true; error = '';
                                                fetch('{{ route('folders.store') }}', {
                                                    method: 'POST',
                                                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                                    body: JSON.stringify({ name: name.trim() })
                                                }).then(r => r.ok ? r.json() : r.json().then(d => Promise.reject(d)))
                                                .then(folder => {
                                                    const select = document.getElementById('folder_id');
                                                    const opt = new Option(folder.name, folder.id, true, true);
                                                    select.add(opt);
                                                    name = ''; showForm = false; saving = false;
                                                }).catch(e => { error = e.errors?.name?.[0] || 'Failed to create'; saving = false; })
                                            "
                                            class="flex-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                                        <button type="button" :disabled="saving || !name.trim()"
                                            @click="
                                                if (!name.trim()) return;
                                                saving = true; error = '';
                                                fetch('{{ route('folders.store') }}', {
                                                    method: 'POST',
                                                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                                    body: JSON.stringify({ name: name.trim() })
                                                }).then(r => r.ok ? r.json() : r.json().then(d => Promise.reject(d)))
                                                .then(folder => {
                                                    const select = document.getElementById('folder_id');
                                                    const opt = new Option(folder.name, folder.id, true, true);
                                                    select.add(opt);
                                                    name = ''; showForm = false; saving = false;
                                                }).catch(e => { error = e.errors?.name?.[0] || 'Failed to create'; saving = false; })
                                            "
                                            class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-600">
                                            <span x-show="!saving">{{ __('Add') }}</span>
                                            <span x-show="saving" x-cloak>...</span>
                                        </button>
                                    </div>
                                    <p x-show="error" x-text="error" class="mt-1 text-xs text-red-600"></p>
                                </div>

                                <select id="folder_id" name="folder_id"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="">{{ __('No Folder') }}</option>
                                    @foreach($folders as $f)
                                        <option value="{{ $f->id }}" {{ old('folder_id') == $f->id ? 'selected' : '' }}>{{ $f->name }}</option>
                                    @endforeach
                                </select>
                                @if($folders->isEmpty())
                                    <p x-show="!showForm" class="mt-1.5 text-xs text-gray-400 dark:text-gray-500">{{ __('No folders yet. Create one to organize contacts.') }}</p>
                                @endif
                            </div>
                            <div>
                                <label for="relationship_status" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
                                <select id="relationship_status" name="relationship_status"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="lead" {{ old('relationship_status') === 'lead' ? 'selected' : '' }}>{{ __('Lead') }}</option>
                                    <option value="prospect" {{ old('relationship_status') === 'prospect' ? 'selected' : '' }}>{{ __('Prospect') }}</option>
                                    <option value="client" {{ old('relationship_status') === 'client' ? 'selected' : '' }}>{{ __('Client') }}</option>
                                    <option value="partner" {{ old('relationship_status') === 'partner' ? 'selected' : '' }}>{{ __('Partner') }}</option>
                                    <option value="other" {{ old('relationship_status') === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="contact_frequency" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Contact Frequency') }}</label>
                                <select id="contact_frequency" name="contact_frequency"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="never">{{ __('Never') }}</option>
                                    <option value="low">{{ __('Low (Monthly)') }}</option>
                                    <option value="medium">{{ __('Medium (Bi-weekly)') }}</option>
                                    <option value="high">{{ __('High (Weekly)') }}</option>
                                </select>
                            </div>
                            <div x-data="{ showForm: false, name: '', color: '#3b82f6', saving: false, error: '' }">
                                <div class="mb-2 flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Tags') }}</p>
                                    <button type="button" @click="showForm = !showForm; $nextTick(() => showForm && $refs.tagInput.focus())"
                                        class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        <x-phosphor-plus-circle class="h-3.5 w-3.5" />
                                        {{ __('New tag') }}
                                    </button>
                                </div>

                                {{-- Inline create form --}}
                                <div x-show="showForm" x-collapse x-cloak class="mb-2">
                                    <div class="flex gap-2">
                                        <input x-ref="tagInput" x-model="name" type="text" placeholder="{{ __('Tag name') }}"
                                            @keydown.enter.prevent="$refs.tagAddBtn.click()"
                                            class="flex-1 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                                        <input x-model="color" type="color"
                                            class="h-[38px] w-[38px] shrink-0 cursor-pointer rounded-lg border border-gray-300 bg-white p-0.5 dark:border-gray-600 dark:bg-gray-800">
                                        <button x-ref="tagAddBtn" type="button" :disabled="saving || !name.trim()"
                                            @click="
                                                if (!name.trim()) return;
                                                saving = true; error = '';
                                                fetch('{{ route('tags.store') }}', {
                                                    method: 'POST',
                                                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                                    body: JSON.stringify({ name: name.trim(), color: color })
                                                }).then(r => r.ok ? r.json() : r.json().then(d => Promise.reject(d)))
                                                .then(tag => {
                                                    const list = document.getElementById('tags-list');
                                                    const label = document.createElement('label');
                                                    label.className = 'flex items-center gap-2';
                                                    const colorStyle = tag.color ? ' style=&quot;color:' + tag.color + '&quot;' : '';
                                                    label.innerHTML = `<input type='checkbox' name='tags[]' value='${tag.id}' checked class='rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800'><span class='text-sm text-gray-700 dark:text-gray-300' ${tag.color ? 'style=color:' + tag.color : ''}>${tag.name}</span>`;
                                                    list.appendChild(label);
                                                    name = ''; color = '#3b82f6'; showForm = false; saving = false;
                                                    if (list.querySelector('.empty-msg')) list.querySelector('.empty-msg').remove();
                                                }).catch(e => { error = e.errors?.name?.[0] || 'Failed to create'; saving = false; })
                                            "
                                            class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-600">
                                            <span x-show="!saving">{{ __('Add') }}</span>
                                            <span x-show="saving" x-cloak>...</span>
                                        </button>
                                    </div>
                                    <p x-show="error" x-text="error" class="mt-1 text-xs text-red-600"></p>
                                </div>

                                <div id="tags-list" class="max-h-40 space-y-2 overflow-y-auto">
                                    @forelse($tags as $tag)
                                        <label class="flex items-center gap-2">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800">
                                            <span class="text-sm text-gray-700 dark:text-gray-300" @if($tag->color) style="color: {{ $tag->color }}" @endif>{{ $tag->name }}</span>
                                        </label>
                                    @empty
                                        <p x-show="!showForm" class="empty-msg text-xs text-gray-400 dark:text-gray-500">{{ __('No tags yet. Create one to label contacts.') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
                        <h2 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('Notes') }}</h2>
                        <textarea name="custom_note" rows="4" placeholder="{{ __('Add any notes about this contact...') }}"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">{{ old('custom_note') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('contacts.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    {{ __('Create Contact') }}
                </button>
            </div>
        </x-form>
    </div>
</x-layouts.app>
