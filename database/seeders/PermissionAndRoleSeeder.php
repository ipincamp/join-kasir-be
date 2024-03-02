<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // roles
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $owner = Role::create(['name' => 'owner', 'guard_name' => 'api']);
        $head = Role::create(['name' => 'head', 'guard_name' => 'api']);
        $cashier = Role::create(['name' => 'cashier', 'guard_name' => 'api']);

        // user permissions
        Permission::create(['name' => 'add-user', 'guard_name' => 'api']); // create new user
        Permission::create(['name' => 'get-user', 'guard_name' => 'api']); // get user detail
        Permission::create(['name' => 'get-all-user', 'guard_name' => 'api']); // get all user
        Permission::create(['name' => 'update-user', 'guard_name' => 'api']); // update user detail by self
        Permission::create(['name' => 'change-user', 'guard_name' => 'api']); // change user role by admin
        Permission::create(['name' => 'delete-user', 'guard_name' => 'api']); // delete user

        Permission::create(['name' => 'add-shop', 'guard_name' => 'api']); // create new shop
        Permission::create(['name' => 'get-shop', 'guard_name' => 'api']); // get shop detail
        Permission::create(['name' => 'get-all-shop', 'guard_name' => 'api']); // get all shop
        Permission::create(['name' => 'update-shop', 'guard_name' => 'api']); // update shop detail by self
        Permission::create(['name' => 'change-shop', 'guard_name' => 'api']); // change shop detail by owner
        Permission::create(['name' => 'delete-shop', 'guard_name' => 'api']); // delete shop

        Permission::create(['name' => 'get-shop-setting', 'guard_name' => 'api']); // get shop setting detail
        Permission::create(['name' => 'update-shop-setting', 'guard_name' => 'api']); // update shop setting detail by owner

        // asign permissions to roles
        $admin->givePermissionTo(Permission::all());
        $owner->givePermissionTo([
            'add-shop',
            'get-shop',
            'update-shop',
            'get-shop-setting',
            'update-shop-setting',
        ]);
        $head->givePermissionTo('get-shop');
        $cashier->givePermissionTo('get-shop');
    }
}
