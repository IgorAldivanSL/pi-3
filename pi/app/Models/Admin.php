<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios_adm';

    protected $fillable = [
        'adm_nome',
        'adm_email',
        'password',
        'ativo',
    ];

    protected $hidden = [
        'password',
    ];

    // Campo usado no login
    public function username()
    {
        return 'adm_email';
    }

    // Campo onde está a senha
    public function getAuthPassword()
    {
        return $this->password;
    }
}
