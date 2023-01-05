<?php

namespace App\Traits\Sistema;

use auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\Sistema\BaseRepository;
use App\Repositories\Sistema\Alunos\AlunosRepository;

trait Handler
{
    protected $user;
    protected $cart;
    protected $configs;
    protected $categoriasProdutos;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->usuario = auth()->user();
            if (!is_object($this->usuario)) {
                $this->usuario = auth()->guard('professor')->user();
            }
            if (is_object($this->usuario)) {
                if ($this->usuario instanceof \App\Models\Aluno) {
                    $avaliacoes = BaseRepository::get('avaliacaoaovivo', ['aluno_id' => auth()->user()->id, 'ocorreu' => 0])->count();
                } else {
                    $avaliacoes = BaseRepository::get('agendamentoaovivo', ['professoraovivo_id' => auth()->guard('professor')->user()->id, 'status' => 4])->count();
                }
                View::share('avCount', $avaliacoes);
            }
            if (!session('cart')) {
                session(['cart' => []]);
            }
            $this->configs = BaseRepository::find('configuracoes', 1);
            View::share('usuario', $this->usuario);
            View::share('cart', AlunosRepository::getCart()->count());
            View::share('configs', $this->configs);
            View::share('home', BaseRepository::find('home', 1));

            return $next($request);
        });
        View::share('titulo', '');
    }

    /**
     * Share with view
     *
     * @param Request $request
     * @return void
     */
    private function share(Request $request)
    {
    }
}
