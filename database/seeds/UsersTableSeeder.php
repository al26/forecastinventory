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
            ['name' => "Administrator", 'username' => 'administrator', 'password' => bcrypt('administrator')],
            ['name' => "Production", 'username' => 'production', 'password' => bcrypt('production')],
            ['name' => "Logistic", 'username' => 'logistic', 'password' => bcrypt('logistic')],
        ]);
    }
}