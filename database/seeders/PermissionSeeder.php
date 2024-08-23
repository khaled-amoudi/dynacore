<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->delete();



        $resources = ['category', 'post', 'item', 'user'];
        $crud_permissions = ['index-list', 'create', 'store', 'edit', 'update', 'show', 'destroy', 'force-delete', 'trash-list', 'restore'];


        foreach ($resources as $resource) {
            Permission::create([
                'name' => $resource,
                'group_name' => $resource,
                'guard_name' => 'web',
            ]);
            foreach ($crud_permissions as $crud_permission) {
                Permission::create([
                    'name' => $crud_permission . '-' . $resource,
                    'group_name' => $resource,
                    'guard_name' => 'web',
                ]);
            }
        }


        // Secret permissions
        $secret_resources = ['role'];
        $secret_permissions = ['index-list', 'create', 'store', 'edit', 'update', 'destroy', 'manage'];

        foreach ($secret_resources as $res) {
            Permission::create([
                'name' => $res,
                'group_name' => 'SECRET',
                'guard_name' => 'web',
            ]);
            foreach ($secret_permissions as $secret_permission) {
                Permission::create([
                    'name' => $secret_permission . '-' . $res,
                    'group_name' => 'SECRET',
                    'guard_name' => 'web',
                ]);
            }
        }

        $role = Role::where('name', 'admin')->first();
        // Ensure the role exists
        if ($role) {
            // Assign permissions to the role
            // $permissions = Permission::all();
            $permissions = Permission::whereIn('name', ['role', 'index-list-role', 'create-role', 'store-role', 'edit-role', 'update-role', 'destroy-role', 'manage-role'])->get();
            $role->syncPermissions($permissions);

            $this->command->info('Permissions have been assigned to the role successfully.');
        } else {
            $this->command->error('Role not found.');
        }



        // General permissions
        $general_permissions = ['trash', 'settings'];
        foreach ($general_permissions as $per) {
            Permission::create([
                'name' => $per,
                'group_name' => 'GENERAL',
                'guard_name' => 'web',
            ]);
        }
    }
}
