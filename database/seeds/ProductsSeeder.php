<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Product::class, rand(50, 80))
            ->create()
            ->each(function (App\Product $product) {
                $catId = App\Category::takeRandom()->first();
                $product['category_id'] = $catId;
                $product->save();
            });
    }
}
