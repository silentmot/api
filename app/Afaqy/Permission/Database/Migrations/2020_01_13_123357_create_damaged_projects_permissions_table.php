<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDamagedProjectsPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damaged_projects_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('permission_number');
            $table->integer('demolition_serial');
            $table->date('permission_date');
            $table->string('company_name');
            $table->bigInteger('company_commercial_number');
            $table->bigInteger('actual_weight')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('damaged_projects_permissions');
    }
}
