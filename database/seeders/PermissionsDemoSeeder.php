<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'api', 'name' => 'edit articles']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete articles']);
        Permission::create(['guard_name' => 'api', 'name' => 'publish articles']);
        Permission::create(['guard_name' => 'api', 'name' => 'unpublish articles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['guard_name' => 'api', 'name' => 'medico']);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['guard_name' => 'api', 'name' => 'cliente']);
        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['guard_name' => 'api', 'name' => 'admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'usu_names' => 'Veterinario Nombre',
            'usu_apes' => 'Ape1 Ape2',
            'usu_ci' => '0201000002',
            'usu_phone' => '0985726434',
            'usu_direc' => 'San Miguel de Bolivar',
            'usu_email' => 'veterinario@example.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'usu_names' => 'Cliente Nombre',
            'usu_apes' => 'Ape1 Ape2',
            'usu_ci' => '0201000001',
            'usu_phone' => '0985726434',
            'usu_direc' => 'San Miguel de Bolivar',
            'usu_email' => 'cliente@example.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'usu_names' => 'Alexander Paul',
            'usu_apes' => 'Luna Arteaga',
            'usu_ci' => '0202433918',
            'usu_phone' => '0985726434',
            'usu_direc' => 'San Miguel de Bolivar',
            'usu_email' => 'paulluna99@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole($role3);
    }
}
