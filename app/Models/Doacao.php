<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doacao extends Model
{
    public $timestamps = false;

    protected $table = 'doacoes';

    protected $fillable = ['id_doador', 'id_usuario', 'data_doacao', 'observacao', 'situacao'];

    protected function casts(): array
    {
        return ['data_doacao' => 'datetime'];
    }

    public function doador(): BelongsTo
    {
        return $this->belongsTo(Doador::class, 'id_doador');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function itens(): HasMany
    {
        return $this->hasMany(DoacaoItem::class, 'id_doacao');
    }
}
