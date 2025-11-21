<?php declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class PermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->createPermissionsPermissions();
        $this->createRolePermissions();
        $this->createCalendarPermissions();
    }

    private function createRolePermissions(): void
    {
        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'create_role',
            'description' => 'Allows to create roles',
        ]);

        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'edit_role',
            'description' => 'Allows to edit roles',
        ]);

        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'delete_role',
            'description' => 'Allows to delete roles',
        ]);

        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'view_role',
            'description' => 'Allows to view roles',
        ]);

        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'assign_role',
            'description' => 'Allows to assign role to user',
        ]);
    }

    private function createPermissionsPermissions(): void
    {
        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'create_permission',
            'description' => 'Allows to create permissions',
        ]);

        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'edit_permission',
            'description' => 'Allows to edit permissions',
        ]);

        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'delete_permission',
            'description' => 'Allows to delete permissions',
        ]);

        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'view_permission',
            'description' => 'Allows to view permissions',
        ]);

        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'assign_permission',
            'description' => 'Allows to assign permission to role',
        ]);
    }

    private function createCalendarPermissions(): void
    {
        DB::table('permissions')->insertOrIgnore([
            'perm_name' => 'edit_calendar_settings',
            'description' => 'Allows to view and modify calendar settings',
        ]);
    }
}
