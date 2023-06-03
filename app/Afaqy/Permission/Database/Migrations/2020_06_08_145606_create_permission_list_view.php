<?php

use Illuminate\Database\Migrations\Migration;

class CreatePermissionListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $database = \DB::connection()->getDatabaseName();

        \DB::statement("DROP VIEW IF EXISTS {$database}.permissions_list");

        \DB::connection()->getPdo()->exec("
            CREATE VIEW {$database}.permissions_list
            AS
            (
                SELECT
                    individual_damaged_permissions.id,
                    individual_damaged_permissions.permission_number,
                    NULL AS allowed_weight,
                    'دمارات أفراد' AS type,
                    'individual' AS permission_type,
                    SUM(dashboard.enterance_weight) - SUM(dashboard.exit_weight) AS actual_weight,
                    individual_damaged_permissions.created_at
                FROM
                    individual_damaged_permissions
                JOIN
                    checkin_unit
                ON
                    individual_damaged_permissions.id = checkin_unit.checkinable_id AND checkin_unit.checkinable_type = 'Afaqy\\\Permission\\\Models\\\IndividualDamagedPermission'
                LEFT JOIN
                    dashboard
                ON
                    individual_damaged_permissions.id = dashboard.permission_id AND dashboard.permission_type = 'individual'
                GROUP BY individual_damaged_permissions.id, permission_number, NULL, 'دمارات أفراد'
            )
            union
            (
                SELECT
                    damaged_projects_permissions.id,
                    damaged_projects_permissions.permission_number,
                    NULL AS allowed_weight,
                    'دمارات مشاريع' AS type,
                    'project' AS permission_type,
                    SUM(dashboard.enterance_weight) - SUM(dashboard.exit_weight) AS actual_weight,
                    damaged_projects_permissions.created_at
                FROM
                    damaged_projects_permissions
                JOIN
                    checkin_unit
                ON
                    damaged_projects_permissions.id = checkin_unit.checkinable_id AND checkin_unit.checkinable_type = 'Afaqy\\\Permission\\\Models\\\DamagedProjectsPermission'
                LEFT JOIN
                    dashboard
                ON
                    damaged_projects_permissions.id = dashboard.permission_id AND dashboard.permission_type = 'project'
                GROUP BY damaged_projects_permissions.id, permission_number, NULL, 'دمارات مشاريع'
            )
            union
            (
                SELECT
                    commercial_damaged_permissions.id,
                    commercial_damaged_permissions.permission_number,
                    commercial_damaged_permissions.allowed_weight AS allowed_weight,
                    'امر اتلاف تجارى' AS type,
                    'commercial' AS permission_type,
                    SUM(dashboard.enterance_weight) - SUM(dashboard.exit_weight) AS actual_weight,
                    commercial_damaged_permissions.created_at
                FROM
                    commercial_damaged_permissions
                JOIN
                    checkin_unit
                ON
                    commercial_damaged_permissions.id = checkin_unit.checkinable_id AND checkin_unit.checkinable_type = 'Afaqy\\\Permission\\\Models\\\CommercialDamagedPermission'
                LEFT JOIN
                    dashboard
                ON
                    commercial_damaged_permissions.id = dashboard.permission_id AND dashboard.permission_type = 'commercial'
                GROUP BY commercial_damaged_permissions.id, permission_number, commercial_damaged_permissions.allowed_weight, 'امر اتلاف تجارى'
            )
            union
            (
                SELECT
                    governmental_damaged_permissions.id,
                    governmental_damaged_permissions.permission_number,
                    governmental_damaged_permissions.allowed_weight AS allowed_weight,
                    'امر اتلاف حكومى' AS type,
                    'governmental' AS permission_type,
                    SUM(dashboard.enterance_weight) - SUM(dashboard.exit_weight) AS actual_weight,
                    governmental_damaged_permissions.created_at
                FROM
                    governmental_damaged_permissions
                JOIN
                    checkin_unit
                ON
                    governmental_damaged_permissions.id = checkin_unit.checkinable_id AND checkin_unit.checkinable_type = 'Afaqy\\\Permission\\\Models\\\GovernmentalDamagedPermission'
                LEFT JOIN
                    dashboard
                ON
                    governmental_damaged_permissions.id = dashboard.permission_id AND dashboard.permission_type = 'governmental'
                GROUP BY governmental_damaged_permissions.id, permission_number, governmental_damaged_permissions.allowed_weight, 'امر اتلاف حكومى'
            )
             union
            (
                SELECT
                    sorting_area_permissions.id,
                    sorting_area_permissions.id as permission_number,
                    sorting_area_permissions.allowed_weight AS allowed_weight,
                    'مصنع الفرز' AS type,
                    'sorting' AS permission_type,
                    SUM(dashboard.enterance_weight) - SUM(dashboard.exit_weight) AS actual_weight,
                    sorting_area_permissions.created_at
                FROM
                    sorting_area_permissions
                JOIN
                    checkin_unit
                ON
                    sorting_area_permissions.id = checkin_unit.checkinable_id AND checkin_unit.checkinable_type = 'Afaqy\\\Permission\\\Models\\\SortingAreaPermission'
                LEFT JOIN
                    dashboard
                ON
                    sorting_area_permissions.id = dashboard.permission_id AND dashboard.permission_type = 'sorting'
                GROUP BY sorting_area_permissions.id, sorting_area_permissions.allowed_weight, 'مصنع الفرز'
            )
            Order BY created_at DESC
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP VIEW IF EXISTS permissions_list');
    }
}
