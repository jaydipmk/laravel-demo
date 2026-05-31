<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Product 1',
                'price' => 10.00,
            ],
            [
                'name' => 'Product 2',
                'price' => 20.00,
            ],
            [
                'name' => 'Product 3',
                'price' => 30.00,
            ],
        ]);
    }
}
