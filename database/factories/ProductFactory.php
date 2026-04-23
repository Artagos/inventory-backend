<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'quantity' => $this->faker->numberBetween(0, 50),
            'min_threshold' => $this->faker->numberBetween(0, 20),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
        ];
    }
}
