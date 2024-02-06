<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'user_id' => User::factory([
                'user_type_id' => 2
            ]),
            'name' => fake()->name(),
            'price' => fake()->numberBetween(1, 999),
            'stock_quantity' => fake()->randomDigitNotZero(),
            'details' => fake()->paragraph(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            ProductImage::factory([
                'product_id' => $product->id,
            ])->create();
        });
    }
}
