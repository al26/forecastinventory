<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MaterialTableSeeder extends Seeder
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
            ['material_name' => "Kain Katun", 'material_type' => 'Kain', 'material_stock' => 10000, 'Unit' => 'Meter'],
            ['material_name' => "Kain Primissima", 'material_type' => 'Kain', 'material_stock' => 10000, 'Unit' => 'Meter'],
            ['material_name' => "Kain Prima", 'material_type' => 'Kain', 'material_stock' => 10000, 'Unit' => 'Meter'],
            ['material_name' => "Kain Sutra", 'material_type' => 'Kain', 'material_stock' => 10000, 'Unit' => 'Meter'],
            ['material_name' => "Lilin", 'material_type' => 'Lilin', 'material_stock' => 10000, 'Unit' => 'Kg'],
            ['material_name' => "Benang", 'material_type' => 'Benang', 'material_stock' => 10000, 'Unit' => 'Roll'],
            ['material_name' => "Pewarna", 'material_type' => 'Pewarna', 'material_stock' => 10000, 'Unit' => 'Liter'],
        ]);
    }
}
