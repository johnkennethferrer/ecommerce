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
        //accessories
        $product = new Product([
        	'name' => 'Earphone 1',
        	'description' => 'Earphone 1',
        	'stock' => '20',
        	'price' => '300',
        	'image' => 'a1.jpg',
        	'user_id' => '1',
        	'category_id' => '1'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Earphone 2',
            'description' => 'Earphone 2',
            'stock' => '20',
            'price' => '200',
            'image' => 'a2.jpg',
            'user_id' => '1',
            'category_id' => '1'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Earphone 3',
            'description' => 'Earphone 3',
            'stock' => '10',
            'price' => '250',
            'image' => 'a3.jpeg',
            'user_id' => '1',
            'category_id' => '1'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Earphone 4',
            'description' => 'Earphone 4',
            'stock' => '15',
            'price' => '1250',
            'image' => 'a4.jpeg',
            'user_id' => '1',
            'category_id' => '1'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Earphone 5',
            'description' => 'Earphone 5',
            'stock' => '30',
            'price' => '1000',
            'image' => 'a5.jpeg',
            'user_id' => '1',
            'category_id' => '1'
        ]);
        $product->save();

        //bags
        $product = new Product([
            'name' => 'Bag 1',
            'description' => 'Bag 1',
            'stock' => '20',
            'price' => '999',
            'image' => 'b1.jpg',
            'user_id' => '1',
            'category_id' => '2'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Bag 2',
            'description' => 'Bag 2',
            'stock' => '30',
            'price' => '1999',
            'image' => 'b2.jpg',
            'user_id' => '1',
            'category_id' => '2'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Bag 3',
            'description' => 'Bag 3',
            'stock' => '25',
            'price' => '1299',
            'image' => 'b3.jpeg',
            'user_id' => '1',
            'category_id' => '2'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Bag 4',
            'description' => 'Bag 4',
            'stock' => '30',
            'price' => '1500',
            'image' => 'b4.jpg',
            'user_id' => '1',
            'category_id' => '2'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Bag 5',
            'description' => 'Bag 5',
            'stock' => '20',
            'price' => '1650',
            'image' => 'b5.jpg',
            'user_id' => '1',
            'category_id' => '2'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Bag 6',
            'description' => 'Bag 6',
            'stock' => '27',
            'price' => '1399',
            'image' => 'b6.jpeg',
            'user_id' => '1',
            'category_id' => '2'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Bag 7',
            'description' => 'Bag 7',
            'stock' => '35',
            'price' => '899',
            'image' => 'b7.jpg',
            'user_id' => '1',
            'category_id' => '2'
        ]);
        $product->save();

        //cellphones
        $product = new Product([
            'name' => 'Cellphone 1',
            'description' => 'Cellphone 1',
            'stock' => '20',
            'price' => '25000',
            'image' => 'cp1.jpeg',
            'user_id' => '1',
            'category_id' => '3'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Cellphone 2',
            'description' => 'Cellphone 2',
            'stock' => '20',
            'price' => '35000',
            'image' => 'cp3.jpeg',
            'user_id' => '1',
            'category_id' => '3'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Cellphone 3',
            'description' => 'Cellphone 3',
            'stock' => '25',
            'price' => '20000',
            'image' => 'cp3.jpeg',
            'user_id' => '1',
            'category_id' => '3'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Cellphone 4',
            'description' => 'Cellphone 4',
            'stock' => '15',
            'price' => '27000',
            'image' => 'cp4.jpg',
            'user_id' => '1',
            'category_id' => '3'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Cellphone 5',
            'description' => 'Cellphone 5',
            'stock' => '20',
            'price' => '7000',
            'image' => 'cp5.png',
            'user_id' => '1',
            'category_id' => '3'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Cellphone 6',
            'description' => 'Cellphone 6',
            'stock' => '22',
            'price' => '5000',
            'image' => 'cp6.jpeg',
            'user_id' => '1',
            'category_id' => '3'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Cellphone 7',
            'description' => 'Cellphone 7',
            'stock' => '22',
            'price' => '15000',
            'image' => 'cp7.jpg',
            'user_id' => '1',
            'category_id' => '3'
        ]);
        $product->save();

        //laptops
        $product = new Product([
            'name' => 'Laptop 1',
            'description' => 'Laptop 1',
            'stock' => '20',
            'price' => '30000',
            'image' => 'lp1.jpg',
            'user_id' => '1',
            'category_id' => '4'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Laptop 2',
            'description' => 'Laptop 2',
            'stock' => '20',
            'price' => '32000',
            'image' => 'lp2.jpg',
            'user_id' => '1',
            'category_id' => '4'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Laptop 3',
            'description' => 'Laptop 3',
            'stock' => '20',
            'price' => '33333',
            'image' => 'lp3.jpg',
            'user_id' => '1',
            'category_id' => '4'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Laptop 4',
            'description' => 'Laptop 4',
            'stock' => '20',
            'price' => '29000',
            'image' => 'lp4.jpg',
            'user_id' => '1',
            'category_id' => '4'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Laptop 5',
            'description' => 'Laptop 5',
            'stock' => '20',
            'price' => '40000',
            'image' => 'lp5.jpg',
            'user_id' => '1',
            'category_id' => '4'
        ]);
        $product->save();  

        $product = new Product([
            'name' => 'Laptop 6',
            'description' => 'Laptop 6',
            'stock' => '20',
            'price' => '20000',
            'image' => 'lp6.jpg',
            'user_id' => '1',
            'category_id' => '4'
        ]);
        $product->save();

        $product = new Product([
            'name' => 'Laptop 7',
            'description' => 'Laptop 7',
            'stock' => '20',
            'price' => '35000',
            'image' => 'lp7.png',
            'user_id' => '1',
            'category_id' => '4'
        ]);
        $product->save();

    }
}
