<?php

namespace App\Http\Middleware;

use Closure;

class CursoGratisMiddleware
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
        $curso = $request->route()->getCompiled()->getVariables()[0];
        $obj = $request->route()->parameter($curso);
        if ($obj->gratuito != 1) {
            return response()->redirectTo(route('sistema.alunos.cursos-gratis'));
        }

        return $next($request);
    }
}
