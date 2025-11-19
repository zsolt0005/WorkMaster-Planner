<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            'username' => 'admin',
            'full_name' => 'Admin',
            'email' => 'admin@workmasterplanner.com',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'diCaprio',
            'full_name' => 'Leonardo DiCaprio',
            'email' => 'dicaprio@workmasterplanner.com',
            'password' => Hash::make('dicaprio123'),
            'is_admin' => false,
        ]);

        DB::table('users')->insertOrIgnore([
            'username' => 'johnny_depp',
            'full_name' => 'Johnny Depp',
            'email' => 'johnydepp@workmasterplanner.com',
            'password' => Hash::make('depp123'),
            'is_admin' => false,
        ]);
    }
}
