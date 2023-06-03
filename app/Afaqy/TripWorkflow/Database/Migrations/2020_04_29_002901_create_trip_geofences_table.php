<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripGeofencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_geofences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id');
            $table->string('plate_number');
            $table->enum('geofence_status', ['registered', 'actual']);
            $table->unsignedBigInteger('geofence_id');
            $table->string('geofence_name');
            $table->enum('geofence_type', ['zone', 'pit']);
            $table->unsignedBigInteger('shift_id')->nullable()->index();
            $table->unsignedBigInteger('access_time')->nullable();

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
        Schema::dropIfExists('trip_geofences');
    }
}
