<x-mail::message>
# Welcome to BsnCard!

Hi {{ $notifiable->name }},

Thanks for joining BsnCard! You're now ready to create beautiful digital business cards and manage your professional network.

Here's what you can do:

- **Create Digital Cards** — Design stunning business cards with QR codes
- **Share Instantly** — Send your card via link or QR code
- **Manage Contacts** — Keep track of everyone you meet with our CRM
- **Track Interactions** — Never miss a follow-up again

<x-mail::button :url="$actionUrl">
Create Your First Card
</x-mail::button>

If you have any questions, don't hesitate to reach out via our support center.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
