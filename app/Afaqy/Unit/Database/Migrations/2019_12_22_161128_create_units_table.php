<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->index();
            $table->unsignedInteger('model')->nullable()->index();
            $table->string('plate_number')->index();
            $table->string('vin_number')->nullable();
            $table->unsignedBigInteger('unit_type_id');
            $table->unsignedBigInteger('waste_type_id');
            $table->unsignedBigInteger('contractor_id');
            $table->double('net_weight')->index();
            $table->double('max_weight');
            $table->unsignedBigInteger('rfid')->nullable();
            $table->unsignedTinyInteger('active')->default(1)->index();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('unit_type_id')->references('id')->on('unit_types');
            $table->foreign('waste_type_id')->references('id')->on('waste_types');
            $table->foreign('contractor_id')->references('id')->on('contractors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
