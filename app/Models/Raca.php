<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Conta
 * @package App\Models
 */
class Raca extends Model
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
    ];

    /**
     * @var string
     */
    protected $table = 'raca';
}
