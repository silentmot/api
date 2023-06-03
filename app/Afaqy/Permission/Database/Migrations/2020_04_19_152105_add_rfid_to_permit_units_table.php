<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRfidToPermitUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE permit_units ADD COLUMN `qr_code`  BIGINT(20) NOT NULL AFTER `plate_number`;');
        \DB::statement('ALTER TABLE permit_units ADD COLUMN `rfid`  BIGINT(20) NULL AFTER `qr_code`;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permit_units', function (Blueprint $table) {
        });
    }
}
