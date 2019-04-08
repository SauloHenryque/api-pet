<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Middleware\GetUserFromToken;

/**
 * Class JwtAuthenticate
 * Classe responsavel por gerenciar a autenticacao do token JWT.
 * @package App\Http\Middleware
 */
class JwtAuthenticate extends GetUserFromToken
{
    /**
     * Fire event and return the response.
     *
     * Sobreescrevendo método a fim de personalizar a responsta das requisições.
     *
     * @param  string   $event
     * @param  string   $error
     * @param  int  $status
     * @param  array    $payload
     * @return mixed
     */
    protected function respond($event, $error, $status, $payload = [])
    {
        $response = $this->events->fire($event, $payload, true);
        $data = [
            'status' => $status,
            'data' => [],
            'fails' => $error,
        ];

        return $response ?: $this->response->json($data, $status);
    }
}
