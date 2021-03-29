<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\User::all() as $user) {
            factory(\App\Order::class)->create([
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }
    }
}
