<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

/**
 * Class OutputApi
 * Classe responsavel por formatar a responsta da requisição (API)
 * @package App\Http\Middleware
 */
class OutputApi
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->exists('json')) {
            $request->merge((array) json_decode($request->get('json'), 1));
        }
        
        $response = $next($request);
        
        if ($response instanceof Response) {
            $this->formatandoResponse($response);
        }
        
        if ($response instanceof JsonResponse) {
            $this->formatandoResponseJson($response);
        }
        
        return $response;
    }
    
    
    /**
     * Normaliza o conteúdo (corpo) da responsta para que seja retornado um json válido.
     *
     * @param Response $response
     */
    protected function formatandoResponse(Response $response)
    {
        $response->header('Content-Type', 'application/json');
        $content = $this->formatandoContent($response, $response->getOriginalContent());

        $response->setContent($content);
    }


    /**
     * Normaliza o conteúdo (corpo) da responsta para que seja retornado um json válido.
     *
     * @param JsonResponse $response
     */
    protected function formatandoResponseJson(JsonResponse $response)
    {
        $response->header('Content-Type', 'application/json');
        $content = $this->formatandoContent($response, $response->getContent());

        if (isset($content['data']) && is_string($content['data'])) {
            $content['data'] = json_decode($content['data'], 1);
        }

        if (isset($content['fails']) && is_string($content['fails'])) {
            $content['fails'] = json_decode($content['fails'], 1);
        }

        $response->setContent(json_encode($content));
    }
    
    
    /**
     * Formata o corpo da resposta.
     *
     * @param Response|JsonResponse $response
     * @param          $data
     * @return array
     */
    protected function formatandoContent($response, $data)
    {
        $content = [
            'status' => $response->status(),
            'data'   => $data,
        ];
        
        if (substr($response->status(), 0, 1) == 4) {
            $content['fails'] = $content['data'];
            $content['data'] = [];
        }
        
        return $content;
    }
}