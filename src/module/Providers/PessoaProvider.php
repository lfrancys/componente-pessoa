<?php
namespace Girolando\Componentes\Pessoa\Providers;

use Girolando\BaseComponent\Providers\BaseComponentProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class PessoaProvider extends BaseComponentProvider{


    public function boot(Router $router)
    {
        Lang::addNamespace('ComponentePessoa', __DIR__.'/../../resources/lang');
        View::addNamespace('ComponentePessoa', __DIR__.'/../../resources/views');
        parent::boot($router);
    }


    public function map(Router $router)
    {
        $router->group(['prefix' => 'vendor-girolando', 'namespace' => 'Girolando\Componentes\Pessoa\Controllers'], function() use($router){
            $router->resource('componentes/pessoa', 'PessoaServiceController', ['only' => ['index']]);
            $router->resource('server/componentes/pessoa', 'Server\PessoaServiceController', ['only' => ['index']]);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}