<?php

namespace Database\Factories;

use App\Models\BusinessCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessCardFactory extends Factory
{
    protected $model = BusinessCard::class;

    public function definition(): array
    {
        $cardNames = ['Work', 'Freelance', 'Personal', 'Consulting', 'Side Project'];
        $colors = ['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444', '#EC4899', '#14B8A6', '#6366F1'];

        return [
            'user_id' => User::factory(),
            'card_name' => fake()->randomElement($cardNames),
            'full_name' => fake()->name(),
            'job_title' => fake()->jobTitle(),
            'company_name' => fake()->company(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->url(),
            'bio' => fake()->optional(0.7)->sentences(2, true),
            'theme_color' => fake()->randomElement($colors),
            'layout_style' => fake()->randomElement(['classic', 'modern', 'minimal']),
            'is_active' => fake()->boolean(90),
            'view_count' => fake()->numberBetween(0, 500),
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
