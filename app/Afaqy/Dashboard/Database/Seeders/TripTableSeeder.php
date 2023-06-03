<?php

namespace Afaqy\Dashboard\Database\Seeders;

use Carbon\Carbon;
use Afaqy\Zone\Models\Zone;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Afaqy\TripWorkflow\Models\Trip;
use Illuminate\Database\Eloquent\Model;

class TripTableSeeder extends Seeder
{
    public $units;

    public $zones;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (!Trip::count()) {
            $logs = $this->logsGenerator();

            foreach ($logs->chunk(1000) as $chunk) {
                Trip::insert($chunk->toArray());
            }
        }
    }

    public function logsGenerator()
    {
        $this->setLogComponents();

        $periods = $this->getPastTwoMonthsPeriodsByQuarterHour();

        $logs = [];

        $skip_randomly = Arr::random(range(1, $periods->count()), 1500);

        foreach ($periods as $key => $period) {
            if ($key == 0 || in_array($key, $skip_randomly)) {
                // to enter different unit count every hour
                continue;
            }

            $unit     = $this->units->random();
            $entrance = $this->zones->where('type', 'entrance')->random();
            $scale    = $this->zones->where('type', 'entranceScale')->random();
            $exit     = $this->zones->where('type', 'exit')->random();

            $scale_time      = $period->copy()->addMinutes(2)->getTimestamp();
            $exit_scale_time = $period->copy()->addMinutes(rand(15, 40))->getTimestamp();

            $year  = $period->format('Y');
            $month = $period->format('m');
            $week  = $period->week(null, Carbon::SATURDAY);

            if ($month == 12 && $week == 1) {
                $month = 1;
                $year++;
            }

            $logs[] = [
                'plate_number'                   => $unit->plate_number,
                'trip_unit_type'                 => $unit->type,
                'entrance_zone_id'               => $entrance->id,
                'entrance_device_ip'             => $entrance->device_ip,
                'start_time'                     => $period->getTimestamp(),
                'year'                           => $year,
                'month'                          => $month,
                'week'                           => $week,
                'entrance_scale_zone_id'         => ($key % 150) ? $scale->id : null,
                'entrance_scale_device_ip'       => ($key % 150) ? $scale->device_ip : null,
                'enterance_scale_ip'             => ($key % 150) ? $scale->scale_ip : null,
                'enterance_weight'               => ($key % 150) ? rand(1000, 5000) : null,
                'enterance_weight_time'          => ($key % 150) ? $scale_time : null,
                'open_enterance_scale_gate_time' => ($key % 150) ? $scale_time : null,
                'exit_scale_zone_id'             => ($key % 175) ? $exit->id : null,
                'exit_scale_device_ip'           => ($key % 175) ? $exit->device_ip : null,
                'exit_scale_ip'                  => ($key % 175) ? $exit->scale_ip : null,
                'exit_weight'                    => ($key % 175) ? rand(100, 1000) : null,
                'open_exit_scale_gate_time'      => ($key % 175) ? $exit_scale_time : null,
                'end_time'                       => ($key % 175) ? $exit_scale_time : null,
            ];
        }

        // Storage::disk('local')->put('file.txt', var_export($logs, true));

        return collect($logs);
    }

    public function setLogComponents()
    {
        $contract = DB::table('units')->select([
            'id',
            'plate_number',
            DB::raw('\'contract\' as type'),
        ])
            ->where('active', 1)
            ->whereNull('deleted_at');

        $this->units = DB::table('permit_units')->select([
            'id',
            'plate_number',
            DB::raw('\'permission\' as type'),
        ])
            ->union($contract)
            ->get()
            ->shuffle();

        $this->zones = Zone::withMachines()
            ->distinct()
            ->select([
                'zones.id',
                'zones.type',
                'devices.ip as device_ip',
                'scales.ip as scale_ip',
            ])
            ->get();
    }

    public function getPastTwoMonthsPeriodsByQuarterHour()
    {
        $now = Carbon::now();

        return Carbon::parse($now->copy()->subMonths(2))->minutesUntil($now, 5);
    }
}
