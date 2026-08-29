<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModeloBomba extends Model
{
    public $timestamps = false;

    protected $table = 'modelos_bombas';

    protected $fillable = ['fabricante', 'modelo', 'descricao'];

    public function bombas(): HasMany
    {
        return $this->hasMany(BombaLeite::class, 'id_modelo');
    }
}
