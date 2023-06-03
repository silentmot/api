<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('com_port')->nullable();
            $table->string('baud_rate')->nullable();
            $table->string('parity')->nullable();
            $table->string('data_bits')->nullable();
            $table->string('stop_bits')->nullable();
            $table->integer('start_read')->nullable();
            $table->integer('end_read')->nullable();
            $table->string('service_url')->nullable();
            $table->string('ip')->nullable()->unique();
            $table->unsignedBigInteger('zone_id')->nullable()->unique(); // one-to-one
            $table->smallInteger('path_order')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('zone_id')->references('id')->on('zones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scales');
    }
}
