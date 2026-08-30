<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Distribuicao extends Model
{
    public $timestamps = false;

    protected $table = 'distribuicoes';

    protected $fillable = ['id_beneficiaria', 'id_usuario', 'data_hora', 'situacao', 'observacao'];

    protected function casts(): array
    {
        return ['data_hora' => 'datetime'];
    }

    public function beneficiaria(): BelongsTo
    {
        return $this->belongsTo(Beneficiaria::class, 'id_beneficiaria');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function itens(): HasMany
    {
        return $this->hasMany(DistribuicaoItem::class, 'id_distribuicao');
    }
}
