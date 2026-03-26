<?php

namespace Database\Factories;

use App\Models\BusinessCard;
use App\Models\CardSocialLink;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardSocialLinkFactory extends Factory
{
    protected $model = CardSocialLink::class;

    public function definition(): array
    {
        $platforms = [
            'linkedin' => 'https://linkedin.com/in/',
            'twitter' => 'https://twitter.com/',
            'instagram' => 'https://instagram.com/',
            'github' => 'https://github.com/',
            'facebook' => 'https://facebook.com/',
        ];

        $platform = fake()->randomElement(array_keys($platforms));

        return [
            'business_card_id' => BusinessCard::factory(),
            'platform' => $platform,
            'url' => $platforms[$platform] . fake()->userName(),
            'display_order' => fake()->numberBetween(0, 5),
        ];
    }
}
