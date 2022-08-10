<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

//truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
DB::table('roles')->truncate();
DB::table('permissions')->truncate();
DB::table('model_has_permissions')->truncate();
DB::table('model_has_roles')->truncate();
DB::table('role_has_permissions')->truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
// create permissions
Permission::create(['name' => 'owner', 'guard_name' => 'admin']);
Permission::create(['name' => 'branch-manager', 'guard_name' => 'admin']);
Permission::create(['name' => 'data-entry-operator', 'guard_name' => 'admin']);

// create roles and assign created permissions

// this can be done as separate statements
$role = Role::create([
    'name' => 'owner',
    'guard_name' => 'admin',
]);

$role->givePermissionTo(Permission::all());

$role = Role::create([
    'name' => 'branch-manager',
    'guard_name' => 'admin',
]);

$role->givePermissionTo('branch-manager');

$role = Role::create([
    'name' => 'data-entry-operator',
    'guard_name' => 'admin',
]);

$role->givePermissionTo('data-entry-operator');
    }
}
