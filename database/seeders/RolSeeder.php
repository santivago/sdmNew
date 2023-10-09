<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Client']);

        Permission::create (['name' => 'admin.home'])->syncRoles([$role1, $role2]);
        Permission::create (['name' => 'admin.clients.index'])->syncRoles([$role1, $role2]);
        Permission::create (['name' => 'admin.clients.create'])->syncRoles([$role1, $role2]);
        Permission::create (['name' => 'admin.clients.edit'])->syncRoles([$role1, $role2]);
        Permission::create (['name' => 'admin.clients.destroy'])->syncRoles([$role1, $role2]);
        Permission::create (['name' => 'admin.clients.booking'])->syncRoles([$role1, $role2]);

        Permission::create (['name' => 'admin.booking.index'])->syncRoles([$role1, $role2]);
        Permission::create (['name' => 'admin.booking.destroy'])->syncRoles([$role1, $role2]);
        
        Permission::create (['name' => 'Dashboard'])->syncRoles([$role1, $role2]);


    }
}
