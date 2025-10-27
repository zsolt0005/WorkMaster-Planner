<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'full_name' => 'Admin',
            'email' => 'admin@workmasterplanner.com',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);
    }
}
