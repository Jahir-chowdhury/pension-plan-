<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $role = Role::first();
        if (is_null($role)) {
            $s_admin = Role::create(['name' => 'Super Admin']);
            $admin = Role::create(['name' => 'Admin']);
            $operator = Role::create(['name' => 'Operator']);
            $claim_officer = Role::create(['name' => 'Claim Officer']);
            $investigation_admin = Role::create(['name' => 'Investigation  Admin']);
            $doctor = Role::create(['name' => 'Doctor']);
            $claim_hod = Role::create(['name' => 'Claim HOD']);
            $coo = Role::create(['name' => 'COO']);
            $ceo = Role::create(['name' => 'CEO']);
            $account_admin = Role::create(['name' => 'Account Admin']);
        }

        // Permission List as array
        // $all_permissions = [
        //     //admin dashboard permissions

        //     [
        //         'group_name' => 'user',
        //         'permissions' => ''
        //     ],

        // ];

        // // Create and Assign Permissions
        // foreach ($all_permissions as $group_permissions) {
        //     foreach ($group_permissions['permissions'] as $permission) {
        //         $permission = Permission::create([
        //             'name' => $permission,
        //             'group_name' => $group_permissions['group_name']
        //         ]);
        //         $s_admin->givePermissionTo($permission);
        //     }
        // }
    }
}
