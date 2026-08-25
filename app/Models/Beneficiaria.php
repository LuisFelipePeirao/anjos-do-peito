<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiaria extends Model
{
    protected $table = 'beneficiarias';

    protected $fillable = [
        'nome', 'cpf', 'email', 'telefone', 'telefone_alternativo', 'situacao', 'id_endereco', 'origem_cadastro',
    ];

    public function endereco(): BelongsTo
    {
        return $this->belongsTo(Endereco::class, 'id_endereco');
    }

    public function criancas(): HasMany
    {
        return $this->hasMany(Crianca::class, 'id_beneficiaria');
    }

    public function atendimentos(): HasMany
    {
        return $this->hasMany(Atendimento::class, 'id_beneficiaria');
    }
}
