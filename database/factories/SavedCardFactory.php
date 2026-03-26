<?php

namespace Database\Factories;

use App\Models\BusinessCard;
use App\Models\Folder;
use App\Models\SavedCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavedCardFactory extends Factory
{
    protected $model = SavedCard::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'business_card_id' => BusinessCard::factory(),
            'custom_note' => fake()->optional(0.5)->sentence(),
            'contact_frequency' => fake()->randomElement(['never', 'low', 'medium', 'high']),
            'relationship_status' => fake()->randomElement(['lead', 'prospect', 'client', 'partner', 'other']),
            'last_contacted_at' => fake()->optional(0.6)->dateTimeBetween('-60 days', 'now'),
        ];
    }

    public function manualClient(): static
    {
        return $this->state(fn () => [
            'business_card_id' => null,
            'saved_from_user_id' => null,
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company_name' => fake()->company(),
            'job_title' => fake()->jobTitle(),
            'website' => fake()->optional(0.5)->url(),
        ]);
    }
}
