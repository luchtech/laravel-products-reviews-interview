<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class StoreReviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreReviewRequest $request, Product $product): JsonResponse
    {
        $review = $product->reviews()->create($request->validated());

        return response()->json([
            'data' => $review,
        ], 201);
    }
}
