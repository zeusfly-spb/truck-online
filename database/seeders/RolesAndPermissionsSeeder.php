<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'delete orders']);
        Permission::create(['name' => 'publish orders']);
        Permission::create(['name' => 'unpublish orders']);


        // api Roles
        Role::create(['guard_name' => 'api','name' => 'driver']);
        Role::create(['guard_name' => 'api','name' => 'executer']);
        Role::create(['guard_name' => 'api','name' => 'super-admin']);

        // this can be done as separate statements
        $role = Role::create(['name' => 'manager']);
        $role->givePermissionTo('edit orders');

        // or may be done by chaining
        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['publish orders', 'unpublish orders']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
        //
    }
}
