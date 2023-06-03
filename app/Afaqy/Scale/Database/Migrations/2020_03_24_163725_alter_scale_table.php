<?php

use Illuminate\Database\Migrations\Migration;

class AlterScaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $database = \DB::connection()->getDatabaseName();

        \DB::statement("DROP INDEX scales_ip_unique ON {$database}.scales");
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
