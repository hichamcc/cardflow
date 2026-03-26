{{-- Card form partial shared between create and edit --}}
@php
    $socialLinksData = old('social_links', isset($card) ? $card->socialLinks->map(fn($l) => ['platform' => $l->platform, 'url' => $l->url])->toArray() : []);
    $customFieldsData = old('custom_fields', isset($card) ? $card->customFields->map(fn($f) => ['field_name' => $f->field_name, 'field_value' => $f->field_value, 'icon' => $f->icon])->toArray() : []);
    $existingProfilePhoto = isset($card) && $card->profile_photo_path ? $card->getProfilePhotoUrl() : '';
@endphp

<div x-data="cardForm()" class="grid grid-cols-1 xl:grid-cols-5 gap-8">
    {{-- Left: Form Fields --}}
    <div class="xl:col-span-3 space-y-6">
        {{-- Basic Info --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">{{ __('Basic Information') }}</h3>
            <div class="grid gap-4 md:grid-cols-2">
                <x-input type="text" name="card_name" :label="__('Card Name')" :value="old('card_name', $card->card_name ?? '')" placeholder="e.g. Work, Freelance" required />
                <div>
                    <x-input type="text" name="full_name" :label="__('Full Name')" :value="old('full_name', $card->full_name ?? '')" required x-model="preview.full_name" />
                </div>
                <div>
                    <x-input type="text" name="job_title" :label="__('Job Title')" :value="old('job_title', $card->job_title ?? '')" x-model="preview.job_title" />
                </div>
                <div>
                    <x-input type="text" name="company_name" :label="__('Company')" :value="old('company_name', $card->company_name ?? '')" x-model="preview.company_name" />
                </div>
                <div>
                    <x-input type="email" name="email" :label="__('Email')" :value="old('email', $card->email ?? '')" x-model="preview.email" />
                </div>
                <div>
                    <x-input type="tel" name="phone" :label="__('Phone')" :value="old('phone', $card->phone ?? '')" x-model="preview.phone" />
                </div>
                <div class="md:col-span-2">
                    <x-input type="url" name="website" :label="__('Website')" :value="old('website', $card->website ?? '')" x-model="preview.website" />
                </div>
                <div class="md:col-span-2">
                    <x-field>
                        <x-label for="bio" :value="__('Bio')" />
                        <textarea name="bio" id="bio" rows="3" x-model="preview.bio" class="shadow-sm block w-full sm:text-sm border-gray-300 rounded-lg bg-white dark:bg-white/10 dark:border-white/10 dark:text-gray-300 px-3 py-2 border border-gray-200 border-b-gray-300/80">{{ old('bio', $card->bio ?? '') }}</textarea>
                        <x-error for="bio" />
                    </x-field>
                </div>
            </div>
        </div>

        {{-- Photos --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">{{ __('Photos') }}</h3>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-label for="profile_photo" :value="__('Profile Photo')" />
                    @if(isset($card) && $card->profile_photo_path)
                        <div class="mt-2 mb-2">
                            <img src="{{ $card->getProfilePhotoUrl() }}" alt="Profile" class="h-16 w-16 rounded-lg object-cover">
                        </div>
                    @endif
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                        @change="previewProfilePhoto($event)"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                    <x-error for="profile_photo" />
                </div>
                <div>
                    <x-label for="company_logo" :value="__('Company Logo')" />
                    @if(isset($card) && $card->company_logo_path)
                        <div class="mt-2 mb-2">
                            <img src="{{ $card->getCompanyLogoUrl() }}" alt="Logo" class="h-16 w-16 rounded-lg object-cover">
                        </div>
                    @endif
                    <input type="file" name="company_logo" id="company_logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
                    <x-error for="company_logo" />
                </div>
            </div>
        </div>

        {{-- Theme --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">{{ __('Appearance') }}</h3>
            <div>
                <x-label for="theme_color" :value="__('Theme Color')" />
                <div class="flex items-center gap-3 mt-1">
                    <input type="color" name="theme_color" id="theme_color" x-model="preview.theme_color" value="{{ old('theme_color', $card->theme_color ?? '#3B82F6') }}" class="h-10 w-14 rounded cursor-pointer border border-gray-200 dark:border-gray-700">
                    <div class="flex gap-2">
                        @foreach(['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444', '#EC4899', '#14B8A6', '#1F2937'] as $color)
                            <button type="button" @click="preview.theme_color = '{{ $color }}'; document.getElementById('theme_color').value = '{{ $color }}'" class="h-8 w-8 rounded-full border-2 border-white shadow-sm dark:border-gray-600 transition-transform hover:scale-110" style="background-color: {{ $color }}"></button>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- Layout Style Selector --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">{{ __('Card Layout') }}</label>
                <div class="grid grid-cols-3 gap-3">
                    @foreach(['classic' => 'Classic', 'modern' => 'Modern', 'minimal' => 'Minimal'] as $value => $label)
                        <label class="relative cursor-pointer" @click="preview.layout_style = '{{ $value }}'">
                            <input type="radio" name="layout_style" value="{{ $value }}" {{ old('layout_style', $card->layout_style ?? 'classic') === $value ? 'checked' : '' }} class="peer sr-only">
                            <div class="flex flex-col items-center gap-2 rounded-xl border-2 border-gray-200 p-3 transition-all peer-checked:border-sky-500 peer-checked:bg-sky-50 dark:border-gray-700 dark:peer-checked:border-sky-500 dark:peer-checked:bg-sky-950/30">
                                @if($value === 'classic')
                                    <div class="h-12 w-10 rounded-md overflow-hidden border border-gray-200 dark:border-gray-600">
                                        <div class="h-7 bg-gradient-to-b from-gray-800 to-gray-900"></div>
                                        <div class="h-5 bg-white dark:bg-gray-200"></div>
                                    </div>
                                @elseif($value === 'modern')
                                    <div class="h-12 w-10 rounded-md overflow-hidden border border-gray-200 dark:border-gray-600">
                                        <div class="h-7 bg-gradient-to-b from-indigo-900 to-gray-900 flex items-center justify-center">
                                            <div class="w-3 h-3 rounded-full bg-white/30 mt-1"></div>
                                        </div>
                                        <div class="h-5 bg-white dark:bg-gray-200"></div>
                                    </div>
                                @else
                                    <div class="h-12 w-10 rounded-md overflow-hidden border border-gray-200 dark:border-gray-600">
                                        <div class="h-0.5 bg-sky-500"></div>
                                        <div class="h-[46px] bg-gray-900 flex items-center justify-center">
                                            <div class="w-3 h-3 rounded-full bg-white/20"></div>
                                        </div>
                                    </div>
                                @endif
                                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            @if(auth()->user()->isPro() || auth()->user()->isBusiness())
                <div class="mt-4 flex items-center gap-3">
                    <label for="hide_branding" class="relative inline-flex cursor-pointer items-center">
                        <input type="hidden" name="hide_branding" value="0">
                        <input type="checkbox" name="hide_branding" id="hide_branding" value="1" {{ old('hide_branding', $card->hide_branding ?? false) ? 'checked' : '' }} class="sr-only peer">
                        <div class="h-6 w-11 rounded-full bg-gray-200 peer-checked:bg-blue-600 peer-focus:ring-4 peer-focus:ring-blue-300 dark:bg-gray-700 dark:peer-focus:ring-blue-800 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white"></div>
                    </label>
                    <div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Hide "Powered by BsnCard" badge') }}</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Remove branding from your public card') }}</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Social Links --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('Social Links') }}</h3>
                <button type="button" @click="addSocialLink()" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">
                    {{ __('+ Add Link') }}
                </button>
            </div>
            <template x-for="(link, index) in socialLinks" :key="index">
                <div class="flex gap-3 mb-3 items-start">
                    <select :name="'social_links[' + index + '][platform]'" x-model="link.platform" class="w-36 rounded-lg border border-gray-200 border-b-gray-300/80 bg-white py-2 pl-3 pr-10 text-sm dark:bg-white/10 dark:border-white/10 dark:text-gray-300">
                        <option value="linkedin">LinkedIn</option>
                        <option value="twitter">Twitter/X</option>
                        <option value="instagram">Instagram</option>
                        <option value="facebook">Facebook</option>
                        <option value="github">GitHub</option>
                        <option value="youtube">YouTube</option>
                        <option value="tiktok">TikTok</option>
                        <option value="dribbble">Dribbble</option>
                        <option value="behance">Behance</option>
                        <option value="other">Other</option>
                    </select>
                    <input type="url" :name="'social_links[' + index + '][url]'" x-model="link.url" placeholder="https://..." class="flex-1 rounded-lg border border-gray-200 border-b-gray-300/80 bg-white py-2 px-3 text-sm dark:bg-white/10 dark:border-white/10 dark:text-gray-300">
                    <button type="button" @click="removeSocialLink(index)" class="p-2 text-gray-400 hover:text-red-500">
                        <x-phosphor-trash class="h-5 w-5" />
                    </button>
                </div>
            </template>
            <p x-show="socialLinks.length === 0" class="text-sm text-gray-500 dark:text-gray-400">{{ __('No social links added yet.') }}</p>
        </div>

        {{-- Custom Fields --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-900">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">{{ __('Custom Fields') }}</h3>
                <button type="button" @click="addCustomField()" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">
                    {{ __('+ Add Field') }}
                </button>
            </div>
            <template x-for="(field, index) in customFields" :key="index">
                <div class="flex gap-3 mb-3 items-start">
                    <input type="text" :name="'custom_fields[' + index + '][field_name]'" x-model="field.field_name" placeholder="Field name" class="w-36 rounded-lg border border-gray-200 border-b-gray-300/80 bg-white py-2 px-3 text-sm dark:bg-white/10 dark:border-white/10 dark:text-gray-300">
                    <input type="text" :name="'custom_fields[' + index + '][field_value]'" x-model="field.field_value" placeholder="Value" class="flex-1 rounded-lg border border-gray-200 border-b-gray-300/80 bg-white py-2 px-3 text-sm dark:bg-white/10 dark:border-white/10 dark:text-gray-300">
                    <input type="hidden" :name="'custom_fields[' + index + '][icon]'" x-model="field.icon">
                    <button type="button" @click="removeCustomField(index)" class="p-2 text-gray-400 hover:text-red-500">
                        <x-phosphor-trash class="h-5 w-5" />
                    </button>
                </div>
            </template>
            <p x-show="customFields.length === 0" class="text-sm text-gray-500 dark:text-gray-400">{{ __('No custom fields added yet.') }}</p>
        </div>
    </div>

    {{-- Right: Live Mobile Preview --}}
    <div class="xl:col-span-2">
        <div class="sticky top-24">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4 text-center">{{ __('Live Preview') }}</h3>

            {{-- Phone Frame --}}
            <div class="mx-auto w-[300px]">
                <div class="rounded-[2.5rem] border-[6px] border-gray-800 dark:border-gray-600 bg-gray-800 dark:bg-gray-600 p-1 shadow-2xl">
                    {{-- Notch --}}
                    <div class="relative">
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 z-20 w-28 h-6 bg-gray-800 dark:bg-gray-600 rounded-b-2xl"></div>
                    </div>

                    {{-- Screen --}}
                    <div class="rounded-[2rem] overflow-hidden" style="height: 560px; background: #0f172a;">
                        <div class="h-full overflow-y-auto" id="preview-scroll" style="scrollbar-width: none; -ms-overflow-style: none;">
                            <style>#preview-scroll::-webkit-scrollbar { display: none; }</style>

                            {{-- ==================== CLASSIC ==================== --}}
                            <template x-if="preview.layout_style === 'classic'">
                                <div class="min-h-full">
                                    {{-- Dark Card Section --}}
                                    <div class="relative overflow-hidden px-4 pb-5 pt-6" style="background: linear-gradient(160deg, #1a1a2e 0%, #16213e 50%, #0f172a 100%);">
                                        {{-- Decorative accent orbs --}}
                                        <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full opacity-15" :style="'background: radial-gradient(circle, ' + preview.theme_color + ', transparent 70%)'"></div>
                                        <div class="absolute -bottom-6 -left-6 h-24 w-24 rounded-full opacity-10" :style="'background: radial-gradient(circle, ' + preview.theme_color + ', transparent 70%)'"></div>

                                        {{-- Top bar --}}
                                        <div class="relative flex items-center justify-between mb-5">
                                            <div class="flex items-center gap-1 opacity-50">
                                                <div class="w-3.5 h-3.5 rounded bg-white/20 flex items-center justify-center">
                                                    <svg class="w-2 h-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                                </div>
                                                <span class="text-[7px] font-semibold text-white/60">BsnCard</span>
                                            </div>
                                            <span class="text-[7px] font-medium text-white/30 uppercase tracking-widest">Business Card</span>
                                        </div>

                                        {{-- Profile --}}
                                        <div class="relative flex items-start gap-3">
                                            <div class="flex-1 min-w-0">
                                                <h2 class="text-[18px] font-extrabold text-white leading-[1.1] tracking-tight mb-1" x-text="preview.full_name || 'Your Name'"></h2>
                                                <p class="text-[10px] font-medium text-white/60" x-show="preview.job_title" x-text="preview.job_title"></p>
                                                <p class="text-[8px] font-semibold uppercase tracking-wider mt-0.5" :style="'color:' + preview.theme_color + 'aa'" x-show="preview.company_name" x-text="preview.company_name"></p>
                                            </div>
                                            <div class="shrink-0">
                                                <template x-if="preview.profile_photo">
                                                    <img :src="preview.profile_photo" class="h-14 w-14 rounded-xl object-cover border border-white/10" :style="'box-shadow: 0 0 0 2px ' + preview.theme_color + '30'">
                                                </template>
                                                <template x-if="!preview.profile_photo">
                                                    <div class="flex h-14 w-14 items-center justify-center rounded-xl border border-white/10 text-lg font-extrabold text-white" :style="'background: linear-gradient(135deg, ' + preview.theme_color + ', ' + preview.theme_color + '88); box-shadow: 0 0 0 2px ' + preview.theme_color + '30'"
                                                        x-text="preview.full_name ? (preview.full_name.split(' ').map(w => w[0]).join('').substring(0,2).toUpperCase()) : 'AB'"></div>
                                                </template>
                                            </div>
                                        </div>

                                        {{-- Bio --}}
                                        <template x-if="preview.bio">
                                            <div class="mt-4">
                                                <p class="text-[7px] font-semibold uppercase tracking-widest text-white/30 mb-1">About</p>
                                                <p class="text-[9px] leading-relaxed text-white/50" x-text="preview.bio"></p>
                                            </div>
                                        </template>

                                        {{-- Contact Info --}}
                                        <div class="mt-4 space-y-2.5">
                                            <template x-if="preview.email">
                                                <div>
                                                    <p class="text-[7px] font-semibold uppercase tracking-widest text-white/30 mb-0.5">Email</p>
                                                    <div class="flex items-center gap-2">
                                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-white/5">
                                                            <svg class="h-3 w-3 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                                        </div>
                                                        <span class="text-[10px] font-medium text-white/80 truncate" x-text="preview.email"></span>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="preview.phone">
                                                <div>
                                                    <p class="text-[7px] font-semibold uppercase tracking-widest text-white/30 mb-0.5">Mobile</p>
                                                    <div class="flex items-center gap-2">
                                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-white/5">
                                                            <svg class="h-3 w-3 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                                        </div>
                                                        <span class="text-[10px] font-medium text-white/80" x-text="preview.phone"></span>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="preview.website">
                                                <div>
                                                    <p class="text-[7px] font-semibold uppercase tracking-widest text-white/30 mb-0.5">Website</p>
                                                    <div class="flex items-center gap-2">
                                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-white/5">
                                                            <svg class="h-3 w-3 text-white/50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                                                        </div>
                                                        <span class="text-[10px] font-medium text-white/80 truncate" x-text="preview.website"></span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        {{-- Custom Fields --}}
                                        <template x-if="customFields.length > 0 && customFields.some(f => f.field_name && f.field_value)">
                                            <div class="mt-3 space-y-2.5">
                                                <template x-for="(field, i) in customFields" :key="'cls-field-' + i">
                                                    <div x-show="field.field_name && field.field_value">
                                                        <p class="text-[7px] font-semibold uppercase tracking-widest text-white/30 mb-0.5" x-text="field.field_name"></p>
                                                        <p class="text-[10px] font-medium text-white/80" x-text="field.field_value"></p>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        {{-- QR placeholder --}}
                                        <div class="mt-5 flex justify-center">
                                            <div class="rounded-xl bg-white p-2.5" :style="'box-shadow: 0 6px 24px ' + preview.theme_color + '25'">
                                                <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/></svg>
                                                </div>
                                                <p class="mt-1 text-center text-[7px] font-medium text-gray-400">Scan to share</p>
                                            </div>
                                        </div>

                                        {{-- Social & Actions --}}
                                        <div class="mt-4">
                                            @include('cards._preview_shared')
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- ==================== MODERN ==================== --}}
                            <template x-if="preview.layout_style === 'modern'">
                                <div class="min-h-full" style="background: linear-gradient(160deg, #0c0c18 0%, #131328 50%, #0e1525 100%);">
                                    {{-- Dark section --}}
                                    <div class="relative overflow-hidden px-4 pb-5 pt-6">
                                        {{-- Decorative orbs --}}
                                        <div class="absolute top-0 right-0 h-40 w-40 rounded-full opacity-15" :style="'background: radial-gradient(circle, ' + preview.theme_color + ', transparent 70%)'"></div>
                                        <div class="absolute bottom-0 left-0 h-28 w-28 rounded-full opacity-10" :style="'background: radial-gradient(circle, ' + preview.theme_color + ', transparent 70%)'"></div>

                                        {{-- Top bar --}}
                                        <div class="relative flex items-center gap-2 mb-6">
                                            <div class="h-0.5 w-5 rounded-full" :style="'background-color:' + preview.theme_color"></div>
                                            <span class="text-[7px] font-bold uppercase tracking-[0.15em] text-white/30">Digital Card</span>
                                        </div>

                                        {{-- Profile: large photo centered --}}
                                        <div class="relative text-center mb-4">
                                            <template x-if="preview.profile_photo">
                                                <img :src="preview.profile_photo" class="mx-auto h-20 w-20 rounded-2xl object-cover border-2 border-white/10" :style="'box-shadow: 0 0 0 3px ' + preview.theme_color + '30'">
                                            </template>
                                            <template x-if="!preview.profile_photo">
                                                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl border-2 border-white/10 text-2xl font-extrabold text-white" :style="'background: linear-gradient(135deg, ' + preview.theme_color + ', ' + preview.theme_color + '88); box-shadow: 0 0 0 3px ' + preview.theme_color + '30'"
                                                    x-text="preview.full_name ? (preview.full_name.split(' ').map(w => w[0]).join('').substring(0,2).toUpperCase()) : 'AB'"></div>
                                            </template>
                                            <h2 class="text-[17px] font-extrabold text-white leading-tight tracking-tight mt-3" x-text="preview.full_name || 'Your Name'"></h2>
                                            <p class="text-[10px] font-medium text-white/50 mt-0.5" x-show="preview.job_title" x-text="preview.job_title"></p>
                                            <p class="text-[8px] font-semibold uppercase tracking-wider mt-0.5" :style="'color:' + preview.theme_color + 'aa'" x-show="preview.company_name" x-text="preview.company_name"></p>
                                        </div>

                                        {{-- Bio --}}
                                        <template x-if="preview.bio">
                                            <p class="text-[9px] text-white/40 leading-relaxed text-center mb-4 px-2" x-text="preview.bio"></p>
                                        </template>

                                        {{-- Contact tiles as floating cards --}}
                                        <div class="space-y-1.5">
                                            <template x-if="preview.email">
                                                <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/[0.06] backdrop-blur-sm border border-white/[0.06]">
                                                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg" :style="'background-color:' + preview.theme_color + '20'">
                                                        <svg class="h-3 w-3" :style="'color:' + preview.theme_color" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-[7px] font-semibold text-white/30 uppercase tracking-wider">Email</p>
                                                        <p class="text-[10px] font-medium text-white/80 truncate" x-text="preview.email"></p>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="preview.phone">
                                                <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/[0.06] backdrop-blur-sm border border-white/[0.06]">
                                                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg" :style="'background-color:' + preview.theme_color + '20'">
                                                        <svg class="h-3 w-3" :style="'color:' + preview.theme_color" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-[7px] font-semibold text-white/30 uppercase tracking-wider">Mobile</p>
                                                        <p class="text-[10px] font-medium text-white/80 truncate" x-text="preview.phone"></p>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="preview.website">
                                                <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/[0.06] backdrop-blur-sm border border-white/[0.06]">
                                                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg" :style="'background-color:' + preview.theme_color + '20'">
                                                        <svg class="h-3 w-3" :style="'color:' + preview.theme_color" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/></svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-[7px] font-semibold text-white/30 uppercase tracking-wider">Website</p>
                                                        <p class="text-[10px] font-medium text-white/80 truncate" x-text="preview.website"></p>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        {{-- Custom fields --}}
                                        <template x-if="customFields.length > 0 && customFields.some(f => f.field_name && f.field_value)">
                                            <div class="mt-2 space-y-1.5">
                                                <template x-for="(field, i) in customFields" :key="'mod-field-' + i">
                                                    <div x-show="field.field_name && field.field_value" class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/[0.06] border border-white/[0.06]">
                                                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg" :style="'background-color:' + preview.theme_color + '20'">
                                                            <svg class="h-3 w-3" :style="'color:' + preview.theme_color" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p class="text-[7px] font-semibold text-white/30 uppercase tracking-wider" x-text="field.field_name"></p>
                                                            <p class="text-[10px] font-medium text-white/80 truncate" x-text="field.field_value"></p>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        {{-- Social & Actions --}}
                                        <div class="mt-4">
                                            @include('cards._preview_shared')
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- ==================== MINIMAL ==================== --}}
                            <template x-if="preview.layout_style === 'minimal'">
                                <div class="min-h-full" style="background: #111119;">
                                    {{-- Thin accent stripe at top --}}
                                    <div class="h-0.5" :style="'background: linear-gradient(90deg, transparent, ' + preview.theme_color + ', transparent)'"></div>

                                    <div class="px-5 pt-7 pb-5">
                                        {{-- Profile: horizontal layout --}}
                                        <div class="flex items-center gap-3.5 mb-5">
                                            <template x-if="preview.profile_photo">
                                                <img :src="preview.profile_photo" class="h-12 w-12 rounded-full object-cover border border-white/10 shrink-0">
                                            </template>
                                            <template x-if="!preview.profile_photo">
                                                <div class="flex h-12 w-12 items-center justify-center rounded-full text-sm font-bold text-white shrink-0 border border-white/10" :style="'background-color:' + preview.theme_color"
                                                    x-text="preview.full_name ? preview.full_name.charAt(0).toUpperCase() : 'A'"></div>
                                            </template>
                                            <div class="min-w-0">
                                                <h2 class="text-[14px] font-bold text-white leading-tight" x-text="preview.full_name || 'Your Name'"></h2>
                                                <p class="text-[9px] text-white/40 mt-0.5 truncate" x-show="preview.job_title">
                                                    <span x-text="preview.job_title"></span>
                                                    <template x-if="preview.company_name">
                                                        <span>
                                                            <span class="text-white/20 mx-1">&middot;</span>
                                                            <span :style="'color:' + preview.theme_color + '99'" x-text="preview.company_name"></span>
                                                        </span>
                                                    </template>
                                                </p>
                                                <template x-if="!preview.job_title && preview.company_name">
                                                    <p class="text-[9px] mt-0.5" :style="'color:' + preview.theme_color + '99'" x-text="preview.company_name"></p>
                                                </template>
                                            </div>
                                        </div>

                                        {{-- Bio --}}
                                        <template x-if="preview.bio">
                                            <p class="text-[9px] text-white/30 leading-relaxed mb-5" x-text="preview.bio"></p>
                                        </template>

                                        {{-- Contact: clean list --}}
                                        <template x-if="preview.email || preview.phone || preview.website">
                                            <div class="rounded-xl bg-white/[0.04] border border-white/[0.06] divide-y divide-white/[0.04] mb-4 overflow-hidden">
                                                <template x-if="preview.email">
                                                    <div class="flex items-center gap-3 px-3.5 py-2.5">
                                                        <svg class="h-3 w-3 shrink-0" :style="'color:' + preview.theme_color" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                                        <p class="text-[10px] text-white/60 truncate" x-text="preview.email"></p>
                                                    </div>
                                                </template>
                                                <template x-if="preview.phone">
                                                    <div class="flex items-center gap-3 px-3.5 py-2.5">
                                                        <svg class="h-3 w-3 shrink-0" :style="'color:' + preview.theme_color" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                                        <p class="text-[10px] text-white/60 truncate" x-text="preview.phone"></p>
                                                    </div>
                                                </template>
                                                <template x-if="preview.website">
                                                    <div class="flex items-center gap-3 px-3.5 py-2.5">
                                                        <svg class="h-3 w-3 shrink-0" :style="'color:' + preview.theme_color" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/></svg>
                                                        <p class="text-[10px] text-white/60 truncate" x-text="preview.website"></p>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        {{-- Custom fields --}}
                                        <template x-if="customFields.length > 0 && customFields.some(f => f.field_name && f.field_value)">
                                            <div class="rounded-xl bg-white/[0.04] border border-white/[0.06] divide-y divide-white/[0.04] mb-4 overflow-hidden">
                                                <template x-for="(field, i) in customFields" :key="'min-field-' + i">
                                                    <div x-show="field.field_name && field.field_value" class="flex items-center gap-3 px-3.5 py-2.5">
                                                        <svg class="h-3 w-3 shrink-0" :style="'color:' + preview.theme_color" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                                                        <div class="min-w-0">
                                                            <p class="text-[7px] text-white/25 font-medium uppercase tracking-wider" x-text="field.field_name"></p>
                                                            <p class="text-[10px] text-white/60 truncate" x-text="field.field_value"></p>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        {{-- Social: horizontal pills --}}
                                        <template x-if="socialLinks.length > 0">
                                            <div class="flex flex-wrap gap-1.5 mb-4">
                                                <template x-for="(link, i) in socialLinks" :key="'min-social-' + i">
                                                    <span class="inline-flex items-center h-6 rounded-md px-2 text-[8px] font-semibold bg-white/[0.06] text-white/40 border border-white/[0.06]"
                                                        x-text="link.platform.charAt(0).toUpperCase() + link.platform.slice(1)"></span>
                                                </template>
                                            </div>
                                        </template>

                                        {{-- Save contact --}}
                                        <div class="flex w-full items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-[10px] font-bold text-white border" :style="'border-color:' + preview.theme_color + '44; background-color:' + preview.theme_color">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                                            Save Contact
                                        </div>

                                        <p class="mt-4 text-center text-[8px] text-white/15 font-medium">
                                            Powered by <span class="font-bold" :style="'color:' + preview.theme_color + '66'">BsnCard</span>
                                        </p>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                </div>
            </div>

            <p class="text-xs text-gray-400 dark:text-gray-500 text-center mt-3">{{ __('Updates as you type') }}</p>
        </div>
    </div>
