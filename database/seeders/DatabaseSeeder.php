<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Status;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles          = Role::factory()->count(3)->create();
        $roles          = Status::factory()->count(3)->create();
        $permissions    = Permission::factory()->count(7)->create();
        $users          = User::factory()->count(10)->create();
        

        $adminPermissions = [
            'changePermissions', 
            'updateBooks', 
            'deleteBooks',
            'addGender', 
            'updateGender', 
            'deleteGender', 
        ];
        $receptionistPermissions = [
            'addBooks', 
            'updateBooks', 
            'deleteBooks',
            'addGender', 
            'updateGender', 
            'deleteGender', 
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

        $admin              = new User();
        $admin->first_name  = 'John';
        $admin->last_name   = 'Doe';
        $admin->email       = 'admin@admin.com';
        $admin->password    = Hash::make('admin123');
        $admin->role_id     = 3;
        $admin->save();
    }
}
