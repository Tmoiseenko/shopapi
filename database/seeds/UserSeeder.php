<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => 'Jhon Doe',
            'email' => 'JhonDoe@mail.ru',
        ]);

        $user = User::where('email', 'JhonDoe@mail.ru')->first();
        $token = $user->createToken($user->email)->plainTextToken;
        $this->command->info($token);

        factory(App\User::class, 6)->create()->each(function ($user) {
            $token = $user->createToken($user->email)->plainTextToken;
            $this->command->info($token);
        });
    }
}
