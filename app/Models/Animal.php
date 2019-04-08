<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Conta
 * @package App\Models
 */
class Animal extends Model
{
    /**
     * Campos que não serao exibidos
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'raca_id', 'proprietario_id'];
    
    /**
     * Campos que podem ser preenchidos
     * @var array
     */
    protected $fillable = [
        'id',
        'nome',
        'porte',
        'raca_id',
        'proprietario_id',
    ];

    /**
     * @var string
     */
    protected $table = 'animal';

    /**
     * Relacionamento que virá com a classe ao ser instanciada.
     *
     * @var array
     */
    protected $with = ['raca', 'proprietario'];
    
    
    /**
     * Retorna o relacionamento (JOIN) com a tabela pessoa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function raca()
    {
        return $this->belongsTo(Raca::class)->whereNull('deleted_at');
    }

    /**
     * Retorna o relacionamento (JOIN) com a tabela pessoa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proprietario()
    {
        return $this->belongsTo(Proprietario::class)->whereNull('deleted_at');
    }
}
