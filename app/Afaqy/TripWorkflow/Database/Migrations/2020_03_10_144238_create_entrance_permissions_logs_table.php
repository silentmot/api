<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrancePermissionsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrance_permissions_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('permission_type');
            $table->string('plate_number')->index();
            $table->string('qr_code')->nullable();
            $table->string('rfid')->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('national_id')->nullable();
            $table->unsignedBigInteger('start_time')->index();
            $table->unsignedBigInteger('end_time')->nullable()->index();

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
        Schema::dropIfExists('entrance_permissions_logs');
    }
}
