<?php

use Afaqy\Inspector\Database\Seeders\TicketPermissionSeeder;
use Afaqy\Inspector\Database\Seeders\TicketTableSeeder;
use Illuminate\Database\Seeder;
use Afaqy\Unit\Database\Seeders\UnitTableSeeder;
use Afaqy\User\Database\Seeders\UserTableSeeder;
use Afaqy\Role\Database\Seeders\NotificationsSeeder;
use Afaqy\Dashboard\Database\Seeders\TripTableSeeder;
use Afaqy\Role\Database\Seeders\LaratrustTableSeeder;
use Afaqy\Role\Database\Seeders\RolePermissionSeeder;
use Afaqy\Unit\Database\Seeders\UnitPermissionSeeder;
use Afaqy\User\Database\Seeders\UserPermissionSeeder;
use Afaqy\Zone\Database\Seeders\ZonePermissionSeeder;
use Afaqy\Permission\Database\Seeders\PermissionSeeder;
use Afaqy\Scale\Database\Seeders\ScalePermissionSeeder;
use Afaqy\Contract\Database\Seeders\ContractTableSeeder;
use Afaqy\Dashboard\Database\Seeders\PreTripTableSeeder;
use Afaqy\District\Database\Seeders\DistrictTableSeeder;
use Afaqy\Zone\Database\Seeders\ZoneModulesTablesSeeder;
use Afaqy\Dashboard\Database\Seeders\TripUnitTableSeeder;
use Afaqy\Device\Database\Seeders\DevicePermissionSeeder;
use Afaqy\Contractor\Database\Seeders\ContractorTableSeeder;
use Afaqy\District\Database\Seeders\NeighborhoodTableSeeder;
use Afaqy\Contract\Database\Seeders\ContractPermissionSeeder;
use Afaqy\Dashboard\Database\Seeders\DashboardDatabaseSeeder;
use Afaqy\District\Database\Seeders\DistrictPermissionSeeder;
use Afaqy\Geofence\Database\Seeders\GeofencePermissionSeeder;
use Afaqy\UnitType\Database\Seeders\UnitTypePermissionSeeder;
use Afaqy\Dashboard\Database\Seeders\DashboardPermissionSeeder;
use Afaqy\District\Database\Seeders\SubNeighborhoodTableSeeder;
use Afaqy\WasteType\Database\Seeders\WasteTypePermissionSeeder;
use Afaqy\Contractor\Database\Seeders\ContractorPermissionSeeder;
use Afaqy\Permission\Database\Seeders\PermissionsRolePermissionSeeder;
use Afaqy\EntrancePermission\Database\Seeders\EntrancePermissionSeeder;
use Afaqy\EntrancePermission\Database\Seeders\EntranceRolePermissionSeeder;
use Afaqy\TransitionalStation\Database\Seeders\TransitionalStationTableSeeder;
use Afaqy\TransitionalStation\Database\Seeders\TransitionalStationPermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.env') !== 'uat') {
            $this->call(UserTableSeeder::class);
            $this->call(LaratrustTableSeeder::class);
            $this->call(NotificationsSeeder::class);
            $this->call(ContractPermissionSeeder::class);
            $this->call(ContractorPermissionSeeder::class);
            $this->call(DashboardPermissionSeeder::class);
            $this->call(DevicePermissionSeeder::class);
            $this->call(DistrictPermissionSeeder::class);
            $this->call(EntranceRolePermissionSeeder::class);
            $this->call(PermissionsRolePermissionSeeder::class);
            $this->call(RolePermissionSeeder::class);
            $this->call(ScalePermissionSeeder::class);
            $this->call(UnitPermissionSeeder::class);
            $this->call(UnitTypePermissionSeeder::class);
            $this->call(UserPermissionSeeder::class);
            $this->call(WasteTypePermissionSeeder::class);
            $this->call(ZonePermissionSeeder::class);
            $this->call(GeofencePermissionSeeder::class);

            $this->call(DistrictTableSeeder::class);
            $this->call(NeighborhoodTableSeeder::class);
            $this->call(SubNeighborhoodTableSeeder::class);

            $this->call(ZoneModulesTablesSeeder::class);

            $this->call(ContractorTableSeeder::class);
            $this->call(UnitTableSeeder::class);

            $this->call(PermissionSeeder::class);
            $this->call(DashboardDatabaseSeeder::class);
            $this->call(EntrancePermissionSeeder::class);
            $this->call(TransitionalStationPermissionSeeder::class);
            $this->call(TransitionalStationTableSeeder::class);

            $this->call(ContractTableSeeder::class);

            $this->call(TripTableSeeder::class);
            $this->call(TripUnitTableSeeder::class);
            $this->call(PreTripTableSeeder::class);

            $this->call(TicketTableSeeder::class);
            $this->call(TicketPermissionSeeder::class);
        }
    }
}
