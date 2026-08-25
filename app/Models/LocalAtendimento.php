<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LocalAtendimento extends Model
{
    protected $table = 'locais_atendimento';

    protected $fillable = [
        'nome',
        'id_endereco',
        'descricao',
    ];

    public function endereco(): BelongsTo
    {
        return $this->belongsTo(Endereco::class, 'id_endereco');
    }

    public function atendimentos(): HasMany
    {
        return $this->hasMany(Atendimento::class, 'id_local');
    }
}
