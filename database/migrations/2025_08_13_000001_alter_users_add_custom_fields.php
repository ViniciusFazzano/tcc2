<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nome')) {
                $table->string('nome', 150)->after('id');
            }
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email', 150)->unique()->after('nome');
            } else {
                // garante tamanho/unique
                $table->string('email', 150)->change();
            }
            if (!Schema::hasColumn('users', 'senha')) {
                $table->string('senha', 255)->after('email');
            }
            if (!Schema::hasColumn('users', 'nivel_acesso')) {
                $table->enum('nivel_acesso', ['admin','veterinario','cliente','operador'])->default('cliente')->after('senha');
            }
            if (!Schema::hasColumn('users', 'ativo')) {
                $table->boolean('ativo')->default(true)->after('nivel_acesso');
            }
            if (!Schema::hasColumn('users', 'observacoes')) {
                $table->text('observacoes')->nullable()->after('ativo');
            }

            // garante timestamps
            if (!Schema::hasColumn('users', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'observacoes')) $table->dropColumn('observacoes');
            if (Schema::hasColumn('users', 'ativo'))        $table->dropColumn('ativo');
            if (Schema::hasColumn('users', 'nivel_acesso')) $table->dropColumn('nivel_acesso');
            if (Schema::hasColumn('users', 'senha'))        $table->dropColumn('senha');
            if (Schema::hasColumn('users', 'nome'))         $table->dropColumn('nome');
            // não removo email/timestamps por serem padrão do auth em muitos projetos
        });
    }
};
