<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryRestaurantFactory extends Factory
{
    private static int $sequence = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = \App\Models\Category::pluck('id')->all();
        return [
            'restaurant_id' => self::$sequence++,
            'category_id' => $this->faker->randomElement($categories),
        ];
    }
}
