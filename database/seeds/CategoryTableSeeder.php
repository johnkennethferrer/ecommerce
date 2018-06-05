<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $category = new Category([
        	'name' => 'Accessories',
        	'description' => 'Accessories',
            'user_id' => "1"
        ]);
        $category->save();

        $category = new Category([
            'name' => 'Bags',
            'description' => 'Bags',
            'user_id' => "1"
        ]);
        $category->save();

        $category = new Category([
            'name' => 'Cellphones',
            'description' => 'Cellphones',
            'user_id' => "1"
        ]);
        $category->save();

        $category = new Category([
            'name' => 'Laptops',
            'description' => 'Laptops',
            'user_id' => "1"
        ]);
        $category->save();
    }
}
