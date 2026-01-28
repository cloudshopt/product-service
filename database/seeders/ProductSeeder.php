<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'CloudShopt Hoodie',
                'description' => 'Comfort hoodie with CloudShopt logo.',
                'price' => 4990,
                'image_url' => null,
            ],
            [
                'name' => 'CloudShopt T-Shirt',
                'description' => 'Basic tee for everyday wear.',
                'price' => 1990,
                'image_url' => null,
            ],
            [
                'name' => 'Sticker Pack',
                'description' => 'Set of 10 vinyl stickers.',
                'price' => 590,
                'image_url' => null,
            ],
            [
                'name' => 'Coffee Mug',
                'description' => 'Ceramic mug 330ml.',
                'price' => 1290,
                'image_url' => null,
            ],
            [
                'name' => 'Notebook',
                'description' => 'A5 dotted notebook.',
                'price' => 990,
                'image_url' => null,
            ],
        ];

        foreach ($items as $item) {
            Product::query()->create($item);
        }
    }
}