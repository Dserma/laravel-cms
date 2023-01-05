<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class CheckPais
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
        if ($request->user()->pais == null && (Str::replaceFirst(url('/'), '', url()->current()) != '/aluno/dados-pessoais' && Str::replaceFirst(url('/'), '', url()->current()) != '/aluno/dados-pessoais/false')) {
            return response()->redirectTo(route('sistema.alunos.dados', 'false'));
        }

        return $next($request);
    }
}
