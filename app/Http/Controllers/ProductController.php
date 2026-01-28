<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'data' => $products,
        ]);
    }

    public function show(int $id)
    {
        $product = Product::query()->findOrFail($id);

        return response()->json([
            'data' => $product,
        ]);
    }
}