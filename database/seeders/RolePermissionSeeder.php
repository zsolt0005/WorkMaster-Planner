<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class RolePermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    private static array $roleToPermissionsMap = [
        'HR manager' => [
            'create_role',
            'edit_role',
            'view_role',
            'assign_role',
            'delete_role',
            'create_permission',
            'edit_permission',
            'view_permission',
            'assign_permission',
            'delete_permission',
            'edit_calendar_settings',
        ],
        'Employee' => [
            'edit_profile_data'
        ],
    ];

    public function run(): void
    {
        foreach (self::$roleToPermissionsMap as $role => $permissions) {
            foreach ($permissions as $permission) {
                DB::table('role_permission')->insertOrIgnore([
                    'role_id' => DB::table('roles')->where('role_name', $role)->first()->id,
                    'permission_id' => DB::table('permissions')->where('perm_name', $permission)->first()->id,
                ]);
            }
        }
    }
}
