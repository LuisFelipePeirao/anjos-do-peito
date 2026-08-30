<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Crianca extends Model
{
    protected $table = 'criancas';

    protected $fillable = ['nome', 'data_nascimento', 'sexo', 'id_beneficiaria'];

    protected function casts(): array
    {
        return ['data_nascimento' => 'date'];
    }

    public function beneficiaria(): BelongsTo
    {
        return $this->belongsTo(Beneficiaria::class, 'id_beneficiaria');
    }
}
