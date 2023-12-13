<?php

use App\Models\Product;
use App\Models\Review;

it('has belongs to relationship with Product model', function () {
    $product = Product::factory()->create();
    $review = Review::query()->inRandomOrder()->first();

    expect($review->product->id)->toBe($product->id);
});
