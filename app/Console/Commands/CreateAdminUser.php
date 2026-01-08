<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create 
                            {--email=admin@agendaonline.com : Email do administrador}
                            {--password=admin123 : Senha do administrador}
                            {--name=Administrador : Nome do administrador}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria o usuário administrador padrão do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Criando usuário administrador...');

        // Criar permissões se não existirem
        $this->createPermissions();

        // Criar role admin se não existir
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');

        // Verificar se já existe
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            $this->warn("⚠️  Usuário com email {$email} já existe!");
            
            if ($this->confirm('Deseja atualizar a senha deste usuário?', true)) {
                $existingUser->update([
                    'password' => Hash::make($password),
                    'is_active' => true,
                ]);
                
                if (!$existingUser->hasRole('admin')) {
                    $existingUser->assignRole('admin');
                }
                
                $this->info("✅ Senha atualizada com sucesso!");
            }
            
            return 0;
        }

        // Criar novo usuário
        $admin = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $admin->assignRole('admin');

        $this->newLine();
        $this->info('✅ Administrador criado com sucesso!');
        $this->newLine();
        $this->table(
            ['Campo', 'Valor'],
            [
                ['Nome', $name],
                ['E-mail', $email],
                ['Senha', $password],
            ]
        );
        $this->newLine();
        $this->warn('⚠️  Altere a senha padrão após o primeiro login!');

        return 0;
    }

    /**
     * Criar permissões do sistema
     */
    private function createPermissions(): void
    {
        $permissions = [
            'admins.view', 'admins.create', 'admins.edit', 'admins.delete',
            'schedules.view', 'schedules.create', 'schedules.edit', 'schedules.delete', 'schedules.view_all',
            'services.view', 'services.create', 'services.edit', 'services.delete',
            'clients.view', 'clients.create', 'clients.edit', 'clients.delete',
            'financial.view', 'financial.create', 'financial.edit', 'financial.delete', 'financial.reports',
            'settings.view', 'settings.edit',
            'api.access', 'api.manage_tokens',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
