<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PembalianBahanbaku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials_buyment', function (Blueprint $table) {
            $table->bigIncrements('buyment_code');
            $table->bigInteger('material_code')->unsigned();
            $table->foreign('material_code')->references('material_code')->on('materials');
            $table->integer('buyment_total');
            $table->integer('buyment_price');
            $table->dateTime('buyment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials_buyment');
    }
}
