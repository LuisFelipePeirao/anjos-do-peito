<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doador extends Model
{
    public $timestamps = false;

    protected $table = 'doadores';

    protected $fillable = ['nome', 'telefone', 'email', 'observacao'];

    public function bombas(): HasMany
    {
        return $this->hasMany(BombaLeite::class, 'id_doador');
    }

    public function doacoes(): HasMany
    {
        return $this->hasMany(Doacao::class, 'id_doador');
    }
}
