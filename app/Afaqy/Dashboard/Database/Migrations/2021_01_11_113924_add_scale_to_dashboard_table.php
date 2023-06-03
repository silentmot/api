<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @TODO: need to search in this query performance, because of scales joins
 */
class AddScaleToDashboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $database = \DB::connection()->getDatabaseName();

        \DB::statement("DROP VIEW IF EXISTS {$database}.dashboard");

        \DB::connection()->getPdo()->exec("
            CREATE VIEW {$database}.dashboard
            AS (
            SELECT
                `trips`.`id`,
                `trips`.`trip_unit_type` as `trip_type`,
                `trips`.`start_time`,
                `trips`.`year`,
                `trips`.`month`,
                `trips`.`week`,
                `entrance_scale`.`id` as entrance_scale_id,
                `entrance_scale`.`name` as entrance_scale_name,
                `trips`.`enterance_weight`,
                `trips`.`enterance_weight_time`,
                `exit_scale`.`id` as exit_scale_id,
                `exit_scale`.`name` as exit_scale_name,
                `trips`.`exit_weight`,
                `trips`.`end_time`,
                `trips_unit_info`.`unit_id`,
                `trips`.`plate_number`,
                `trips_unit_info`.`unit_code`,
                `trips_unit_info`.`rfid`,
                `trips_unit_info`.`qr_code`,
                `trips_unit_info`.`unit_type`,
                `trips_unit_info`.`waste_type`,
                `trips_unit_info`.`net_weight`,
                `trips_unit_info`.`max_weight`,
                `trips_unit_info`.`permission_id`,
                `trips_unit_info`.`permission_type`,
                `trips_unit_info`.`permission_number`,
                `trips_unit_info`.`demolition_serial`,
                `trips_unit_info`.`contract_id`,
                `trips_unit_info`.`contract_type`,
                `trips_unit_info`.`contract_number`,
                `trips_unit_info`.`contractor_id`,
                `trips_unit_info`.`contractor_name`,
                `trips_unit_info`.`district_id`,
                `trips_unit_info`.`district_name`,
                `trips_unit_info`.`neighborhood_id`,
                `trips_unit_info`.`neighborhood_name`,
                `trips_unit_info`.`station_id`,
                `trips_unit_info`.`station_name`
            FROM
                `trips`
            JOIN trips_unit_info on trips.id = trips_unit_info.trip_id
            JOIN scales as entrance_scale on trips.entrance_scale_zone_id = entrance_scale.zone_id
            JOIN scales as exit_scale on trips.exit_scale_zone_id = exit_scale.zone_id
        )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dashboard', function (Blueprint $table) {
            \DB::statement('DROP VIEW IF EXISTS dashboard');
        });
    }
}
