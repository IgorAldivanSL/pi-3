<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios_adm', function (Blueprint $table) {
            $table->id();
            $table->string('adm_nome');
            $table->string('adm_telefone');
            $table->string('adm_cpf')->unique();
            $table->string('adm_email')->unique();
            $table->string('adm_senha');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios_adm');
    }
};
