<?php

namespace Database\Factories;

use App\Models\FollowUp;
use App\Models\SavedCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowUpFactory extends Factory
{
    protected $model = FollowUp::class;

    public function definition(): array
    {
        $notes = ['Send proposal', 'Schedule demo call', 'Check in on project', 'Share case study', 'Ask about referral', 'Follow up on pricing'];
        $followUpDate = fake()->dateTimeBetween('-5 days', '+14 days');

        return [
            'user_id' => User::factory(),
            'saved_card_id' => SavedCard::factory(),
            'follow_up_date' => $followUpDate,
            'reminder_date' => fake()->optional(0.5)->dateTimeBetween('-7 days', $followUpDate),
            'status' => fake()->randomElement(['pending', 'pending', 'pending', 'completed', 'cancelled']),
            'notes' => fake()->randomElement($notes),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending', 'follow_up_date' => fake()->dateTimeBetween('now', '+14 days')]);
    }

    public function overdue(): static
    {
        return $this->state(['status' => 'pending', 'follow_up_date' => fake()->dateTimeBetween('-10 days', '-1 day')]);
    }
}
