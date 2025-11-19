<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::table('roles')->insertOrIgnore([
            'role_name' => 'HR manager',
            'description' => 'Human resource management',
        ]);

        DB::table('roles')->insertOrIgnore([
            'role_name' => 'Employee',
            'description' => 'Employee role',
        ]);
    }
}
