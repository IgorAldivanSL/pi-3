<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;

    protected $table = 'clientes';

    protected $fillable = [
        'cli_nome',
        'cli_cpf',
        'cli_telefone',
        'cli_email',
        'cli_senha',
    ];

    protected $hidden = [
        'cli_senha',
    ];

    // DIZ AO LARAVEL QUAL CAMPO É A SENHA DE AUTENTICAÇÃO
    public function getAuthPassword()
    {
        return $this->cli_senha;
    }

    // DIZ AO LARAVEL QUE O LOGIN USA cli_email, NÃO email
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function assinaturas()
    {
        return $this->hasMany(\App\Models\Assinatura::class, 'cliente_id');
    }

}
