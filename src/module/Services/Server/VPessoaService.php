<?php
/**
 * Created by PhpStorm.
 * User: ansilva
 * Date: 30/03/2016
 * Time: 16:36
 */
namespace Girolando\Componentes\Pessoa\Services\Server;


use Girolando\BaseComponent\Extensions\DataTableQuery;
use Girolando\Componentes\Pessoa\Entities\Views\VPessoa;
use Andersonef\Repositories\Abstracts\ServiceAbstract;
use Girolando\Componentes\Pessoa\Repositories\Views\VPessoaRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;

class VPessoaService extends ServiceAbstract
{

    /**
     * This constructor will receive by dependency injection a instance of VPessoaRepository and DatabaseManager.
     *
     * @param VPessoaRepository $repository
     * @param DatabaseManager $db
     */
    public function __construct(VPessoaRepository $repository, DatabaseManager $db)
    {
        parent::__construct($repository, $db);
    }

    public function getPessoaDataset($dataTableQueryName = '_componenteConsulta')
    {
        $dataTableQuery = DataTableQuery::getInstance($dataTableQueryName);
        $filters = (array) $dataTableQuery->getFilters();
        $retorno = $this->getQuery();
        if($filters){
            $searchableFields = (new VPessoa())->getFillable();
            $nfilters = [];
            foreach($filters as $filter => $value){
                if(!in_array($filter, $searchableFields)) continue;
                $nfilters[$filter] = $value;
            }
            if($nfilters) {
                $retorno = $this->findBy($nfilters);
                $retorno = $retorno->getQuery();
            }
        }

        $retorno->select(['*']);
        $dataset = $dataTableQuery->apply($retorno);


        $request = Request::capture();
        if($request->has('customFilters')){
            $customFilters = $request->get('customFilters');
            $dataset->where( function($query) use($customFilters) {
                foreach($customFilters as $filter => $value){
                    $query->orWhere($filter, 'like', $value);
                }
            });
        }
        return $dataset;
    }

    public function getPessoaDatasetJson($datasetName = '_componenteConsulta')
    {
        $dataset = $this->getPessoaDataset($datasetName);

        return Datatables::of($dataset)
            ->make(true);
    }


}