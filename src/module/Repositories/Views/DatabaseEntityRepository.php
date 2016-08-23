<?php
namespace Girolando\Componentes\Pessoa\Repositories\Views;

use Andersonef\Repositories\Abstracts\RepositoryAbstract;
use Girolando\Componentes\Pessoa\Providers\ComponentProvider;

/**
 * Data repository to work with entity DatabaseEntity.
 *
 * Class DatabaseEntityRepository
 */
class DatabaseEntityRepository extends RepositoryAbstract{


    public function entity()
    {
        return ComponentProvider::$entity;
    }

}