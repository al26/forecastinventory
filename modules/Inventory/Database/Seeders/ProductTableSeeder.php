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
            ['product_code' => 'KB01','product_name' => "Kain Batik", 'product_type' => 'Kain'],
            ['product_code' => 'KT01','product_name' => "Kain Tritik", 'product_type' => 'Kain'],
            ['product_code' => 'SB01','product_name' => "Selendang Batik", 'product_type' => 'Selendang'],
            ['product_code' => 'ST01','product_name' => "Selendang Tritik", 'product_type' => 'Selendang'],
        ]);
    }
}
