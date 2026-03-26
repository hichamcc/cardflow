<x-mail::message>
# New Reply to Your Ticket

Hello {{ $notifiable->name }},

An admin has replied to your support ticket:

**{{ $ticket->subject }}**

> {{ Str::limit($replyPreview, 200) }}

<x-mail::button :url="$actionUrl">
View Ticket
</x-mail::button>

Thank you for using BsnCard!

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
