<?php

use Illuminate\Database\Migrations\Migration;

class AlterPermissionNumberInCommercialDamagedPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE commercial_damaged_permissions CHANGE COLUMN permission_number permission_number BIGINT(20) NOT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
