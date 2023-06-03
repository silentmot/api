<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictNeighborhoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_neighborhood', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('district_id')->unsigned();
            $table->bigInteger('neighborhood_id')->unsigned();
            $table->unsignedTinyInteger('status')->default(1);

            $table->timestamps();

            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods');

            $table->unique(['district_id', 'neighborhood_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['district_id', 'neighborhood_id']);

        Schema::dropIfExists('district_neighborhood');
    }
}
