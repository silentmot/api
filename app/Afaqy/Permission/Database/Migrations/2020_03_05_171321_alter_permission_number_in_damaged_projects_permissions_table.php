<?php

use Illuminate\Database\Migrations\Migration;

class AlterPermissionNumberInDamagedProjectsPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE damaged_projects_permissions CHANGE COLUMN permission_number permission_number BIGINT(20) NOT NULL;');
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
