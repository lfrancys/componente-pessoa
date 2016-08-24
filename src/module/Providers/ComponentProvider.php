<?php
namespace Girolando\Componentes\Pessoa\Providers;

use Girolando\BaseComponent\Contracts\ComponentServiceContract;
use Girolando\BaseComponent\Providers\BaseComponentProvider;
use Girolando\Componentes\Pessoa\Commands\DownCommand;
use Girolando\Componentes\Pessoa\Commands\UpCommand;
use Girolando\Componentes\Pessoa\Entities\Views\DatabaseEntity;
use Girolando\Componentes\Pessoa\Facades\ComponentePessoa;
use Girolando\Componentes\Pessoa\Http\Controllers\ServerController;
use Girolando\Componentes\Pessoa\Services\ComponentService;
use Girolando\Componentes\Pessoa\Services\Server\DatabaseEntityService;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class ComponentProvider extends BaseComponentProvider{

    public static $routeModal = '/vendor-girolando/componentes/pessoa';
    public static $routeServer = '/vendor-girolando/server/componentes/pessoa';
    public static $componentNamespace = 'ComponentePessoa';
    public static $entity = DatabaseEntity::class;
    public static $facade = ComponentePessoa::class;
    public static $databaseService = DatabaseEntityService::class;
    public static $componentService = ComponentService::class;
    public static $componente = 'Pessoa';


    public function boot(Router $router)
    {
        Lang::addNamespace(self::$componentNamespace, __DIR__.'/../../resources/lang');
        View::addNamespace(self::$componentNamespace, __DIR__.'/../../resources/views');
        parent::boot($router);
    }


    public function map(Router $router)
    {
        $router->group(['namespace' => 'Girolando\Componentes\\'.self::$componente.'\Http\Controllers'], function() use($router){
            $router->resource(self::$routeModal, 'ClientController', ['only' => ['index']]);
            $router->resource(self::$routeServer, 'ServerController', ['only' => ['index']]);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Girolando.Componente.'.self::$componentNamespace, self::$componentService);
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias(self::$componentNamespace, self::$facade);
        $this->commands([UpCommand::class, DownCommand::class]);

        $this->app->when(ServerController::class)->needs(ComponentServiceContract::class)->give(self::$databaseService);

    }
}