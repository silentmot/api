<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plate_number')->index();
            $table->unsignedBigInteger('shift_id')->index();
            $table->unsignedBigInteger('arrival_time')->index();
            $table->string('arrival_location');

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
        Schema::dropIfExists('post_trips');
    }
}
