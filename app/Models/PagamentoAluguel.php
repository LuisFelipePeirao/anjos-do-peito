<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PagamentoAluguel extends Model
{
    public $timestamps = false;

    protected $table = 'pagamentos_alugueis';

    protected $fillable = ['id_cessao', 'competencia', 'valor', 'data_vencimento', 'data_pagamento', 'situacao', 'observacao'];

    protected function casts(): array
    {
        return [
            'competencia' => 'date',
            'data_vencimento' => 'date',
            'data_pagamento' => 'date',
            'valor' => 'decimal:2',
        ];
    }

    public function cessao(): BelongsTo
    {
        return $this->belongsTo(CessaoBomba::class, 'id_cessao');
    }
}
