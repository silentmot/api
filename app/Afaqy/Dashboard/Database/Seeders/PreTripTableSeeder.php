<?php

namespace Afaqy\Dashboard\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Afaqy\TripWorkflow\Models\Trip;
use Afaqy\TripWorkflow\Models\PreTrip;
use Afaqy\TripWorkflow\Models\PostTrip;
use Illuminate\Database\Eloquent\Model;

class PreTripTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (!PreTrip::count()) {
            $logs = $this->logsGenerator();

            foreach ($logs->chunk(1000) as $chunk) {
                PreTrip::insert($chunk->toArray());
            }

            $post_log = $this->postLogsGenerator($logs);

            foreach ($post_log->chunk(1000) as $chunk) {
                PostTrip::insert($chunk->toArray());
            }
        }
    }

    public function logsGenerator()
    {
        $trips = Trip::select(['id', 'plate_number', 'start_time'])->where('trip_unit_type', 'contract')->orderBy('id')->get();
        $logs  = [];

        foreach ($trips as $key => $trip) {
            $time = Carbon::parse($trip->start_time);
            $pick = rand(90, 100);

            $logs[] = [
                'trip_id'          => $trip->id,
                'shift_id'         => $key + 1,
                'plate_number'     => $trip->plate_number,
                'depart_time'      => $time->copy()->subHours(3)->getTimestamp(),
                'depart_location'  => Arr::random(['Al-Murjan', 'Al-Basateen', 'Al-Mohamadiya', 'Ash-Shati', 'An-Nahda']),
                'route_id'         => rand(1, 100),
                'trip_start_time'  => $time->copy()->subHours(2)->getTimestamp(),
                'total_containers' => 100,
                'total_pick'       => $pick,
                'total_missing'    => 100 - $pick,
                'trip_end_time'    => $time->copy()->subMinutes(15)->getTimestamp(),
                'total_trip_time'  => rand(0, 1) . ':' . rand(30, 59) . ':' . rand(1, 59),
            ];
        }

        // Storage::disk('local')->put('file.txt', var_export($logs, true));

        return collect($logs);
    }

    public function postLogsGenerator($logs)
    {
        $post_logs = [];

        foreach ($logs as $key => $log) {
            $post_logs[] = [
                'plate_number'     => $log['plate_number'],
                'shift_id'         => $log['shift_id'],
                'arrival_time'     => Carbon::parse($log['trip_end_time'])->addHours(2)->getTimestamp(),
                'arrival_location' => $log['depart_location'],
            ];
        }

        return collect($post_logs);
    }
}
