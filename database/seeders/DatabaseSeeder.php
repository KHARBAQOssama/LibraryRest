<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        $roles = Role::factory()->count(3)->create();
        $permissions = Permission::factory()->count(12)->create();
        $users = User::factory()->count(10)->create();
        

        $adminPermissions = [
            'changeRoles', 'changePermissions', 'updateBooks', 'deleteBooks',
            'addGender', 'updateGender', 'deleteGender', 'blockUser', 'deleteComment'
        ];
        $receptionistPermissions = [
            'addBooks', 'updateBooks', 'deleteBooks',
            'addGender', 'updateGender', 'deleteGender', 'deleteComment', 'addComment', 'updateComment'
        ];
        $clientPermissions = [
            'addComment', 'deleteComment', 'updateComment'
        ];
    
        // Assign permissions to the admin role
        foreach ($adminPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->firstOrFail();
            $role = Role::where('name', 'Admin')->firstOrFail();
            $role->permissions()->attach($permission);
        }
    
        // Assign permissions to the receptionist role
        foreach ($receptionistPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->firstOrFail();
            $role = Role::where('name', 'Receptionist')->firstOrFail();
            $role->permissions()->attach($permission);
        }
    
        // Assign permissions to the client role
        foreach ($clientPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->firstOrFail();
            $role = Role::where('name', 'Client')->firstOrFail();
            $role->permissions()->attach($permission);
        }

        
        // \App\Models\User::factory()->create([
        //     'first_name' => 'Test',
        //     'last_name' => 'Test',
        //     'email' => 'test@example.com',
        //     'password' => 'Test'
        // ]);
    }
}
