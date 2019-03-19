<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        factory(App\User::class, 3)->create();
=======
        DB::table('users')->insert([
            ['name' => "Administrator", 'email' => 'administrator@mail.dummy', 'password' => bcrypt('administrator')],
            ['name' => "Production", 'email' => 'production@mail.dummy', 'password' => bcrypt('production')],
            ['name' => "Logistic", 'email' => 'logistic@mail.dummy', 'password' => bcrypt('logistic')],
        ]);
>>>>>>> 97778d58626bf83b2c6975764002f4039d131183
    }
}