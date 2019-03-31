<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('product_code')->unsigned();
            $table->foreign('product_code')->references('product_code')->on('products')->onDelete('cascade');
            $table->string('period');
            $table->bigInteger('amount');
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
        Schema::dropIfExists('sell_histories');
    }
}
