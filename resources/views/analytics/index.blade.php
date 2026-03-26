<x-layouts.app>
    <x-slot:title>Analytics</x-slot:title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        {{-- Page Header --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Analytics</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track your networking performance and relationship health.</p>
        </div>

        {{-- Row 1: Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- My Cards --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30">
                        <x-phosphor-identification-card class="w-5 h-5 text-blue-500" />
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">My Cards</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_cards'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Contacts --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-green-50 dark:bg-green-900/30">
                        <x-phosphor-address-book class="w-5 h-5 text-green-500" />
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Contacts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_contacts'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Views --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30">
                        <x-phosphor-eye class="w-5 h-5 text-purple-500" />
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Views</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_views']) }}</p>
                    </div>
                </div>
            </div>

            {{-- Pipeline Value --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-3">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30">
                        <x-phosphor-currency-dollar class="w-5 h-5 text-emerald-500" />
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pipeline Value</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($stats['total_pipeline_value'], 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Row 2: Interactions Over Time + Interaction Types --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Interactions Over Time (2/3) --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <x-phosphor-chart-line-up class="w-4 h-4 text-blue-500" />
                    </span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Interactions Over Time</h3>
                    <span class="text-xs text-gray-400 ml-auto">Last 30 days</span>
                </div>
                <div class="h-64" x-data x-init="
                    const ctx = $el.querySelector('canvas').getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 256);
                    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
                    gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {{ Js::from($interactionsByDay->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))) }},
                            datasets: [{
                                label: 'Interactions',
                                data: {{ Js::from($interactionsByDay->pluck('count')) }},
                                borderColor: '#3B82F6',
                                backgroundColor: gradient,
                                borderWidth: 2,
                                pointRadius: 3,
                                pointBackgroundColor: '#3B82F6',
                                tension: 0.4,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 1, font: { size: 11 } } }
                            }
                        }
                    });
                ">
                    <canvas></canvas>
                </div>
            </div>

            {{-- Interaction Types (1/3) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-900/30">
                        <x-phosphor-chart-pie class="w-4 h-4 text-purple-500" />
                    </span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Interaction Types</h3>
                </div>
                <div class="h-64 flex items-center justify-center" x-data x-init="
                    new Chart($el.querySelector('canvas').getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: {{ Js::from($interactionTypes->pluck('interaction_type')->map(fn($t) => ucfirst($t))) }},
                            datasets: [{
                                data: {{ Js::from($interactionTypes->pluck('count')) }},
                                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EF4444'],
                                borderWidth: 0,
                                borderRadius: 4,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '65%',
                            plugins: {
                                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, pointStyle: 'circle', font: { size: 11 } } }
                            }
                        }
                    });
                ">
                    <canvas></canvas>
                </div>
            </div>
        </div>

        {{-- Row 3: Card Performance + Deal Pipeline --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Card Performance (2/3) --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <x-phosphor-chart-bar class="w-4 h-4 text-blue-500" />
                    </span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Card Performance</h3>
                </div>
                <div class="h-64" x-data x-init="
                    new Chart($el.querySelector('canvas').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: {{ Js::from($viewsByCard->pluck('card_name')) }},
                            datasets: [{
                                label: 'Views',
                                data: {{ Js::from($viewsByCard->pluck('view_count')) }},
                                backgroundColor: '#3B82F6',
                                borderRadius: 6,
                                borderSkipped: false,
                                barThickness: 28,
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 11 } } },
                                y: { grid: { display: false }, ticks: { font: { size: 11 } } }
                            }
                        }
                    });
                ">
                    <canvas></canvas>
                </div>
            </div>

            {{-- Deal Pipeline (1/3) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30">
                        <x-phosphor-funnel class="w-4 h-4 text-emerald-500" />
                    </span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Deal Pipeline</h3>
                </div>
                <div class="h-64" x-data x-init="
                    const stageColors = { lead: '#3B82F6', negotiation: '#F59E0B', closed_won: '#10B981', closed_lost: '#EF4444' };
                    const stages = {{ Js::from($dealsByStage) }};
                    new Chart($el.querySelector('canvas').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: stages.map(s => s.stage.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase())),
                            datasets: [{
                                label: 'Value ($)',
                                data: stages.map(s => parseFloat(s.total)),
                                backgroundColor: stages.map(s => stageColors[s.stage] || '#3B82F6'),
                                borderRadius: 6,
                                borderSkipped: false,
                                barThickness: 28,
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 11 } } },
                                y: { grid: { display: false }, ticks: { font: { size: 11 } } }
                            }
                        }
                    });
                ">
                    <canvas></canvas>
                </div>
            </div>
        </div>

        {{-- Row 4: Top Contacts + Relationship Health --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Top Contacts by Activity (2/3) --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-50 dark:bg-green-900/30">
                        <x-phosphor-users class="w-4 h-4 text-green-500" />
                    </span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Top Contacts by Activity</h3>
                </div>
                <div class="h-64" x-data x-init="
                    const contacts = {{ Js::from($topContacts) }};
                    new Chart($el.querySelector('canvas').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: contacts.map(c => c.name),
                            datasets: [{
                                label: 'Interactions',
                                data: contacts.map(c => c.count),
                                backgroundColor: '#10B981',
                                borderRadius: 6,
                                borderSkipped: false,
                                barThickness: 28,
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 1, font: { size: 11 } } },
                                y: { grid: { display: false }, ticks: { font: { size: 11 } } }
                            }
                        }
                    });
                ">
                    <canvas></canvas>
                </div>
            </div>

            {{-- Relationship Health (1/3) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-blue-500/[0.08] border border-gray-100/80 dark:border-gray-700 p-5">
                <div class="flex items-center gap-2 mb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 dark:bg-red-900/30">
                        <x-phosphor-heartbeat class="w-4 h-4 text-red-500" />
                    </span>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Relationship Health</h3>
                </div>
                <div class="h-64 flex items-center justify-center" x-data x-init="
                    const buckets = {{ Js::from($healthBuckets) }};
                    new Chart($el.querySelector('canvas').getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: Object.keys(buckets),
                            datasets: [{
                                data: Object.values(buckets),
                                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                                borderWidth: 0,
                                borderRadius: 4,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '65%',
                            plugins: {
                                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, pointStyle: 'circle', font: { size: 11 } } }
                            }
                        }
                    });
                ">
                    <canvas></canvas>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
