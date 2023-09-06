<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RestaurantUserFactory extends Factory
{
    private static int $sequence = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = \App\Models\User::pluck('id')->all();
        $restaurants = \App\Models\Restaurant::pluck('id')->all();
        
        return [
            'user_id' => $this->faker->randomElement($users),
            'restaurant_id' => $this->faker->randomElement($restaurants),
            'comment' => $this->faker->realText(100),
            'review' => $this->faker->numberBetween(1, 5),
        ];
    }
}
