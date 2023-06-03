<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQrCodeAndRfidToEnterancePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrance_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('qr_code')->nullable()->after('end_date');
            $table->unsignedBigInteger('rfid')->nullable()->after('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterance_permissions', function (Blueprint $table) {
        });
    }
}
