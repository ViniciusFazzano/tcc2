<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::create('batida_homeopaticas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');

            // Dados de entrada
            $table->decimal('qnt_saco', 8, 2);
            $table->decimal('kilo_batida', 8, 2);
            $table->decimal('kilo_saco', 8, 2);
            $table->decimal('qnt_cabeca', 8, 2);
            $table->decimal('consumo_cabeca', 8, 2);
            $table->decimal('grama_homeopatia_cabeca', 8, 2);
            $table->decimal('gramas_homeopatia_caixa', 8, 2);

            // Resultados
            $table->decimal('peso_total', 10, 2);
            $table->integer('qnt_batida');
            $table->decimal('consumo_cabeca_kilo', 10, 3);
            $table->decimal('cabeca_saco', 10, 2);
            $table->decimal('gramas_homeopatia_saco', 10, 2);
            $table->decimal('kilo_homeopatia_batida', 10, 3);
            $table->decimal('qnt_caixa', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batida_homeopaticas');
    }
};
