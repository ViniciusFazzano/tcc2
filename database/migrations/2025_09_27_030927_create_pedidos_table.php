<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            // Relacionamentos
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('fazenda_id')->constrained('fazendas')->onDelete('cascade');

            // Campos do pedido
            $table->date('data');
            $table->decimal('valor_total', 12, 2);
            $table->text('observacoes')->nullable();

            $table->timestamps();

            // Índices úteis
            $table->index(['cliente_id']);
            $table->index(['fazenda_id']);
            $table->index(['data']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
