<?php

namespace Database\Factories;

use App\Models\Interaction;
use App\Models\SavedCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InteractionFactory extends Factory
{
    protected $model = Interaction::class;

    public function definition(): array
    {
        $subjects = [
            'email' => ['Sent proposal', 'Follow-up email', 'Introduction email', 'Thank you note'],
            'call' => ['Quick check-in', 'Project discussion', 'Pricing call', 'Onboarding call'],
            'meeting' => ['Coffee meeting', 'Lunch meeting', 'Office visit', 'Conference chat'],
            'note' => ['Met at conference', 'Referred by John', 'Interested in Pro plan', 'Key decision maker'],
        ];

        $type = fake()->randomElement(['email', 'call', 'meeting', 'note']);

        return [
            'user_id' => User::factory(),
            'saved_card_id' => SavedCard::factory(),
            'interaction_type' => $type,
            'subject' => fake()->randomElement($subjects[$type]),
            'notes' => fake()->optional(0.6)->sentence(),
            'interaction_date' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
