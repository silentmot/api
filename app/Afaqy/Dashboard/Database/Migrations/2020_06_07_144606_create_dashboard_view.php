<?php

use Illuminate\Database\Migrations\Migration;

class CreateDashboardView extends Migration
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
                `trips`.`enterance_weight`,
                `trips`.`enterance_weight_time`,
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
        )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP VIEW IF EXISTS dashboard');
    }
}
