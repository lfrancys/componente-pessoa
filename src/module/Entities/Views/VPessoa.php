<?php
namespace Girolando\Componentes\Pessoa\Entities\Views;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AnimalConsulta
 * @package Girolando\Componentes\Entities\Views
 */
class VPessoa extends Model
{
    /**
     * @var string
     */
    protected $table = "sistema.vPessoa";


    /**
     * @var string
     */
    protected $primaryKey = 'codigoPessoa';
    /**
     * @var bool
     */
    public static $snakeAttributes = false;

    protected $fillable = ['codigoPessoa','codigoAssociado','tipoAssociado','statusAssociado','NOME', 'NOMEFANTASIA','TELEFONE','TELEX','CGCCFO','RUA','CIDADE','CODETD','isFuncionario','isControlador','isTecnico','isVeterinario'];

}
