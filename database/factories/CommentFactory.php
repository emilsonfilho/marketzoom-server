<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory([
            'user_type_id' => 2
        ])->create();
        $product = Product::factory([
            'stock_quantity' => fake()->numberBetween(11, 100),
            'user_id' => $user->id,
        ])->create();

        return [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'title' => fake()->title(),
            'content' => fake()->paragraph(),
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}
