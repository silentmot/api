<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsUnitInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips_unit_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('unit_id')->index();
            $table->string('unit_code')->nullable();
            $table->string('rfid')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('unit_type')->nullable();
            $table->string('waste_type')->nullable()->index();
            $table->unsignedMediumInteger('net_weight')->nullable();
            $table->unsignedMediumInteger('max_weight')->nullable();
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->string('permission_type')->nullable();
            $table->integer('permission_number')->nullable();
            $table->integer('demolition_serial')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->string('contract_type')->nullable();
            $table->unsignedInteger('contract_number')->nullable();
            $table->unsignedBigInteger('contractor_id')->nullable()->index();
            $table->string('contractor_name')->nullable()->index();
            $table->string('avl_company')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('district_name')->nullable();
            $table->unsignedBigInteger('neighborhood_id')->nullable();
            $table->string('neighborhood_name')->nullable();
            $table->unsignedBigInteger('station_id')->nullable()->index();
            $table->string('station_name')->nullable();

            $table->timestamps();

            $table->index(['permission_id', 'permission_type']);
            $table->index(['contract_id', 'contract_type']);
            $table->index(['district_id', 'neighborhood_id']);
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
        Schema::dropIfExists('trips_unit_info');
    }
}
