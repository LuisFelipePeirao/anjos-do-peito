<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DoacaoItem extends Model
{
    public $timestamps = false;

    protected $table = 'doacoes_itens';

    protected $fillable = ['id_doacao', 'id_material', 'quantidade', 'observacao'];

    public function doacao(): BelongsTo
    {
        return $this->belongsTo(Doacao::class, 'id_doacao');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'id_material');
    }

    public function movimentacao(): HasOne
    {
        return $this->hasOne(EstoqueMovimentacao::class, 'id_doacao_item');
    }
}
