<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::create(['name' => 'create-users']);
        // Permission::create(['name' => 'edit-users']);
        // Permission::create(['name' => 'delete-users']);

        // $adminRole = Role::create(['name' => 'Admin']);
        // $superadmin = Role::create(['name' => 'super-admin']);
        // $editorRole = Role::create(['name' => 'Property Manager'])
        
        $role = Role::where('name','super-admin')->first();

        $user = User::first();
        $user->assignRole($role);

        // $super_admin->givePermissionTo([
        //     'view-property',
        //     'create-property',
        //     'delete-property',
        //     'edit-property'
        // ]);
    }
}
