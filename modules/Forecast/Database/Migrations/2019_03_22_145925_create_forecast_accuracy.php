<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForecastAccuracy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecast_accuracy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sell_history_id')->unsigned();
            $table->foreign('sell_history_id')->references('id')->on('sell_histories')->onDelete('cascade');
            $table->string('method');
            $table->float('st', 8, 2)->default(0);
            $table->float('at', 8, 2)->default(0);
            $table->float('bt', 8, 2)->default(0);
            $table->float('ft', 8, 2)->default(0);
            $table->float('error', 8, 2)->default(0);
            $table->float('error_abs', 8, 2)->default(0);
            $table->float('error_square', 8, 2)->default(0);
            $table->float('error_percentage', 8, 2)->default(0);
            $table->float('error_abs_percent', 8, 2)->default(0);
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
        Schema::dropIfExists('forecast_accuracy');
    }
}
