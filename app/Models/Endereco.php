<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Endereco extends Model
{
    protected $table = 'enderecos';

    protected $fillable = ['id_cep', 'complemento', 'numero'];

    public function cep(): BelongsTo
    {
        return $this->belongsTo(Cep::class, 'id_cep');
    }

    public function locaisAtendimento(): HasMany
    {
        return $this->hasMany(LocalAtendimento::class, 'id_endereco');
    }
}
