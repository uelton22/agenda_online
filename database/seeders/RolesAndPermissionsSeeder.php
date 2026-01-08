<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Admin management
            'admins.view',
            'admins.create',
            'admins.edit',
            'admins.delete',
            
            // Scheduling
            'schedules.view',
            'schedules.create',
            'schedules.edit',
            'schedules.delete',
            'schedules.view_all',
            
            // Services
            'services.view',
            'services.create',
            'services.edit',
            'services.delete',
            
            // Clients
            'clients.view',
            'clients.create',
            'clients.edit',
            'clients.delete',
            
            // Financial
            'financial.view',
            'financial.create',
            'financial.edit',
            'financial.delete',
            'financial.reports',
            
            // Settings
            'settings.view',
            'settings.edit',
            
            // API
            'api.access',
            'api.manage_tokens',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Admin Role - Full access (único role para administradores)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@agendaonline.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        $admin->assignRole('admin');
    }
}
