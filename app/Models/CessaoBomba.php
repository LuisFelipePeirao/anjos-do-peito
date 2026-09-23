<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CessaoBomba extends Model
{
    public $timestamps = false;

    protected $table = 'cessoes_bombas';

    protected $fillable = [
        'id_bomba',
        'id_beneficiaria',
        'id_usuario_retirada',
        'id_usuario_devolucao',
        'tipo',
        'valor_mensalidade',
        'dia_vencimento',
        'forma_cobranca',
        'primeira_cobranca_em',
        'proxima_cobranca_em',
        'data_retirada',
        'data_prevista_devolucao',
        'data_devolucao',
        'situacao',
        'observacao_retirada',
        'observacao_devolucao',
    ];

    protected function casts(): array
    {
        return [
            'data_retirada' => 'datetime',
            'data_prevista_devolucao' => 'date',
            'data_devolucao' => 'datetime',
            'valor_mensalidade' => 'decimal:2',
            'primeira_cobranca_em' => 'date',
            'proxima_cobranca_em' => 'date',
        ];
    }

    public function bomba(): BelongsTo
    {
        return $this->belongsTo(BombaLeite::class, 'id_bomba');
    }

    public function beneficiaria(): BelongsTo
    {
        return $this->belongsTo(Beneficiaria::class, 'id_beneficiaria');
    }

    public function usuarioRetirada(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_retirada');
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(PagamentoAluguel::class, 'id_cessao');
    }
}
