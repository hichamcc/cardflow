<?php

namespace App\Notifications;

use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public SupportTicket $ticket,
        public string $replyPreview,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reply to: ' . $this->ticket->subject)
            ->markdown('mail.ticket-reply', [
                'notifiable' => $notifiable,
                'ticket' => $this->ticket,
                'replyPreview' => $this->replyPreview,
                'actionUrl' => url('/support/' . $this->ticket->id),
            ]);
    }
}
