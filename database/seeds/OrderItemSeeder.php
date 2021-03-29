<?php

use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Order::all() as $order) {
            factory(App\OrderItem::class, rand(1, 5))
                ->create(['order_id' => $order->id])
                ->each(function ($orderItem) {
                    $orderItem['product_id'] = \App\Product::takeRandom()->first('id')->id;
                    $orderItem->save();
                });
        }
    }
}
