<?php

use Illuminate\Database\Seeder;
use Modules\Inventory\Database\Seeders\MaterialTableSeeder;
use Modules\Inventory\Database\Seeders\ProductTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UsersTableSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(RolePermissionSeeder::class);
        // $this->call(BahanbakuTableSeeder::class);
        // $this->call(pembelian_bahanbaku::class);
        $this->call(ProductTableSeeder::class);
        $this->call(MaterialTableSeeder::class);
    }
}
