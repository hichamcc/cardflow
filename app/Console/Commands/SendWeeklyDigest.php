<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\WeeklyDigestNotification;
use Illuminate\Console\Command;

class SendWeeklyDigest extends Command
{
    protected $signature = 'bsncard:weekly-digest';
    protected $description = 'Send weekly digest to all users with activity';

    public function handle(): int
    {
        $users = User::whereHas('savedCards')->get();

        $count = 0;
        foreach ($users as $user) {
            $overdueFollowUps = $user->followUps()
                ->with('savedCard.businessCard')
                ->where('status', 'pending')
                ->where('follow_up_date', '<', today())
                ->get();

            $upcomingFollowUps = $user->followUps()
                ->with('savedCard.businessCard')
                ->where('status', 'pending')
                ->whereBetween('follow_up_date', [today(), today()->addDays(7)])
                ->get();

            $weeklyInteractions = $user->interactions()
                ->where('created_at', '>=', now()->subWeek())
                ->count();

            $cardViews = $user->businessCards()
                ->sum('view_count'); // Simplified; ideally track weekly delta

            if ($overdueFollowUps->isEmpty() && $upcomingFollowUps->isEmpty() && $weeklyInteractions === 0) {
                continue;
            }

            $user->notify(new WeeklyDigestNotification(
                $overdueFollowUps,
                $upcomingFollowUps,
                $weeklyInteractions,
                $cardViews,
            ));

            $count++;
        }

        $this->info("Sent weekly digest to {$count} users.");

        return Command::SUCCESS;
    }
}
