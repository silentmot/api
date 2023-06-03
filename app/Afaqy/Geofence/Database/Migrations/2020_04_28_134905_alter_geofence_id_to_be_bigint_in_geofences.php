<?php

use Illuminate\Database\Migrations\Migration;

class AlterGeofenceIdToBeBigintInGeofences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE geofences MODIFY geofence_id bigint(20) not Null;');
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
