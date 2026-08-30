<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DistribuicaoItem extends Model
{
    public $timestamps = false;

    protected $table = 'distribuicoes_itens';

    protected $fillable = ['id_distribuicao', 'id_material', 'quantidade', 'observacao'];

    public function distribuicao(): BelongsTo
    {
        return $this->belongsTo(Distribuicao::class, 'id_distribuicao');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'id_material');
    }

    public function movimentacao(): HasOne
    {
        return $this->hasOne(EstoqueMovimentacao::class, 'id_distribuicao_item');
    }
}
