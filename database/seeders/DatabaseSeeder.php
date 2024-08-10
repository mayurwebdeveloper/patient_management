<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // Step 1: Create a user
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'status' => 1,
        ]);

        // Step 2: Create a role
        $role = Role::create(['name' => 'admin']);

        // Step 3: Grant all permissions to the role
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        // Step 4: Assign the role to the user
        $user->assignRole($role);

    }
}
