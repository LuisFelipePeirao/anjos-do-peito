<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cep extends Model
{
    protected $table = 'cep';

    protected $fillable = ['cep', 'cidade', 'uf', 'bairro', 'logradouro'];
}
