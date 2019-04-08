<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Conta
 * @package App\Models
 */
class Conta extends Model
{
    const CONTA_ATIVA = 1;
    const CONTA_INATIVA = 0;

    const CONTA_TIPO_POUPANCA = 1;
    const CONTA_TIPO_POUPANCA_TEXTO = 'CONTA POUPANÇA';
    const CONTA_TIPO_CORRENTE = 2;
    const CONTA_TIPO_CORRENTE_TEXTO = 'CONTA CORRENTE';
    const CONTA_TIPO_SALARIO = 3;
    const CONTA_TIPO_SALARIO_TEXTO = 'CONTA SALARIO';


    /**
     * Nome da chave primaria da tabela
     * @var string
     */
    protected $primaryKey = 'id_conta';
    
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
        'id_conta',
        'id_pessoa',
        'saldo',
        'limite_saque_diario',
        'flag_ativo',
        'tipo_conta',
        'data_criacao',
    ];

    /**
     * Relacionamento que virá com a classe ao ser instanciada.
     *
     * @var array
     */
    protected $with = ['titular'];
    
    
    /**
     * Retorna o relacionamento (JOIN) com a tabela pessoa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function titular()
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa')->whereNull('deleted_at');
    }


    /**
     * Mecanismo fornecido pelo framework para tratar o resultado da propriedade da classe.
     *
     * @param $value
     * @return string
     */
    public function getTipoContaAttribute($value)
    {
        $tipoConta = $value;

        if (array_key_exists($tipoConta, $tipoContas = $this->getTipoContas())) {
            $tipoConta = $tipoContas[$tipoConta];
        }

        return $tipoConta;
    }


    /**
     * Retornando todas as constantes relativas ao tipo da conta em um array.
     *
     * @return array
     */
    public static function getTipoContas()
    {
        return [
            static::CONTA_TIPO_POUPANCA => static::CONTA_TIPO_POUPANCA_TEXTO,
            static::CONTA_TIPO_CORRENTE => static::CONTA_TIPO_CORRENTE_TEXTO,
            static::CONTA_TIPO_SALARIO  => static::CONTA_TIPO_SALARIO_TEXTO,
        ];
    }
}
