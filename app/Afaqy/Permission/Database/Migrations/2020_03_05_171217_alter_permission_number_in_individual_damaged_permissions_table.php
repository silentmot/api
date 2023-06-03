<?php

use Illuminate\Database\Migrations\Migration;

class AlterPermissionNumberInIndividualDamagedPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE individual_damaged_permissions CHANGE COLUMN permission_number permission_number BIGINT(20) NOT NULL;');
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
