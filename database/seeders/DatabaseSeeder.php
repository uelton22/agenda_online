<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('✅ Seeder executado com sucesso!');
        $this->command->info('');
        $this->command->info('📧 Credenciais do Admin:');
        $this->command->info('   E-mail: admin@agendaonline.com');
        $this->command->info('   Senha:  admin123');
        $this->command->info('');
        $this->command->warn('⚠️  Altere a senha padrão após o primeiro login!');
    }
}
