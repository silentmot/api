<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_unit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('unit_id')->unsigned();
            $table->bigInteger('checkinable_id')->unsigned();
            $table->string('checkinable_type');

            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('permit_units');
            $table->index(['checkinable_type', 'checkinable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkin_unit');
    }
}
