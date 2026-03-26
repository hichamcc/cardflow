<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\SavedCard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'saved_card_id' => null,
            'title' => fake()->optional(0.7)->sentence(rand(3, 6)),
            'content' => fake()->paragraphs(rand(1, 3), true),
            'is_pinned' => fake()->boolean(20),
            'category' => fake()->randomElement(['general', 'meeting', 'idea', 'todo']),
        ];
    }

    public function attached(): static
    {
        return $this->state(fn () => [
            'saved_card_id' => SavedCard::factory(),
        ]);
    }

    public function pinned(): static
    {
        return $this->state(fn () => [
            'is_pinned' => true,
        ]);
    }
}
