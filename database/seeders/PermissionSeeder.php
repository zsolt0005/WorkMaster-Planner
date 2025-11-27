<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Permissions;
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
        $this->createUsersPermissions();
    }

    private function createRolePermissions(): void
    {
        $this->createPermission('create_role', 'Allows to create roles');
        $this->createPermission('edit_role', 'Allows to edit roles');
        $this->createPermission('delete_role', 'Allows to delete roles');
        $this->createPermission('view_role', 'Allows to view roles');
        $this->createPermission('assign_role', 'Allows to assign role to user');
    }

    private function createPermissionsPermissions(): void
    {
        $this->createPermission('create_permission', 'Allows to create permissions');
        $this->createPermission('edit_permission', 'Allows to edit permissions');
        $this->createPermission('delete_permission', 'Allows to delete permissions');
        $this->createPermission('view_permission', 'Allows to view permissions');
        $this->createPermission('assign_permission', 'Allows to assign permission to role');
    }

    private function createCalendarPermissions(): void
    {
        $this->createPermission(Permissions::EDIT_CALENDAR_SETTINGS, 'Allows to view and modify calendar settings');
        $this->createPermission(Permissions::CREATE_EVENT, 'Allows creating events');
        $this->createPermission(Permissions::CREATE_EVENT_FOR_OTHERS, 'Allows creating events for other users');
    }

    private function createUsersPermissions(): void
    {
        $this->createPermission('edit_profile_data', 'Allows user to edit profile information\'s');
    }

    private function createPermission(string $name, string $description): void
    {
        DB::table('permissions')->insertOrIgnore([
            'perm_name' => $name,
            'description' => $description,
        ]);
    }
}
