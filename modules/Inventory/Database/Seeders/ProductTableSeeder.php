<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();
        DB::table('products')->insert([
            ['product_name' => "Kain Batik", 'product_type' => 'Kain'],
            ['product_name' => "Kain Tritik", 'product_type' => 'Kain'],
            ['product_name' => "Selendang Batik", 'product_type' => 'Selendang'],
            ['product_name' => "Selendang Tritik", 'product_type' => 'Selendang'],
        ]);
    }
}
