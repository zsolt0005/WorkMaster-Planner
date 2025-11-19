<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class UserRoleSeeder extends Seeder
{
    use WithoutModelEvents;

    private static array $userToRolesMap = [
        'diCaprio' => ['HR manager', 'Employee'],
        'johnny_depp' => ['Employee'],
    ];

    public function run(): void
    {
        foreach (self::$userToRolesMap as $user => $roles) {
            foreach ($roles as $role) {
                DB::table('user_role')->insertOrIgnore([
                    'user_id' => DB::table('users')->where('username', $user)->first()->id,
                    'role_id' => DB::table('roles')->where('role_name', $role)->first()->id,
                ]);
            }
        }
    }
}
