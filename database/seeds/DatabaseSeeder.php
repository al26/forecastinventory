<?php

use Illuminate\Database\Seeder;
use Modules\Inventory\Database\Seeders\BahanbakuTableSeeder;
use Modules\Inventory\Entities\pembelian_bahanbaku;

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
    }
}