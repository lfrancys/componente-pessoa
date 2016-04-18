<?php
/**
 * Created by PhpStorm.
 * User: ansilva
 * Date: 29/03/2016
 * Time: 14:34
 */
namespace Girolando\Componentes\Pessoa\Services;


use Girolando\BaseComponent\Services\BaseComponentService;

class PessoaService extends BaseComponentService
{

    public function _init($params = [])
    {
        return view('ComponentePessoa::Services.Pessoa._init', $params);
    }
}