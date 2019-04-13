<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MaterialproductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productmaterialneed')->insert([
            ['material_code' => 1, 'product_id' => 1, 'material_need' => 2.5],
            ['material_code' => 7, 'product_id' => 1, 'material_need' => 12],
            ['material_code' => 5, 'product_id' => 1, 'material_need' => 0.5],
            ['material_code' => 1, 'product_id' => 2, 'material_need' => 2.5],
            ['material_code' => 7, 'product_id' => 2, 'material_need' => 6],
            ['material_code' => 6, 'product_id' => 2, 'material_need' => 1],
            ['material_code' => 1, 'product_id' => 3, 'material_need' => 0.6],
            ['material_code' => 7, 'product_id' => 3, 'material_need' => 6],
            ['material_code' => 5, 'product_id' => 3, 'material_need' => 0.5],
            ['material_code' => 1, 'product_id' => 4, 'material_need' => 0.6],
            ['material_code' => 7, 'product_id' => 4, 'material_need' => 6],
            ['material_code' => 6, 'product_id' => 4, 'material_need' => 1]
        ]);
    }
}
