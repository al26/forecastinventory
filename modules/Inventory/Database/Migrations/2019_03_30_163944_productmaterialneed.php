<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Productmaterialneed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productmaterialneed', function (Blueprint $table) {
            $table->primary(['material_code', 'product_id']);
            $table->bigInteger('material_code')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('material_code')->references('material_code')->on('materials')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->double('material_need', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productmaterialneed');
    }
}
