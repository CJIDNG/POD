<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\Constants\Roles\DefaultRolesAndPermissions;

class PermissionsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // create roles
    collect(DefaultRolesAndPermissions::roles())->each(function ($role) {
      Role::create(['name' => $role]);
    });

    // create permissions
    collect(DefaultRolesAndPermissions::permissions())->each(function ($permission) {
      Permission::create(['name' => $permission]);
    });

    // sync permissions to roles
    $roles = Role::all();
    $rolesWithPermissions = DefaultRolesAndPermissions::rolesWithPermissions();

    foreach ($roles as $key => $role) {
      $role->syncPermissions($rolesWithPermissions[$role->name]);
    }

    $this->call(UsersTableSeeder::class);
  }
}
