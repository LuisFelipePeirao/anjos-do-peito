<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BombaLeite extends Model
{
    public $timestamps = false;

    protected $table = 'bomba_leite';

    protected $fillable = [
        'codigo',
        'id_modelo',
        'num_serie',
        'situacao',
        'data_aquisicao',
        'origem',
        'id_doador',
        'acessorios',
    ];

    protected function casts(): array
    {
        return ['data_aquisicao' => 'date'];
    }

    public function modelo(): BelongsTo
    {
        return $this->belongsTo(ModeloBomba::class, 'id_modelo');
    }

    public function doador(): BelongsTo
    {
        return $this->belongsTo(Doador::class, 'id_doador');
    }

    public function cessoes(): HasMany
    {
        return $this->hasMany(CessaoBomba::class, 'id_bomba');
    }

    public function manutencoes(): HasMany
    {
        return $this->hasMany(ManutencaoBomba::class, 'id_bomba');
    }
}
