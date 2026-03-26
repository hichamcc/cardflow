<x-layouts.app :title="__('Import Contacts')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <a href="{{ route('contacts.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-phosphor-arrow-left class="h-4 w-4" />
                {{ __('Back to Contacts') }}
            </a>
        </div>

        <div>
            <x-heading size="xl" level="1">{{ __('Import Contacts') }}</x-heading>
            <x-subheading>{{ __('Upload a CSV file to bulk import contacts.') }}</x-subheading>
        </div>

        {{-- Import Results --}}
        @if(session('import_results'))
            @php $results = session('import_results'); @endphp
            <div class="rounded-xl border border-green-200 bg-green-50 p-5 dark:border-green-800 dark:bg-green-900/20">
                <div class="flex items-start gap-3">
                    <x-phosphor-check-circle class="mt-0.5 h-5 w-5 text-green-600 dark:text-green-400" />
                    <div>
                        <h3 class="text-sm font-semibold text-green-800 dark:text-green-300">{{ __('Import Complete') }}</h3>
                        <div class="mt-2 space-y-1 text-sm text-green-700 dark:text-green-400">
                            <p>{{ __(':count contacts created', ['count' => $results['created']]) }}</p>
                            @if($results['skipped'] > 0)
                                <p>{{ __(':count duplicates skipped (matching email)', ['count' => $results['skipped']]) }}</p>
                            @endif
                            @if($results['errors'] > 0)
                                <p>{{ __(':count rows had errors and were skipped', ['count' => $results['errors']]) }}</p>
                            @endif
                        </div>
                        <a href="{{ route('contacts.index') }}" class="mt-3 inline-flex items-center gap-1 text-sm font-medium text-green-800 hover:underline dark:text-green-300">
                            {{ __('View Contacts') }}
                            <x-phosphor-arrow-right class="h-3.5 w-3.5" />
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            {{-- Upload Form --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                    <x-heading size="base">{{ __('Upload CSV File') }}</x-heading>
                </div>
                <div class="p-5">
                    <form method="POST" action="{{ route('contacts.import.process') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div>
                            <label for="csv_file" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('CSV File') }}</label>
                            <input type="file" id="csv_file" name="csv_file" accept=".csv,.txt" required
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:file:bg-blue-900/30 dark:file:text-blue-400">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('CSV format, max 2MB, up to 500 rows.') }}</p>
                            @error('csv_file')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                <x-phosphor-upload class="h-4 w-4" />
                                {{ __('Import Contacts') }}
                            </button>
                            <a href="{{ route('contacts.sample-csv') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                <x-phosphor-download class="h-4 w-4" />
                                {{ __('Download Sample') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Instructions --}}
            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                    <x-heading size="base">{{ __('Format Guide') }}</x-heading>
                </div>
                <div class="p-5">
                    <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <p>{{ __('Your CSV file should include the following columns:') }}</p>
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full text-xs">
                                <thead>
                                    <tr class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
                                        <th class="px-3 py-2 text-left font-medium text-gray-700 dark:text-gray-300">{{ __('Column') }}</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-700 dark:text-gray-300">{{ __('Required') }}</th>
                                        <th class="px-3 py-2 text-left font-medium text-gray-700 dark:text-gray-300">{{ __('Notes') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    <tr><td class="px-3 py-1.5 font-mono">full_name</td><td class="px-3 py-1.5 text-green-600">{{ __('Yes') }}</td><td class="px-3 py-1.5">{{ __('Contact name') }}</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">email</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">{{ __('Used for duplicate detection') }}</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">phone</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">-</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">company_name</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">-</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">job_title</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">-</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">website</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">{{ __('Must be a valid URL') }}</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">relationship_status</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">{{ __('lead, prospect, client, partner, other') }}</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">folder</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">{{ __('Created if not existing') }}</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">tags</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">{{ __('Pipe-separated: design|marketing') }}</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">notes</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">{{ __('Personal notes') }}</td></tr>
                                    <tr><td class="px-3 py-1.5 font-mono">last_contacted_at</td><td class="px-3 py-1.5">{{ __('No') }}</td><td class="px-3 py-1.5">{{ __('Date format: YYYY-MM-DD') }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="rounded-lg bg-amber-50 p-3 text-xs text-amber-800 dark:bg-amber-900/20 dark:text-amber-400">
                            <p class="font-medium">{{ __('Notes:') }}</p>
                            <ul class="mt-1 list-inside list-disc space-y-0.5">
                                <li>{{ __('Contacts with matching email addresses will be skipped as duplicates.') }}</li>
                                <li>{{ __('Folders and tags are automatically created if they don\'t exist.') }}</li>
                                <li>{{ __('Maximum 500 rows per import.') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
