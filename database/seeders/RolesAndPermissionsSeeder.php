<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles and assign created permissions
        $adminRole = \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
        $instructorRole = \Spatie\Permission\Models\Role::create(['name' => 'Instructor']);
        $studentRole = \Spatie\Permission\Models\Role::create(['name' => 'Student']);

        // Create Admin user
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        // Create Instructor user
        $instructor = \App\Models\User::factory()->create([
            'name' => 'Instructor User',
            'email' => 'instructor@example.com',
            'password' => bcrypt('password'),
        ]);
        $instructor->assignRole($instructorRole);

        // Create Student user
        $student = \App\Models\User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
        ]);
        $student->assignRole($studentRole);
    }
}
