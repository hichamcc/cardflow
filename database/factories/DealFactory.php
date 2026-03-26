<?php

namespace Database\Factories;

use App\Models\Deal;
use App\Models\SavedCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    protected $model = Deal::class;

    public function definition(): array
    {
        $dealNames = ['Website Redesign', 'Consulting Package', 'Annual Contract', 'Software License', 'Partnership Deal', 'Marketing Campaign'];

        return [
            'user_id' => User::factory(),
            'saved_card_id' => SavedCard::factory(),
            'deal_name' => fake()->randomElement($dealNames),
            'deal_value' => fake()->randomFloat(2, 500, 50000),
            'currency' => 'USD',
            'stage' => fake()->randomElement(['lead', 'negotiation', 'closed_won', 'closed_lost']),
            'expected_close_date' => fake()->optional(0.7)->dateTimeBetween('now', '+90 days'),
            'notes' => fake()->optional(0.5)->sentence(),
        ];
    }
}
