<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstoqueMovimentacao extends Model
{
    public $timestamps = false;

    protected $table = 'estoque_movimentacoes';

    protected $fillable = [
        'id_material',
        'tipo',
        'quantidade',
        'data_hora',
        'id_usuario',
        'id_doacao_item',
        'id_distribuicao_item',
        'observacao',
    ];

    protected function casts(): array
    {
        return ['data_hora' => 'datetime'];
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'id_material');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function doacaoItem(): BelongsTo
    {
        return $this->belongsTo(DoacaoItem::class, 'id_doacao_item');
    }

    public function distribuicaoItem(): BelongsTo
    {
        return $this->belongsTo(DistribuicaoItem::class, 'id_distribuicao_item');
    }
}
