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
        DB::table('product')->insert([
            ['nama_product' => "Kain Batik", 'jenis_product' => 'Kain'],
            ['nama_product' => "Baju Batik", 'jenis_product' => 'Baju'],
            ['nama_product' => "Celana Batik", 'jenis_product' => 'Celana'],
        ]);
    }
}
