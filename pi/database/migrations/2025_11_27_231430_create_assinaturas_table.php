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
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('produto_id');

            // Dados simulados de compra
            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado');
            $table->string('cep');

            // Dados do cartão (NÃO armazenar informações reais!)
            $table->string('cartao_final'); // Ex: **** 1234

            $table->string('status')->default('ativa');
            $table->timestamp('data_inicio')->nullable();

            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assinaturas');
    }
};