</div>

<script>
function cardForm() {
    return {
        socialLinks: @json($socialLinksData),
        customFields: @json($customFieldsData),
        preview: {
            full_name: @json(old('full_name', $card->full_name ?? '')),
            job_title: @json(old('job_title', $card->job_title ?? '')),
            company_name: @json(old('company_name', $card->company_name ?? '')),
            email: @json(old('email', $card->email ?? '')),
            phone: @json(old('phone', $card->phone ?? '')),
            website: @json(old('website', $card->website ?? '')),
            bio: @json(old('bio', $card->bio ?? '')),
            theme_color: @json(old('theme_color', $card->theme_color ?? '#3B82F6')),
            layout_style: @json(old('layout_style', $card->layout_style ?? 'classic')),
            profile_photo: @json($existingProfilePhoto),
        },
        previewProfilePhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.preview.profile_photo = e.target.result; };
                reader.readAsDataURL(file);
            }
        },
        addSocialLink() {
            this.socialLinks.push({ platform: 'linkedin', url: '' });
        },
        removeSocialLink(index) {
            this.socialLinks.splice(index, 1);
        },
        addCustomField() {
            this.customFields.push({ field_name: '', field_value: '', icon: '' });
        },
        removeCustomField(index) {
            this.customFields.splice(index, 1);
        },
    }
}
</script>
