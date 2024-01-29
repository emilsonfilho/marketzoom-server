<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_id' => User::factory([
                'user_type_id' => 2
            ]),
            'name' => fake()->name(),
            'slogan' => fake()->sentence(),
            'active' => 1,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Shop $shop) {
            $shop->user()->update([
                'shop_id' => $shop->id,
                'user_type_id' => 2
            ]);
        });
    }
}
