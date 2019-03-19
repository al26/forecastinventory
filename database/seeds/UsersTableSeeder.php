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

        DB::table('users')->insert([
            ['name' => "Administrator", 'email' => 'administrator@mail.dummy', 'password' => bcrypt('administrator')],
            ['name' => "Production", 'email' => 'production@mail.dummy', 'password' => bcrypt('production')],
            ['name' => "Logistic", 'email' => 'logistic@mail.dummy', 'password' => bcrypt('logistic')],
        ]);
    }
}