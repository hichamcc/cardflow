<?php

namespace App\Console\Commands;

use App\Models\FollowUp;
use App\Notifications\FollowUpReminderNotification;
use Illuminate\Console\Command;

class SendFollowUpReminders extends Command
{
    protected $signature = 'bsncard:send-reminders';
    protected $description = 'Send follow-up reminder notifications for today';

    public function handle(): int
    {
        $followUps = FollowUp::needsReminder()
            ->with(['user', 'savedCard.businessCard'])
            ->get();

        $count = 0;
        foreach ($followUps as $followUp) {
            $followUp->user->notify(new FollowUpReminderNotification($followUp));
            $count++;
        }

        $this->info("Sent {$count} follow-up reminders.");

        return Command::SUCCESS;
    }
}
