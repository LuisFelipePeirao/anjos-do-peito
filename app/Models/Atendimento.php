<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Atendimento extends Model
{
    protected $table = 'atendimentos';

    protected $fillable = [
        'data_hora',
        'duracao_prevista',
        'modalidade',
        'id_local',
        'situacao',
        'rascunho',
        'id_beneficiaria',
        'id_crianca',
        'id_usuario',
    ];

    protected function casts(): array
    {
        return [
            'data_hora' => 'datetime',
            'rascunho' => 'boolean',
        ];
    }

    public function beneficiaria(): BelongsTo
    {
        return $this->belongsTo(Beneficiaria::class, 'id_beneficiaria');
    }

    public function local(): BelongsTo
    {
        return $this->belongsTo(LocalAtendimento::class, 'id_local');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function crianca(): BelongsTo
    {
        return $this->belongsTo(Crianca::class, 'id_crianca');
    }

    public function detalhe(): HasOne
    {
        return $this->hasOne(AtendimentoDetalhe::class, 'id_atendimento');
    }
}
