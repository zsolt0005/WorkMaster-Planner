<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class EventTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::table('event_types')->insertOrIgnore([
            'identifier' => 'holiday',
            'description' => 'Holiday',
            'background_color' => '#838C74',
            'text_color' => '#F2D194',
        ]);
        DB::table('event_types')->insertOrIgnore([
            'identifier' => 'homeoffice',
            'description' => 'Home Office',
            'background_color' => '#ff0000',
            'text_color' => '#000000',
        ]);
        DB::table('event_types')->insertOrIgnore([
            'identifier' => 'meeting',
            'description' => 'Meeting',
            'background_color' => '#fff700',
            'text_color' => '#ffffff',
        ]);
        DB::table('event_types')->insertOrIgnore([
            'identifier' => 'teambuilding',
            'description' => 'Team Building',
            'background_color' => '#78cd32',
            'text_color' => '#000000',
        ]);
        DB::table('event_types')->insertOrIgnore([
            'identifier' => 'vacation',
            'description' => 'Vacation',
            'background_color' => '##22c0c3',
            'text_color' => '#ffffff',
        ]);
    }
}
