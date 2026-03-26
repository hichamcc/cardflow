<x-layouts.app :title="__('Edit Contact')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('contacts.show', $contact) }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Contact') }}
            </a>
        </div>

        <div>
            <x-heading size="xl" level="1">{{ __('Edit Contact') }}</x-heading>
            <x-subheading>{{ __('Update contact details for :name.', ['name' => $contact->full_name]) }}</x-subheading>
        </div>

        <x-form method="put" action="{{ route('contacts.update', $contact) }}" :upload="true">
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-6">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
                        <h2 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('Contact Details') }}</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="full_name" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Full Name') }} <span class="text-red-500">*</span></label>
                                <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $contact->full_name) }}" required
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                                @error('full_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="email" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $contact->email) }}"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="phone" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Phone') }}</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $contact->phone) }}"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="company_name" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Company') }}</label>
                                <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $contact->company_name) }}"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="job_title" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Job Title') }}</label>
                                <input type="text" id="job_title" name="job_title" value="{{ old('job_title', $contact->job_title) }}"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="website" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Website') }}</label>
                                <input type="url" id="website" name="website" value="{{ old('website', $contact->website) }}" placeholder="https://"
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label for="profile_photo" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Profile Photo') }}</label>
                                @if($contact->profile_photo_path)
                                    <img src="{{ asset('storage/' . $contact->profile_photo_path) }}" alt="{{ $contact->full_name }}" class="mb-2 h-16 w-16 rounded-full object-cover">
                                @endif
                                <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-400 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
                        <h2 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('Organization') }}</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="folder_id" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Folder') }}</label>
                                <select id="folder_id" name="folder_id"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="">{{ __('No Folder') }}</option>
                                    @foreach($folders as $f)
                                        <option value="{{ $f->id }}" {{ old('folder_id', $contact->folder_id) == $f->id ? 'selected' : '' }}>{{ $f->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="relationship_status" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
                                <select id="relationship_status" name="relationship_status"
                                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-8 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                                    <option value="lead" {{ old('relationship_status', $contact->relationship_status) === 'lead' ? 'selected' : '' }}>{{ __('Lead') }}</option>
                                    <option value="prospect" {{ old('relationship_status', $contact->relationship_status) === 'prospect' ? 'selected' : '' }}>{{ __('Prospect') }}</option>
                                    <option value="client" {{ old('relationship_status', $contact->relationship_status) === 'client' ? 'selected' : '' }}>{{ __('Client') }}</option>
                                    <option value="partner" {{ old('relationship_status', $contact->relationship_status) === 'partner' ? 'selected' : '' }}>{{ __('Partner') }}</option>
                                    <option value="other" {{ old('relationship_status', $contact->relationship_status) === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                            </div>
                            <div>
                                <p class="mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Tags') }}</p>
                                <div class="max-h-40 space-y-2 overflow-y-auto">
                                    @foreach($tags as $tag)
                                        <label class="flex items-center gap-2">
                                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                                {{ $contact->tags->contains($tag->id) ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800">
                                            <span class="text-sm text-gray-700 dark:text-gray-300" @if($tag->color) style="color: {{ $tag->color }}" @endif>{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
                        <h2 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">{{ __('Notes') }}</h2>
                        <textarea name="custom_note" rows="4" placeholder="{{ __('Add any notes about this contact...') }}"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500">{{ old('custom_note', $contact->custom_note) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('contacts.show', $contact) }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    {{ __('Update Contact') }}
                </button>
            </div>
        </x-form>
    </div>
</x-layouts.app>
