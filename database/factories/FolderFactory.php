<?php

namespace Database\Factories;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FolderFactory extends Factory
{
    protected $model = Folder::class;

    public function definition(): array
    {
        $names = ['Clients', 'Prospects', 'Networking Events', 'Conferences', 'Partners', 'Vendors', 'Team', 'VIP'];
        $colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#6B7280', '#14B8A6'];

        return [
            'user_id' => User::factory(),
            'name' => fake()->unique()->randomElement($names),
            'color' => fake()->randomElement($colors),
        ];
    }
}
