<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\SavedCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-7 days', '+14 days');
        $end = (clone $start)->modify('+' . rand(30, 120) . ' minutes');

        return [
            'user_id' => User::factory(),
            'saved_card_id' => null,
            'title' => fake()->sentence(rand(3, 6)),
            'description' => fake()->optional(0.5)->paragraph(),
            'start_at' => $start,
            'end_at' => $end,
            'location' => fake()->optional(0.4)->address(),
            'type' => fake()->randomElement(['meeting', 'call', 'task', 'reminder', 'other']),
            'status' => 'scheduled',
            'color' => fake()->optional(0.3)->hexColor(),
        ];
    }

    public function past(): static
    {
        return $this->state(function () {
            $start = fake()->dateTimeBetween('-30 days', '-1 day');
            $end = (clone $start)->modify('+' . rand(30, 120) . ' minutes');
            return ['start_at' => $start, 'end_at' => $end, 'status' => fake()->randomElement(['completed', 'scheduled'])];
        });
    }

    public function today(): static
    {
        return $this->state(function () {
            $hour = rand(8, 17);
            $start = today()->setHour($hour);
            $end = (clone $start)->addMinutes(rand(30, 90));
            return ['start_at' => $start, 'end_at' => $end];
        });
    }

    public function upcoming(): static
    {
        return $this->state(function () {
            $start = fake()->dateTimeBetween('+1 day', '+14 days');
            $end = (clone $start)->modify('+' . rand(30, 120) . ' minutes');
            return ['start_at' => $start, 'end_at' => $end];
        });
    }
}
