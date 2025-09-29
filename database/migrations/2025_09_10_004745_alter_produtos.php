<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            if (!Schema::hasColumn('produtos', 'solucao')) {
                $table->string('solucao', 150);
            }
        });
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            if (Schema::hasColumn('produtos', 'solucao')) $table->dropColumn('solucao');
            // não removo email/timestamps por serem padrão do auth em muitos projetos
        });
    }
};
