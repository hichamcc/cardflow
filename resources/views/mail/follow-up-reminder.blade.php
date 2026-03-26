<x-mail::message>
# Follow-up Reminder

Hi {{ $notifiable->name }},

You have a follow-up scheduled with **{{ $contactName }}** for **{{ $followUp->follow_up_date->format('M j, Y') }}**.

@if($followUp->notes)
> {{ $followUp->notes }}
@endif

<x-mail::button :url="$actionUrl">
View Contact
</x-mail::button>

Stay on top of your relationships!

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
