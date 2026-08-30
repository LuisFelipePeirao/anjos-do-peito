<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtendimentoDetalhe extends Model
{
    protected $table = 'atendimento_detalhes';

    protected $fillable = [
        'id_atendimento',
        'resumo',
        'objetivo',
        'queixa',
        'avaliacao',
        'conduta',
        'observacao',
    ];

    public function atendimento(): BelongsTo
    {
        return $this->belongsTo(Atendimento::class, 'id_atendimento');
    }
}
