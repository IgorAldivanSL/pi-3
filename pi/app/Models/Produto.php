<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'imagem',
        'categoria',
        'peso',
        'tipo_torra'
    ];

    public function assinaturas()
    {
        return $this->hasMany(Assinatura::class);
    }

}
