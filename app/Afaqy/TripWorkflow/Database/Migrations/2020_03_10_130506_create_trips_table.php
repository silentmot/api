<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plate_number');
            $table->string('trip_unit_type');
            $table->unsignedBigInteger('entrance_zone_id');
            $table->string('entrance_device_ip');
            $table->unsignedBigInteger('start_time')->index();
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->unsignedTinyInteger('week');

            $table->unsignedBigInteger('entrance_scale_zone_id')->nullable();
            $table->string('entrance_scale_device_ip')->nullable();
            $table->string('enterance_scale_ip')->nullable();
            $table->unsignedMediumInteger('enterance_weight')->nullable();
            $table->unsignedBigInteger('enterance_weight_time')->nullable()->index();
            $table->unsignedBigInteger('open_enterance_scale_gate_time')->nullable();

            $table->unsignedBigInteger('exit_scale_zone_id')->nullable();
            $table->string('exit_scale_device_ip')->nullable();
            $table->string('exit_scale_ip')->nullable();
            $table->unsignedMediumInteger('exit_weight')->nullable();
            $table->unsignedBigInteger('open_exit_scale_gate_time')->nullable();

            $table->unsignedBigInteger('end_time')->nullable()->index();

            $table->timestamps();

            $table->index(['plate_number', 'trip_unit_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
