<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Conta
 * @package App\Models
 */
class Proprietario extends Model
{
    /**
     * Campos que não serao exibidos
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    /**
     * Campos que podem ser preenchidos
     * @var array
     */
    protected $fillable = [
        'id',
        'nome',
        'telefone',
        'email',
        'endereco',
        'numero',
        'cidade',
        'uf',
        'pais',
    ];

    /**
     * @var string
     */
    protected $table = 'proprietario';
}
