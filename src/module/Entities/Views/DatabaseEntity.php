<?php
namespace Girolando\Componentes\Pessoa\Entities\Views;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VPessoa
 * @package Girolando\Componentes\Entities\Views
 */
class DatabaseEntity extends Model
{
    /**
     * @var string
     */
    protected $table = "comp.VPessoa";

    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var bool
     */
    public static $snakeAttributes = false;


    protected $fillable = [
        'id',
        'codCfoCriador',
        'idTipoCriador',
        'statusCriador',
        'nomePessoa',
        'cpfPessoa',
        'emailPessoa',
        'loginPessoa',
        'senhaPessoa',
        'ultimoAcessoPessoa',
        'NOME',
        'NOMEFANTASIA',
        'TELEFONE',
        'TELEX',
        'CGCCFO',
        'RUA',
        'CIDADE',
        'CODETD',
        'isCriadorAtivo',
        'isFuncionario',
        'isTecnico',
        'isVeterinario',
    ];
}
