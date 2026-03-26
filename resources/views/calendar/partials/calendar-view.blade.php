<div x-data="calendarView()" x-init="fetchEvents()" class="rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
    {{-- Calendar Header --}}
    <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-700">
        <button @click="prevMonth()" class="rounded-lg border border-gray-300 bg-white p-2 text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
            <x-phosphor-caret-left class="h-4 w-4" />
        </button>
        <h2 class="text-base font-semibold text-gray-900 dark:text-white" x-text="monthYearLabel"></h2>
        <button @click="nextMonth()" class="rounded-lg border border-gray-300 bg-white p-2 text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
            <x-phosphor-caret-right class="h-4 w-4" />
        </button>
    </div>

    {{-- Day Headers --}}
    <div class="grid grid-cols-7 border-b border-gray-200 dark:border-gray-700">
        <template x-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
            <div class="py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400" x-text="day"></div>
        </template>
    </div>

    {{-- Calendar Grid --}}
    <div class="grid grid-cols-7">
        <template x-for="(day, index) in calendarDays" :key="index">
            <div class="min-h-[100px] border-b border-r border-gray-100 p-1.5 dark:border-gray-800"
                 :class="{ 'bg-blue-50/50 dark:bg-blue-900/10': day.isToday, 'opacity-40': !day.isCurrentMonth }">
                <div class="mb-1 text-right">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full text-xs"
                          :class="day.isToday ? 'bg-blue-600 text-white font-bold' : 'text-gray-700 dark:text-gray-300'"
                          x-text="day.date"></span>
                </div>
                <div class="space-y-0.5">
                    <template x-for="event in day.events.slice(0, 3)" :key="event.id">
                        <a :href="event.url" class="block truncate rounded px-1 py-0.5 text-[10px] font-medium text-white"
                           :style="'background-color:' + event.color"
                           x-text="event.title"></a>
                    </template>
                    <template x-if="day.events.length > 3">
                        <span class="block text-center text-[10px] text-gray-400 dark:text-gray-500" x-text="'+' + (day.events.length - 3) + ' more'"></span>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
function calendarView() {
    return {
        currentDate: new Date(),
        events: [],
        monthYearLabel: '',
        calendarDays: [],

        fetchEvents() {
            const start = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1);
            const end = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0);

            const startStr = start.toISOString().split('T')[0];
            const endStr = end.toISOString().split('T')[0];

            fetch(`/api/events?start=${startStr}&end=${endStr}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                this.events = data;
                this.buildCalendar();
            });
        },

        buildCalendar() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            this.monthYearLabel = months[month] + ' ' + year;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();
            const today = new Date();

            const days = [];

            // Previous month padding
            for (let i = firstDay - 1; i >= 0; i--) {
                days.push({ date: daysInPrevMonth - i, isCurrentMonth: false, isToday: false, events: [] });
            }

            // Current month
            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === d;
                const dayEvents = this.events.filter(e => e.start.substring(0, 10) === dateStr);
                days.push({ date: d, isCurrentMonth: true, isToday, events: dayEvents });
            }

            // Next month padding
            const remaining = 42 - days.length;
            for (let d = 1; d <= remaining; d++) {
                days.push({ date: d, isCurrentMonth: false, isToday: false, events: [] });
            }

            this.calendarDays = days;
        },

        prevMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
            this.fetchEvents();
        },

        nextMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
            this.fetchEvents();
        }
    }
}
</script>
