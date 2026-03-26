<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class WeeklyDigestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Collection $overdueFollowUps,
        public Collection $upcomingFollowUps,
        public int $weeklyInteractions,
        public int $cardViews,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your BsnCard Weekly Digest')
            ->markdown('mail.weekly-digest', [
                'notifiable' => $notifiable,
                'overdueCount' => $this->overdueFollowUps->count(),
                'upcomingCount' => $this->upcomingFollowUps->count(),
                'weeklyInteractions' => $this->weeklyInteractions,
                'cardViews' => $this->cardViews,
                'actionUrl' => url('/dashboard'),
            ]);
    }
}
