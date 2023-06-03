<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortingAreaPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorting_area_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('waste_type_id');
            $table->string('entity_name');
            $table->string('representative_name')->nullable();
            $table->string('national_id')->nullable();
            $table->bigInteger('allowed_weight')->nullable();
            $table->bigInteger('actual_weight')->nullable();
            $table->timestamps();

            $table->foreign('waste_type_id')->references('id')->on('waste_types');
        });

        \DB::statement("ALTER TABLE sorting_area_permissions AUTO_INCREMENT = 2000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sorting_area_permission');
    }
}
