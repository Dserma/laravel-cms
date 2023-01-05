<?php

namespace App\Http\Middleware;

use App\Services\Sistema\SistemaService;
use Closure;

class UsuarioMiddleware
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
        $nome = $request->route()->getCompiled()->getVariables()[0];
        $obj = $request->route()->parameter($nome);
        if (!$request->user()->cursos->contains($obj->id)) {
            return SistemaService::jsonR(401, 'Não autorizado!', 0);
        }

        return $next($request);
    }
}
