<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsAdditionalZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips_additional_zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('zone_id');
            $table->string('zone_type');
            $table->string('device_ip');
            $table->string('device_direction');
            $table->string('scale_ip')->nullable();
            $table->unsignedMediumInteger('scale_weight')->nullable();
            $table->unsignedBigInteger('access_time')->index();

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
        Schema::dropIfExists('trips_additional_zones');
    }
}
