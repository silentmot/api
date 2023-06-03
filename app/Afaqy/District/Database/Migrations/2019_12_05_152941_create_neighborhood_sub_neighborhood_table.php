<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNeighborhoodSubNeighborhoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neighborhood_sub_neighborhood', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pivot_id')->unsigned();
            $table->bigInteger('sub_neighborhood_id')->unsigned();

            $table->timestamps();

            $table->foreign('pivot_id', 'nsn_pivot_id_foreign')->references('id')->on('district_neighborhood');
            $table->foreign('sub_neighborhood_id', 'nsn_sub_neighborhood_id_foreign')->references('id')->on('sub_neighborhoods');

            $table->unique(['pivot_id', 'sub_neighborhood_id'], 'nsn_pviot_sub_neighborhood_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['nsn_pivot_id_foreign', 'nsn_sub_neighborhood_id_foreign']);
        $table->dropIndex(['nsn_pviot_sub_neighborhood_unique']);

        Schema::dropIfExists('neighborhood_sub_neighborhood');
    }
}
