<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $org1 = Organization::create(['name' => 'Acme Corp']);

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'status' => true,
                'is_admin' => true,
                'password' => bcrypt('password'),
                'organization_id' => $org1->id,

            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'status' => true,
                'is_admin' => false,
                'password' => bcrypt('password'),
                'organization_id' => $org1->id

            ],
            [
                'name' => 'Guest',
                'email' => 'guest@gmail.com',
                'status' => true,
                'is_admin' => false,
                'password' => bcrypt('password'),
                'organization_id' => $org1->id

            ]
        ];


        $roles = [
            ['name' => 'admin', 'display_name' => 'Admin', 'userId' => 1],
            ['name' => 'user', 'display_name' => 'User', 'userId' => 1],
            ['name' => 'guest', 'display_name' => 'Guest', 'userId' => 1]
        ];


        $permissions = [

            // Role Permissions
            ['display_name' => 'Read Role', 'name' => 'read_role', 'userId' => 1],
            ['display_name' => 'Add Role', 'name' => 'add_role', 'userId' => 1],
            ['display_name' => 'Edit Role', 'name' => 'edit_role', 'userId' => 1],
            ['display_name' => 'Delete Role', 'name' => 'delete_role', 'userId' => 1],
            // User Permissions
            ['display_name' => 'Read User', 'name' => 'read_user', 'userId' => 1],
            ['display_name' => 'Add User', 'name' => 'add_user', 'userId' => 1],
            ['display_name' => 'Edit User', 'name' => 'edit_user', 'userId' => 1],
            ['display_name' => 'Delete User', 'name' => 'delete_user', 'userId' => 1],
            // Permission Permissions
            ['display_name' => 'Read Permission', 'name' => 'read_permission', 'userId' => 1],
            ['display_name' => 'Add Permission', 'name' => 'add_permission', 'userId' => 1],
            ['display_name' => 'Edit Permission', 'name' => 'edit_permission', 'userId' => 1],
            ['display_name' => 'Delete Permission', 'name' => 'delete_permission', 'userId' => 1],
        ];

        collect($users)->each(function ($user) {
            User::create($user);
        });

        collect($roles)->each(function ($role) {
            Role::create($role);
        });

        collect($permissions)->each(function ($permission) {
            Permission::create($permission);
        });

        // assign permissions to roles
        $role = Role::findByName('admin');
        $role->givePermissionTo(Permission::all());



        // assign roles to users
        $user = User::find(1);
        $user->assignRole('admin');

        $user = User::find(2);
        $user->assignRole('user');

        $user = User::find(3);
        $user->assignRole('guest');
    }
}
