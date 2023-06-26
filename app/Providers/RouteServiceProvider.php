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
