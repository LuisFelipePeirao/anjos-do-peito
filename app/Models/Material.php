<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    public $timestamps = false;

    protected $table = 'materiais';

    protected $fillable = ['nome', 'id_categoria', 'unidade_medida', 'estoque_minimo'];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaMaterial::class, 'id_categoria');
    }

    public function doacaoItens(): HasMany
    {
        return $this->hasMany(DoacaoItem::class, 'id_material');
    }

    public function distribuicaoItens(): HasMany
    {
        return $this->hasMany(DistribuicaoItem::class, 'id_material');
    }

    public function movimentacoes(): HasMany
    {
        return $this->hasMany(EstoqueMovimentacao::class, 'id_material');
    }
}
