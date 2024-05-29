<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        $adminRole = Role::create(['name' => Role::ADMIN_ROLE]);
        $managerRole = Role::create(['name' => Role::MANAGER_ROLE]);
        $teamMemberRole = Role::create(['name' => Role::TEAM_MEMBER_ROLE]);

        $adminPermissions = Permission::ADMIN_PERMISSIONS;
        $managerPermissions = Permission::MANAGER_PERMISSIONS;
        $userPermissions = Permission::TEAM_MEMBER_PERMISSIONS;

        $this->createPermissionsAndAssignToRole($adminRole, $adminPermissions);
        $this->createPermissionsAndAssignToRole($managerRole, $managerPermissions);
        $this->createPermissionsAndAssignToRole($teamMemberRole, $userPermissions);
    }

    private function createPermissionsAndAssignToRole($role, $permissions)
    {
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);

            $role->givePermissionTo($permission);
        }
    }
}
