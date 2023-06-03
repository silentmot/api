<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitTypeWasteTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_type_waste_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('unit_type_id')->unsigned();
            $table->bigInteger('waste_type_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('unit_type_id')->references('id')->on('unit_types');
            $table->foreign('waste_type_id')->references('id')->on('waste_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_type_waste_type');
    }
}
