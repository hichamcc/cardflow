<?php

namespace Database\Factories;

use App\Models\CardTag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardTagFactory extends Factory
{
    protected $model = CardTag::class;

    public function definition(): array
    {
        $names = ['VIP', 'Follow-up', 'Hot Lead', 'Decision Maker', 'Referral', 'Speaker', 'Investor', 'Developer', 'Designer', 'Marketing'];
        $colors = ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#14B8A6', '#6366F1'];

        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement($names),
            'color' => fake()->randomElement($colors),
        ];
    }
}
