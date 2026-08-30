<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaMaterial extends Model
{
    public $timestamps = false;

    protected $table = 'categorias_materiais';

    protected $fillable = ['nome', 'ativo'];

    protected function casts(): array
    {
        return ['ativo' => 'boolean'];
    }

    public function materiais(): HasMany
    {
        return $this->hasMany(Material::class, 'id_categoria');
    }
}
