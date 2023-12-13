<?php

use App\Models\Product;

use function Pest\Laravel\postJson;

it('allows anyone to create reviews for a product', function () {
    $product = Product::factory()->create();

    $data = [
        'user_name' => fake()->userName,
        'rating' => 5,
        'comment' => 'This product is amazing!',
    ];

    $response = postJson("/api/products/{$product->id}/reviews", $data);

    $response->assertStatus(201); // Created status code
    $response->assertJsonStructure([
        'data' => [
            'id',
            'user_name', // Review data matches provided values
            'rating',
            'comment',
            'created_at',
            'updated_at',
        ],
    ]);

    $this->assertDatabaseHas('reviews', [
        'product_id' => $product->id,
        'user_name' => $data['user_name'],
        'rating' => $data['rating'],
        'comment' => $data['comment'],
    ]);
});

it('validates required fields for review creation', function () {
    $product = Product::factory()->create();
    $response = postJson("/api/products/{$product->id}/reviews");

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['user_name', 'rating', 'comment']);
});
