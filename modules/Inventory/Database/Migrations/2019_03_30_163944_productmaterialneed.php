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
            $table->primary(['material_code', 'product_code']);
            $table->unsignedInteger('material_code');
            $table->unsignedInteger('product_code');
            $table->foreign('material_code')->references('material_code')->on('materials')->onDelete('cascade');
            $table->foreign('product_code')->references('product_code')->on('products')->onDelete('cascade');
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
