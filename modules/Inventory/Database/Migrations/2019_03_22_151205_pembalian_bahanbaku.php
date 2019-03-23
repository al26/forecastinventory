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
        Schema::create('pembelian_bahanbaku', function (Blueprint $table) {
            $table->bigIncrements('kode_pembelian');
            $table->bigInteger('kode_bahanbaku')->unsigned();
            $table->foreign('kode_bahanbaku')->references('kode_bahanbaku')->on('bahanbaku');
            $table->integer('jumlah_pembelian');
            $table->integer('nominal_pembelian');
            $table->dateTime('tanggal_pembelian');
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
        Schema::dropIfExists('pembelian_bahanbaku');
    }
}
