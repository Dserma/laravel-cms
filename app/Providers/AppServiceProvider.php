<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Aluno;
use App\Models\Aulaaovivo;
use App\Models\Perguntavod;
use App\Models\Professoraovivo;
use App\Models\Agendamentoaovivo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Observers\Sistema\AulaAovivoObserver;
use App\Observers\Sistema\Alunos\AlunoObserver;
use App\Observers\Sistema\ProfessorAovivoObserver;
use App\Observers\Sistema\Aovivo\AgendamentoObserver;
use App\Observers\Sistema\Perguntas\PerguntaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.UTF-8', 'pt_BR.utf8', 'portuguese');
        $faker = \Faker\Factory::create('pt_BR');
        require_once app_path('Macros/Functions.php');
        $url = $this->app['url'];
        $url->forceRootUrl(config('app.url'));
        Carbon::setLocale('pt_BR');
        Aluno::observe(AlunoObserver::class);
        Perguntavod::observe(PerguntaObserver::class);
        Professoraovivo::observe(ProfessorAovivoObserver::class);
        Aulaaovivo::observe(AulaAovivoObserver::class);
        Agendamentoaovivo::observe(AgendamentoObserver::class);
        \Debugbar::disable();
    }
}
