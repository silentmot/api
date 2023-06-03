<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWasteTypeZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_type_zone', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('waste_type_id');
            $table->unsignedBigInteger('zone_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('waste_type_id')->references('id')->on('waste_types');
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
        Schema::dropIfExists('waste_type_zone');
    }
}
