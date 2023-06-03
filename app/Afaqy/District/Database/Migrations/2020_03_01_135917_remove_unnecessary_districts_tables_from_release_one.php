<?php

use Illuminate\Database\Migrations\Migration;

class RemoveUnnecessaryDistrictsTablesFromReleaseOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $database = \DB::connection()->getDatabaseName();

        \DB::statement("DROP VIEW IF EXISTS {$database}.districts_neighborhoods_counts");
        \DB::statement("DROP Table IF EXISTS {$database}.neighborhood_sub_neighborhood");
        \DB::statement("DROP Table IF EXISTS {$database}.district_neighborhood");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
