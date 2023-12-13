<?php

use App\Models\Product;
use App\Models\Review;

it('has many relationship with Review model', function () {
    $product = Product::factory()->create();
    $review = Review::query()->inRandomOrder()->first();

    expect($product->reviews()->whereKey($review)->exists())->toBeTrue();
});
