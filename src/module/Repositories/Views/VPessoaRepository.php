<?php
namespace Girolando\Componentes\Pessoa\Repositories\Views;

use Andersonef\Repositories\Abstracts\RepositoryAbstract;
use Girolando\Componentes\Pessoa\Entities\Views\VPessoa;

/**
 * Data repository to work with entity VPessoa.
 *
 * Class VPessoaRepository
 */
class VPessoaRepository extends RepositoryAbstract{


    public function entity()
    {
        return VPessoa::class;
    }

}