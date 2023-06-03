<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('permission_number');
            $table->enum('permission_type', ['individual', 'project', 'commercial', 'governmental', 'sorting']);
            $table->bigInteger('allowed_weight')->nullable();
            $table->bigInteger('actual_weight')->nullable();
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
        Schema::dropIfExists('permission_logs');
    }
}
