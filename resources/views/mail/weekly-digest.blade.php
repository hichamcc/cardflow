<x-mail::message>
# Your Weekly Digest

Hi {{ $notifiable->name }},

Here's your weekly summary:

@if($overdueCount > 0)
- **{{ $overdueCount }} overdue follow-ups** need your attention.
@endif

@if($upcomingCount > 0)
- **{{ $upcomingCount }} follow-ups** coming up this week.
@endif

- You logged **{{ $weeklyInteractions }} interactions** this week.
- Your cards received **{{ $cardViews }} views** this week.

<x-mail::button :url="$actionUrl">
Go to Dashboard
</x-mail::button>

Keep building those relationships!

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
