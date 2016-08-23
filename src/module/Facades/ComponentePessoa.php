<?php
/**
 * Created by PhpStorm.
 * User: ansilva
 * Date: 14/07/2016
 * Time: 15:26
 */

namespace Girolando\Componentes\Pessoa\Facades;

use Girolando\Componentes\Pessoa\Providers\ComponentProvider;
use Illuminate\Support\Facades\Facade;

class ComponentePessoa extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Girolando.Componente.'.ComponentProvider::$namespace;
    }

}