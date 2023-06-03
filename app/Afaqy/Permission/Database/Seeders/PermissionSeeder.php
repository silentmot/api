<?php

namespace Afaqy\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Afaqy\Permission\Models\PermitUnit;
use Afaqy\Permission\Models\CheckinUnit;
use Afaqy\Permission\Models\DamagedProjectsPermission;
use Afaqy\Permission\Models\CommercialDamagedPermission;
use Afaqy\Permission\Models\IndividualDamagedPermission;
use Afaqy\Permission\Models\GovernmentalDamagedPermission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermitUnits();
        $this->createIndividualPermission();
        $this->createGovernmentalPermission();
        $this->createCommercialPermission();
        $this->createProjectsDamagedPermission();
    }

    public function createPermitUnits()
    {
        if (!PermitUnit::count()) {
            $units =  factory(PermitUnit::class, 100)->create();

            return $units;
        }
    }

    public function createIndividualPermission()
    {
        $individual_permissions = factory(IndividualDamagedPermission::class, 10)->create();

        if (!CheckinUnit::where('checkinable_type', IndividualDamagedPermission::class)->count()) {
            foreach ($individual_permissions as $permission) {
                factory(CheckinUnit::class)->create([
                    'unit_id'          => rand(1, 100),
                    'checkinable_id'   => $permission->id,
                    'checkinable_type' => IndividualDamagedPermission::class,
                ]);
            }
        }

        return $individual_permissions;
    }

    public function createGovernmentalPermission()
    {
        $governmental_permissions = factory(GovernmentalDamagedPermission::class, 10)->create();
        if (!CheckinUnit::where('checkinable_type', GovernmentalDamagedPermission::class)->count()) {
            foreach ($governmental_permissions as $permission) {
                factory(CheckinUnit::class)->create([
                    'unit_id'          => rand(1, 100),
                    'checkinable_id'   => $permission->id,
                    'checkinable_type' => GovernmentalDamagedPermission::class,
                ]);
            }
        }

        return $governmental_permissions;
    }

    public function createCommercialPermission()
    {
        $commercial_permissions = factory(CommercialDamagedPermission::class, 10)->create();

        if (!CheckinUnit::where('checkinable_type', CommercialDamagedPermission::class)->count()) {
            foreach ($commercial_permissions as $permission) {
                factory(CheckinUnit::class)->create([
                    'unit_id'          => rand(1, 100),
                    'checkinable_id'   => $permission->id,
                    'checkinable_type' => CommercialDamagedPermission::class,
                ]);
            }
        }

        return $commercial_permissions;
    }

    public function createProjectsDamagedPermission()
    {
        $damaged_projects_permissions = factory(DamagedProjectsPermission::class, 10)->create();
        if (!CheckinUnit::where('checkinable_type', DamagedProjectsPermission::class)->count()) {
            foreach ($damaged_projects_permissions as $permission) {
                factory(CheckinUnit::class)->create([
                    'unit_id'          => rand(1, 100),
                    'checkinable_id'   => $permission->id,
                    'checkinable_type' => DamagedProjectsPermission::class,
                ]);
            }
        }

        return $damaged_projects_permissions;
    }
}
