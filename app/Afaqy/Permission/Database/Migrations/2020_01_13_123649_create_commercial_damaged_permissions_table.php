<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialDamagedPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_damaged_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('permission_number');
            $table->date('permission_date');
            $table->string('company_name');
            $table->bigInteger('company_commercial_number');
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
        Schema::dropIfExists('commercial_damaged_permissions');
    }
}
