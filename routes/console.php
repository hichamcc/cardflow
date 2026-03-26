<?php

use Illuminate\Support\Facades\Schedule;

// Send follow-up reminders every morning at 8 AM
Schedule::command('bsncard:send-reminders')->dailyAt('08:00');

// Send weekly digest every Monday at 9 AM
Schedule::command('bsncard:weekly-digest')->weeklyOn(1, '09:00');
