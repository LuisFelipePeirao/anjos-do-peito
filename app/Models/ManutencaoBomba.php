<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManutencaoBomba extends Model
{
    public $timestamps = false;

    protected $table = 'manutencoes_bombas';

    protected $fillable = ['id_bomba', 'id_usuario', 'data_inicio', 'data_fim', 'tipo', 'descricao', 'situacao', 'observacao'];

    protected function casts(): array
    {
        return [
            'data_inicio' => 'datetime',
            'data_fim' => 'datetime',
        ];
    }

    public function bomba(): BelongsTo
    {
        return $this->belongsTo(BombaLeite::class, 'id_bomba');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
