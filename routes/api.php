<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/info', function () {
    return response()->json([
        'ok11' => true,
        'service' => config('app.name'),
        'sha' => env('IMAGE_SHA', null),
        'time' => now()->toISOString(),
    ]);
});

Route::get('/database', function () {
    try {
        $started = microtime(true);
        DB::connection()->select('SELECT 1');
        $ms = (microtime(true) - $started) * 1000;

        return response()->json([
            'ok' => true,
            'db' => [
                'connection' => DB::getDefaultConnection(),
                'database' => DB::connection()->getDatabaseName(),
                'ping_ms' => round($ms, 2),
            ],
            'time' => now()->toISOString(),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'ok' => false,
            'error' => 'DB connection failed',
            'message' => app()->hasDebugModeEnabled() ? $e->getMessage() : null,
        ], 500);
    }
});





Route::get('/products', function () {
    return response()->json([
        [
            'id' => 1,
            'name' => 'CloudShopt Hoodie',
            'price' => 49.90,
            'currency' => 'EUR',
            'sku' => 'CS-HOODIE-001',
            'in_stock' => true,
        ],
        [
            'id' => 2,
            'name' => 'CloudShopt T-Shirt',
            'price' => 19.90,
            'currency' => 'EUR',
            'sku' => 'CS-TSHIRT-001',
            'in_stock' => true,
        ],
        [
            'id' => 3,
            'name' => 'CloudShopt Mug',
            'price' => 12.90,
            'currency' => 'EUR',
            'sku' => 'CS-MUG-001',
            'in_stock' => false,
        ],
    ]);
});


Route::get('/products/{id}', function (string $id) {
    $products = [
        1 => [
            'id' => 1,
            'name' => 'CloudShopt Hoodie',
            'price' => 49.90,
            'currency' => 'EUR',
            'sku' => 'CS-HOODIE-001',
            'in_stock' => true,
            'description' => 'Warm hoodie for cloud-native builders.',
        ],
        2 => [
            'id' => 2,
            'name' => 'CloudShopt T-Shirt',
            'price' => 19.90,
            'currency' => 'EUR',
            'sku' => 'CS-TSHIRT-001',
            'in_stock' => true,
            'description' => 'Soft cotton tee with CloudShopt logo.',
        ],
        3 => [
            'id' => 3,
            'name' => 'CloudShopt Mug',
            'price' => 12.90,
            'currency' => 'EUR',
            'sku' => 'CS-MUG-001',
            'in_stock' => false,
            'description' => 'Ceramic mug for your morning deploys.',
        ],
    ];

    if (!isset($products[(int)$id])) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json($products[(int)$id]);
});