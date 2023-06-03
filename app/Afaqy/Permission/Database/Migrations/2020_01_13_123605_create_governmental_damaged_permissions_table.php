<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGovernmentalDamagedPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('governmental_damaged_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('permission_number');
            $table->date('permission_date');
            $table->string('entity_name');
            $table->string('representative_name');
            $table->string('national_id');
            $table->bigInteger('allowed_weight')->nullable();
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
        Schema::dropIfExists('governmental_damaged_permissions');
    }
}
