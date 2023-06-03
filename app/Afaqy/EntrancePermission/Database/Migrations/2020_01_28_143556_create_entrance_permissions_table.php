<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrancePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrance_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['employee', 'visitor']);
            $table->string('name');
            $table->string('title');
            $table->string('national_id');
            $table->string('phone');
            $table->string('company')->nullable();
            $table->string('plate_number');
            $table->date('start_date');
            $table->date('end_date');

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
        Schema::dropIfExists('entrance_permissions');
    }
}
