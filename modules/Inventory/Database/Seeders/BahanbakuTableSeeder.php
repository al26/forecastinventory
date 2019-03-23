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
        DB::table('bahanbaku')->insert([
            ['nama_bahanbaku' => "Kain Mori", 'jenis_bahanbaku' => 'Habis Pakai','jumlah_stock' => 10],
            ['nama_bahanbaku' => "Canting", 'jenis_bahanbaku' => 'Tidak Habis Pakai','jumlah_stock' => 10],
            ['nama_bahanbaku' => "Malam", 'jenis_bahanbaku' => 'Habis Pakai','jumlah_stock' => 10],
            ['nama_bahanbaku' => "Pewarna", 'jenis_bahanbaku' => 'Habis Pakai','jumlah_stock' => 10],
            ['nama_bahanbaku' => "Wajan", 'jenis_bahanbaku' => 'Tidak Habis Pakai','jumlah_stock' => 10],
            ['nama_bahanbaku' => "Kompor", 'jenis_bahanbaku' => 'Tidak Habis Pakai','jumlah_stock' => 10],
            ['nama_bahanbaku' => "Gawangan", 'jenis_bahanbaku' => 'Tidak Habis Pakai','jumlah_stock' => 10],
        ]);
    }
}
