<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualDamagedPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_damaged_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('demolition_serial');
            $table->integer('permission_number');
            $table->date('permission_date');
            $table->enum('type', ["construction", "demolition", "restoration", "drilling_services", "municipality_projects", "charity_projects"]);
            $table->bigInteger('district_id')->unsigned();
            $table->bigInteger('neighborhood_id')->unsigned();
            $table->string('street')->nullable();
            $table->string('owner_name');
            $table->string('national_id');
            $table->string('owner_phone');
            $table->bigInteger('actual_weight')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individual_damaged_permissions');
    }
}
