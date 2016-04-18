<?php
namespace Girolando\Componentes\Pessoa\Controllers\Server;

use Girolando\Componentes\Pessoa\Services\Server\AnimalService;
use Girolando\Componentes\Pessoa\Services\Server\ComponentePessoaService;
use Girolando\Componentes\Pessoa\Services\Server\VPessoaService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PessoaServiceController extends Controller
{
    private $componentePessoaService;

    /**
     * AnimalServiceController constructor.
     * @param $animalService
     */
    public function __construct(VPessoaService $pessoaService)
    {
        $this->componentePessoaService = $pessoaService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->componentePessoaService->getPessoaDatasetJson('_dataTableQuery'.$request->get('name'));
    }

}
