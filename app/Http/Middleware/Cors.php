<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class Cors
 * Classe responsável por tratar Cross-Origin Resource Sharing (CORS)
 * @package App\Http\Middleware
 */
class Cors
{
    /**
     * Handle an incoming request.
     *
     * Recebe uma Request e um callback (Closure).
     *
     * Adiciona ao header da response acesso a endereços de outros
     * dominios acessarem a aplicação e tambem especifica quais
     * "verbos" HTTP a aplicação suporta.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
