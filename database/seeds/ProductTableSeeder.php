<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $product = new Product([
        	'name' => '',
        	'description' => '',
        	'stock' => '',
        	'price' => '',
        	'image' => '',
        	'user_id' => '',
        	'category_id' => ''
        ]);

        $product->save();
    }
}
