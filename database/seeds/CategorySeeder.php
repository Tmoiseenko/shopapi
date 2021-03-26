<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, rand(5, 10))
            ->create()
            ->each(function (App\Category $category) {
                $category->categories()->saveMany(
                  factory(App\Category::class, rand(2, 5))->make()
                );
            });

        $fistLevel = App\Category::whereNotNull('category_id')->get('id');
        foreach ($fistLevel as $key => $val) {
            factory(App\Category::class, rand(1, 3))->create([
                'category_id' => $val->id
            ]);
        }
    }
}
