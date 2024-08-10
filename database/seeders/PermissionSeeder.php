<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::query()->delete();

        Permission::create(['name' => 'view profile']);
        Permission::create(['name' => 'edit profile']);
        Permission::create(['name' => 'view settings']);
        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'view enquiries']);
        Permission::create(['name' => 'delete enquiry']);
        Permission::create(['name' => 'mark enquiry']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'add user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'add permission']);
        Permission::create(['name' => 'edit permission']);
        Permission::create(['name' => 'delete permission']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'add role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'assign role-permissions']);

        Permission::create(['name' => 'view hospitals']);
        Permission::create(['name' => 'add hospital']);
        Permission::create(['name' => 'edit hospital']);
        Permission::create(['name' => 'delete hospital']);

        Permission::create(['name' => 'view pm-jay-resources']);
        Permission::create(['name' => 'add pm-jay-resource']);
        Permission::create(['name' => 'edit pm-jay-resource']);
        Permission::create(['name' => 'delete pm-jay-resource']);

        Permission::create(['name' => 'view sliders']);
        Permission::create(['name' => 'add slider']);
        Permission::create(['name' => 'edit slider']);
        Permission::create(['name' => 'delete slider']);

        Permission::create(['name' => 'view specialities']);
        Permission::create(['name' => 'add speciality']);
        Permission::create(['name' => 'edit speciality']);
        Permission::create(['name' => 'delete speciality']);

        Permission::create(['name' => 'view front-setting']);
        Permission::create(['name' => 'edit front-setting']);

    }
}
