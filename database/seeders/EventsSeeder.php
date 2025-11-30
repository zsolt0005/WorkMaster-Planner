<?php declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class EventsSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $eventTypes = [
            'homeoffice',
            'meeting',
            'teambuilding',
            'vacation',
        ];

        $assignedUsers = [1, 3, 4];
        $events = [];

        for ($i = 1; $i <= 90; $i++) {
            $rand = rand(1, 100);
            if ($rand <= 40) {
                $eventType = 'homeoffice'; // 40%
            } elseif ($rand <= 70) {
                $eventType = 'meeting'; // 30%
            } elseif ($rand <= 90) {
                $eventType = 'teambuilding'; // 20%
            } else {
                $eventType = 'vacation'; // 10%
            }

            $start = Carbon::now()->subDays(rand(0, 30))->setTime(rand(8, 17), rand(0, 59), 0);
            $end = (clone $start)->addMinutes(rand(30, 180));

            $events[] = [
                'event_type_id' => $eventType,
                'assigned_user_id' => $assignedUsers[array_rand($assignedUsers)],
                'created_by_user_id' => '1',
                'title' => ucfirst($eventType).' Event '.$i,
                'description' => 'Generated event for testing',
                'start_date_time' => $start,
                'end_date_time' => $end,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('events')->insertOrIgnore($events);
    }
}
