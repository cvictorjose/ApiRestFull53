<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        static $password;

        DB::table('users')->delete();
        DB::statement("ALTER TABLE `users` AUTO_INCREMENT = 1;");

        App\User::create([
            'name' => "Admin Gag",
            'email' => "ccw@gag.it",
            'password' => $password ?: $password = bcrypt('123456'),
            'role' => 'admin',
            'remember_token' => str_random(10),
            'api_token' => str_random(60),

        ]);

        factory(User::class, 5)->create();
    }
}
