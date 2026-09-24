<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Procedimento extends Model
{
    protected $table = 'procedimentos';

    protected $fillable = ['nome', 'descricao', 'ativo'];

    protected function casts(): array
    {
        return ['ativo' => 'boolean'];
    }

    public function atendimentos(): HasMany
    {
        return $this->hasMany(Atendimento::class, 'id_procedimento');
    }
}
