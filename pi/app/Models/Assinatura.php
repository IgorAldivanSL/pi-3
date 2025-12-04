<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    protected $table = 'assinaturas';

        protected $fillable = [
        'cliente_id',
        'produto_id',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'cartao_final',
        'valor_assinatura',
        'tipo',
        'status',
        'data_inicio',
    ];


    // Assinatura pertence a um cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Assinatura pertence a um produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
