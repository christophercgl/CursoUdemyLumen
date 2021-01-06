<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin' => '*', // * Todos servidores podem acessar nossa API
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE', // metodos aceitos
            'Access-Control-Allow-Credentials' => 'true', // true significa q a resposta da requisição pode ser exposta, par ser tratada
            'Access-Control-Allow-Max-Age' =>  '86400', // quanto tempo em segundos a requisição pode demorar para dar a reposta
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With' // quais cabeçalhos podem ser usados durante a requisição
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method": "OPTIONS"}', 200, $headers);
        }

        $response = $next($request);

        foreach ($headers as $key => $value) {
            $response->header($key, $value); // pega tudo q passou no header e coloca na resposta
        }

        return $response;
    }
}
