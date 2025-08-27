<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->decimal('preco', 12, 2); // use DECIMAL no banco
            $table->integer('estoque');
            $table->string('ncm', 20); // ajuste para 8 dígitos se quiser
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->index(['nome']);
            $table->index(['ncm']);
            $table->index(['preco']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
