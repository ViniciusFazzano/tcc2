<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Administrador',
            'nome' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('senha123'),
            'senha' => bcrypt('senha123'),
            'nivel_acesso' => 'admin',
            'ativo' => true,
            'observacoes' => 'Usuário administrador criado via seed'
        ]);

        $this->call([
            ClienteSeeder::class,
            FazendaSeeder::class,
            ProdutoSeeder::class,
            EmpresaBatedoraSeeder::class,
            PedidoSeeder::class,
        ]);
    }
}
