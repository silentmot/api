<?php

use Illuminate\Database\Migrations\Migration;

class CreateDistrictNeighborhoodsCountsView extends Migration
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

        \DB::connection()->getPdo()->exec("
            CREATE VIEW {$database}.districts_neighborhoods_counts
            AS
            (
                SELECT
                    `districts`.`id` AS `id`,
                    `districts`.`name` AS `name`,
                    COUNT(
                        DISTINCT `district_neighborhood`.`neighborhood_id`
                    ) AS `neighborhoods_count`,
                    COUNT(
                        `neighborhood_sub_neighborhood`.`sub_neighborhood_id`
                    ) AS `sub_neighborhoods_count`
                FROM
                    `districts`
                LEFT JOIN `district_neighborhood` ON `districts`.`id` = `district_neighborhood`.`district_id` AND `district_neighborhood`.`status` = 1
                LEFT JOIN `neighborhood_sub_neighborhood` ON `district_neighborhood`.`id` = `neighborhood_sub_neighborhood`.`pivot_id`
                WHERE
                    ISNULL(`districts`.`deleted_at`)
                GROUP BY
                    `districts`.`id`,
                    `districts`.`name`
                ORDER BY
                    `districts`.`id`
                DESC
            )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP VIEW IF EXISTS districts_neighborhoods_counts');
    }
}
