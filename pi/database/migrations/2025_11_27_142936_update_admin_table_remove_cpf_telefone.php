<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite não permite dropar índice unique diretamente
        // Por isso, precisamos recriar a tabela temporária
        Schema::create('usuarios_adm_temp', function (Blueprint $table) {
            $table->id();
            $table->string('adm_nome');
            $table->string('adm_email')->unique();
            $table->string('adm_senha');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        // Copiar dados da tabela antiga para a nova (ignorando cpf e telefone)
        DB::table('usuarios_adm')->get()->each(function ($admin) {
            DB::table('usuarios_adm_temp')->insert([
                'id'        => $admin->id,
                'adm_nome'  => $admin->adm_nome,
                'adm_email' => $admin->adm_email,
                'adm_senha' => $admin->adm_senha,
                'ativo'     => $admin->ativo,
                'created_at'=> $admin->created_at,
                'updated_at'=> $admin->updated_at,
            ]);
        });

        // Remover tabela antiga
        Schema::drop('usuarios_adm');

        // Renomear nova tabela para o nome original
        Schema::rename('usuarios_adm_temp', 'usuarios_adm');
    }

    public function down(): void
    {
        // Reverter recriando as colunas removidas
        Schema::table('usuarios_adm', function(Blueprint $table){
            $table->string('adm_cpf')->nullable()->unique();
            $table->string('adm_telefone')->nullable();
        });
    }
};
