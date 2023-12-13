<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
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
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(5),
            'price' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (Product $product) {
            Review::factory()->count(random_int(1, 20))->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
