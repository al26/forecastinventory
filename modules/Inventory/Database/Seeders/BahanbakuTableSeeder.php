<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BahanbakuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Model::unguard();
        DB::table('materials')->insert([
            ['material_name' => "Kain Mori", 'material_type' => 'Habis Pakai','material_stock' => 10],
            ['material_name' => "Canting", 'material_type' => 'Tidak Habis Pakai','material_stock' => 10],
            ['material_name' => "Malam", 'material_type' => 'Habis Pakai','material_stock' => 10],
            ['material_name' => "Pewarna", 'material_type' => 'Habis Pakai','material_stock' => 10],
            ['material_name' => "Wajan", 'material_type' => 'Tidak Habis Pakai','material_stock' => 10],
            ['material_name' => "Kompor", 'material_type' => 'Tidak Habis Pakai','material_stock' => 10],
            ['material_name' => "Gawangan", 'material_type' => 'Tidak Habis Pakai','material_stock' => 10],
        ]);
    }
}
