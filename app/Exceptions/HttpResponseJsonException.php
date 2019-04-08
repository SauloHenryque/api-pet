<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exception\HttpResponseException;

/**
 * @description Class HttpResponseJsonException
 *
 * Classe responsável por lançar uma exceção.
 * Herda da classe \Illuminate\Http\Exception\HttpResponseException
 * Retorna uma response no formato json.
 *
 * @package App\Exceptions
 */
class HttpResponseJsonException extends HttpResponseException
{

    /**
     * @param mixed $params
     */
    public function __construct($params)
    {
        $response = new JsonResponse($params, 403);
        parent::__construct($response);
    }

}
