<?php

namespace Afaqy\Zone\Database\Seeders;

use Afaqy\Zone\Models\Zone;
use Afaqy\Scale\Models\Scale;
use Afaqy\Device\Models\Device;
use Illuminate\Database\Seeder;

class ZoneModulesTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createZones();
        $this->createDevices();
        $this->createScales();
    }

    public function createZones()
    {
        if (!Zone::count()) {
            factory(Zone::class)->create([
                'name'  => 'منطقة دخول 1',
                'reads' => 10,
                'type'  => 'entrance',
            ]);

            factory(Zone::class)->create([
                'name'  => 'منطقة دخول 2',
                'reads' => 10,
                'type'  => 'entrance',
            ]);

            factory(Zone::class)->create([
                'name'  => 'منطقة دخول 3',
                'reads' => 10,
                'type'  => 'entrance',
            ]);

            factory(Zone::class)->create([
                'name'       => 'منطقة وزن دخول 1',
                'reads'      => 10,
                'message_id' => 0,
                'type'       => 'entranceScale',
            ]);

            factory(Zone::class)->create([
                'name'       => 'منطقة وزن دخول 2',
                'reads'      => 10,
                'message_id' => 1,
                'type'       => 'entranceScale',
            ]);

            factory(Zone::class)->create([
                'name'       => 'منطقة وزن دخول 3',
                'reads'      => 10,
                'message_id' => 2,
                'type'       => 'entranceScale',
            ]);

            factory(Zone::class)->create([
                'name'  => 'منطقة وزن خروج 1',
                'reads' => 10,
                'type'  => 'exit',
            ]);

            factory(Zone::class)->create([
                'name'  => 'منطقة وزن خروج 2',
                'reads' => 10,
                'type'  => 'exit',
            ]);
        }
    }

    public function createDevices()
    {
        if (!Device::count()) {
            factory(Device::class)->create([
                'name'        => 'جهاز دخول مركبات 1 LPR',
                'description' => null,
                'serial'      => 1,
                'type'        => 'lpr',
                'ip'          => '192.168.1.222',
                'direction'   => 'in',
                'duration'    => 3,
                'zone_id'     => 1,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز دخول مركبات 1 Inbio',
                'description' => null,
                'serial'      => 2,
                'type'        => 'rfid',
                'ip'          => '192.168.1.203',
                'direction'   => 'in',
                'duration'    => 3,
                'door_name'   => 'Entr_inb_G2',
                'zone_id'     => 1,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز دخول مركبات 2 LPR',
                'description' => null,
                'serial'      => 3,
                'type'        => 'lpr',
                'ip'          => '192.168.1.221',
                'direction'   => 'in',
                'duration'    => 3,
                'zone_id'     => 2,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز دخول مركبات 2 Inbio',
                'description' => null,
                'serial'      => 4,
                'type'        => 'rfid',
                'ip'          => '192.168.1.201',
                'direction'   => 'in',
                'duration'    => 3,
                'door_name'   => 'Entr_inb_G1',
                'zone_id'     => 2,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز دخول مركبات 3 LPR',
                'description' => null,
                'serial'      => 5,
                'type'        => 'lpr',
                'ip'          => '192.168.1.231',
                'direction'   => 'in',
                'duration'    => 3,
                'zone_id'     => 3,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز دخول مركبات 3 Inbio',
                'description' => null,
                'serial'      => 6,
                'type'        => 'rfid',
                'ip'          => '192.168.1.172',
                'direction'   => 'in',
                'duration'    => 3,
                'door_name'   => 'Entr_Inb_VE_G',
                'zone_id'     => 3,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن دخول 1 LPR',
                'description' => null,
                'serial'      => 7,
                'type'        => 'lpr',
                'ip'          => '192.168.1.226',
                'direction'   => 'in',
                'duration'    => 3,
                'zone_id'     => 4,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن دخول 1 Inbio',
                'description' => null,
                'serial'      => 8,
                'type'        => 'rfid',
                'ip'          => '192.168.1.206',
                'direction'   => 'in',
                'duration'    => 3,
                'door_name'   => 'Entr_inb_Scale1',
                'zone_id'     => 4,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن دخول 2 LPR',
                'description' => null,
                'serial'      => 9,
                'type'        => 'lpr',
                'ip'          => '192.168.1.230',
                'direction'   => 'in',
                'duration'    => 3,
                'zone_id'     => 5,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن دخول 2 Inbio',
                'description' => null,
                'serial'      => 10,
                'type'        => 'rfid',
                'ip'          => '192.168.1.171',
                'direction'   => 'in',
                'duration'    => 3,
                'door_name'   => 'Entr_inb_Scale2',
                'zone_id'     => 5,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن دخول 3 LPR',
                'description' => null,
                'serial'      => 11,
                'type'        => 'lpr',
                'ip'          => '192.168.1.224',
                'direction'   => 'in',
                'duration'    => 3,
                'zone_id'     => 6,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن دخول 3 Inbio',
                'description' => null,
                'serial'      => 12,
                'type'        => 'rfid',
                'ip'          => '192.168.1.204',
                'direction'   => 'in',
                'duration'    => 3,
                'door_name'   => 'Entr_inb_Scale3',
                'zone_id'     => 6,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن خروج 1 LPR',
                'description' => null,
                'serial'      => 13,
                'type'        => 'lpr',
                'ip'          => '192.168.1.225',
                'direction'   => 'out',
                'duration'    => 3,
                'zone_id'     => 7,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن خروج 1 Inbio',
                'description' => null,
                'serial'      => 14,
                'type'        => 'rfid',
                'ip'          => '192.168.1.207',
                'direction'   => 'out',
                'duration'    => 3,
                'door_name'   => 'Exit_inb_Scale1',
                'zone_id'     => 7,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن خروج 2 LPR',
                'description' => null,
                'serial'      => 15,
                'type'        => 'lpr',
                'ip'          => '192.168.1.228',
                'direction'   => 'out',
                'duration'    => 3,
                'zone_id'     => 8,
                'path_order'  => 1,
            ]);

            factory(Device::class)->create([
                'name'        => 'جهاز وزن خروج 2 Inbio',
                'description' => null,
                'serial'      => 16,
                'type'        => 'rfid',
                'ip'          => '192.168.1.208',
                'direction'   => 'out',
                'duration'    => 3,
                'door_name'   => 'Exit_inb_Scale2',
                'zone_id'     => 8,
                'path_order'  => 1,
            ]);
        }
    }

    public function createScales()
    {
        if (!Scale::count()) {
            factory(Scale::class)->create([
                'name'        => 'ميزان دخول 1',
                'description' => null,
                'com_port'    => 3002,
                'baud_rate'   => null,
                'parity'      => null,
                'data_bits'   => null,
                'stop_bits'   => null,
                'start_read'  => null,
                'end_read'    => null,
                'service_url' => null,
                'ip'          => '192.168.1.250',
                'zone_id'     => 4,
                'path_order'  => 2,
            ]);

            factory(Scale::class)->create([
                'name'        => 'ميزان دخول 2',
                'description' => null,
                'com_port'    => 3002,
                'baud_rate'   => null,
                'parity'      => null,
                'data_bits'   => null,
                'stop_bits'   => null,
                'start_read'  => null,
                'end_read'    => null,
                'service_url' => null,
                'ip'          => '192.168.1.243',
                'zone_id'     => 5,
                'path_order'  => 2,
            ]);

            factory(Scale::class)->create([
                'name'        => 'ميزان دخول 3',
                'description' => null,
                'com_port'    => 3002,
                'baud_rate'   => null,
                'parity'      => null,
                'data_bits'   => null,
                'stop_bits'   => null,
                'start_read'  => null,
                'end_read'    => null,
                'service_url' => null,
                'ip'          => '192.168.1.241',
                'zone_id'     => 6,
                'path_order'  => 2,
            ]);

            factory(Scale::class)->create([
                'name'        => 'ميزان خروج 1',
                'description' => null,
                'com_port'    => 3002,
                'baud_rate'   => null,
                'parity'      => null,
                'data_bits'   => null,
                'stop_bits'   => null,
                'start_read'  => null,
                'end_read'    => null,
                'service_url' => null,
                'ip'          => '192.168.1.239',
                'zone_id'     => 7,
                'path_order'  => 2,
            ]);

            factory(Scale::class)->create([
                'name'        => 'ميزان خروج 2',
                'description' => null,
                'com_port'    => 3002,
                'baud_rate'   => null,
                'parity'      => null,
                'data_bits'   => null,
                'stop_bits'   => null,
                'start_read'  => null,
                'end_read'    => null,
                'service_url' => null,
                'ip'          => '192.168.1.241',
                'zone_id'     => 8,
                'path_order'  => 2,
            ]);
        }
    }
}
