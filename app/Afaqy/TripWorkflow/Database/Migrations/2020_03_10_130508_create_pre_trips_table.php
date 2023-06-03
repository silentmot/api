<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id')->unique();
            $table->unsignedBigInteger('shift_id')->nullable()->index();
            $table->string('plate_number')->index();
            $table->unsignedBigInteger('depart_time')->nullable()->index();
            $table->string('depart_location')->nullable();
            $table->unsignedBigInteger('route_id')->nullable();
            $table->unsignedBigInteger('trip_start_time')->nullable()->index();
            $table->unsignedSmallInteger('total_containers')->nullable();
            $table->unsignedSmallInteger('total_pick')->nullable();
            $table->unsignedSmallInteger('total_missing')->nullable();
            $table->unsignedBigInteger('trip_end_time')->nullable()->index();
            $table->time('total_trip_time')->nullable();

            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_trips');
    }
}
