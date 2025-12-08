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
            'identifier' => 'vacation',
            'description' => 'Employee vacation',
            'background_color' => '#838C74',
            'text_color' => '#F2D194',
        ]);

        DB::table('event_types')->insertOrIgnore([
            'identifier' => 'holiday',
            'description' => 'Public holiday',
            'background_color' => '#ff0000',
            'text_color' => '#F2D194',
        ]);
    }
}
