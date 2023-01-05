<?php

namespace App\Providers;

use App\Models\Agendamentoaovivo;
use App\Models\Aluno;
use App\Models\Aulaaovivo;
use App\Models\Plano;
use App\Models\Aulavod;
use App\Models\Avaliacaoaovivo;
use App\Models\Backingtrakvod;
use App\Models\Categoriaaovivo;
use App\Models\Noticia;
use App\Models\Cursovod;
use App\Models\Categoriavod;
use App\Models\Certificadovod;
use App\Models\Modulovod;
use App\Models\Partituravod;
use App\Models\Pedidoaovivo;
use App\Models\Perguntacertificadovod;
use App\Models\Professoraovivo;
use App\Models\Professorvod;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::bind(
          'model',
          function ($handle) {
              $model = 'App\Models\\' . ucfirst($handle);

              return new $model();
          }
        );

        Route::bind(
          'pai',
          function ($handle) {
              $model = 'App\Models\\' . ucfirst($handle);

              return new $model();
          }
        );

        Route::bind(
            'aluno',
            function ($handle) {
                return Aluno::find($handle);
            }
        );

        Route::bind(
            'aulavod',
            function ($handle) {
                return Aulavod::find($handle);
            }
        );

        Route::bind(
            'modulovod',
            function ($handle) {
                return Modulovod::find($handle);
            }
        );

        Route::bind(
            'cursovod',
            function ($handle) {
                return Cursovod::find($handle);
            }
        );

        Route::bind(
            'categoriaVodSlug',
            function ($handle) {
                return Categoriavod::where('slug', $handle)->first();
            }
        );

        Route::bind(
            'professorVodSlug',
            function ($handle) {
                return Professorvod::where('slug', $handle)->first();
            }
        );

        Route::bind(
            'cursoSlug',
            function ($handle) {
                return Cursovod::where('slug', $handle)->firstOrFail() ;
            }
        );

        Route::bind(
            'moduloSlug',
            function ($handle) {
                return Modulovod::where('slug', $handle)->firstOrFail() ;
            }
        );

        Route::bind(
            'aulaSlug',
            function ($handle) {
                return Aulavod::where('slug', $handle)->firstOrFail() ;
            }
        );

        Route::bind(
            'noticiaSlug',
            function ($handle) {
                return Noticia::where('slug', $handle)->firstOrFail() ;
            }
        );

        Route::bind(
            'planoSlug',
            function ($handle) {
                return Plano::where('slug', $handle)->first();
            }
        );

        Route::bind(
            'certificadovod',
            function ($handle) {
                return Certificadovod::find($handle);
            }
        );

        Route::bind(
            'perguntacertificado',
            function ($handle) {
                return Perguntacertificadovod::find($handle);
            }
        );

        Route::bind(
            'professoraovivo',
            function ($handle) {
                return Professoraovivo::find($handle);
            }
        );

        Route::bind(
            'professoraovivoSlug',
            function ($handle) {
                return Professoraovivo::where('slug', $handle)->first();
            }
        );

        Route::bind(
            'categoriaaovivoSlug',
            function ($handle) {
                return Categoriaaovivo::where('slug', $handle)->first();
            }
        );

        Route::bind(
            'categoriaaovivo',
            function ($handle) {
                return Categoriaaovivo::find($handle);
            }
        );

        Route::bind(
            'aulaaovivo',
            function ($handle) {
                return Aulaaovivo::find($handle);
            }
        );

        Route::bind(
            'agendamentoaluno',
            function ($handle) {
                return Agendamentoaovivo::find($handle);
            }
        );

        Route::bind(
            'partitura',
            function ($handle) {
                return Partituravod::find($handle);
            }
        );

        Route::bind(
            'backtrack',
            function ($handle) {
                return Backingtrakvod::find($handle);
            }
        );

        Route::bind(
            'avaliacao',
            function ($handle) {
                return Avaliacaoaovivo::find($handle);
            }
        );

        Route::bind(
            'pedidoaovivo',
            function ($handle) {
                return Pedidoaovivo::find($handle);
            }
        );
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
        'middleware' => 'web',
        'namespace' => $this->namespace,
      ], function () {
          $files = glob(base_path('routes/backend/*.php'));
          foreach ($files as $file) {
              require $file;
          }
          $files = glob(base_path('routes/sistema/*'));
          foreach ($files as $file) {
              if (is_file($file)) {
                  require $file;
              } else {
                  $folder = glob($file . '/*');
                  foreach ($folder as $f) {
                      if (is_file($f)) {
                          require $f;
                      }
                  }
              }
          }
      });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
