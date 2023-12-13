<?php

use App\Models\Product;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('returns a list of products', function () {
    Product::factory()->count(5)->create();

    $response = getJson('/api/products');

    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            [
                'id',
                'name',
                'description',
                'price',
                'created_at',
                'updated_at',
                'reviews' => [
                    [
                        'id',
                        'product_id',
                        'user_name',
                        'rating',
                        'comment',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
        ],
    ]);
});

it('returns a specific product', function () {
    $product = Product::factory()->create();

    $response = getJson('/api/products/'.$product->id);

    $response->assertOk();
    $response->assertJsonPath('data.id', $product->id);
    $response->assertJsonPath('data.name', $product->name);
    $response->assertJsonPath('data.description', $product->description);
    $response->assertJsonPath('data.price', $product->price);
});

it('creates a new product successfully', function () {
    $data = [
        'name' => 'Awesome Product',
        'description' => 'This product is amazing!',
        'price' => 19.99,
    ];

    $response = postJson('/api/products', $data);

    $response->assertStatus(201); // Created status code
    $response->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'description',
            'price',
            'created_at',
            'updated_at',
        ],
    ]);

    $this->assertDatabaseHas('products', [
        'name' => $data['name'],
        'description' => $data['description'],
        'price' => $data['price'],
    ]);
});

it('validates required fields for product creation', function () {
    $response = postJson('/api/products');

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'price']);
});

it('updates an existing product successfully', function () {
    $product = Product::factory()->create();
    $data = [
        'name' => 'Updated Product Name',
        'description' => 'Description has changed!',
    ];

    $response = $this->putJson("/api/products/$product->id", $data);

    $response->assertStatus(200); // OK status code
    $response->assertJsonPath('data.name', $data['name']);
    $response->assertJsonPath('data.description', $data['description']);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => $data['name'],
        'description' => $data['description'],
    ]);
});

it('deletes an existing product successfully', function () {
    $product = Product::factory()->create();

    $response = $this->deleteJson("/api/products/$product->id");

    $response->assertStatus(204); // No Content status code
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});
