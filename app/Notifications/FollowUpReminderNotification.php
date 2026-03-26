<?php

namespace App\Notifications;

use App\Models\FollowUp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FollowUpReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public FollowUp $followUp) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $contactName = $this->followUp->savedCard->businessCard->full_name ?? 'a contact';

        return (new MailMessage)
            ->subject("Reminder: Follow up with {$contactName}")
            ->markdown('mail.follow-up-reminder', [
                'notifiable' => $notifiable,
                'contactName' => $contactName,
                'followUp' => $this->followUp,
                'actionUrl' => url("/contacts/{$this->followUp->saved_card_id}"),
            ]);
    }
}
