<?php
/**
 * Created by PhpStorm.
 * User: ansilva
 * Date: 04/08/2016
 * Time: 10:28
 */

namespace Girolando\Componentes\Pessoa\Commands;


use Illuminate\Console\Command;

class UpCommand extends Command
{
    protected $signature = 'girolando:componentepessoa:up';
    protected $description = 'Instala a view necessária para o componente funcionar. Nesse caso a view é comp.vPessoa';

    public function handle()
    {
        try {
            $this->info('Rodando migration da view');
            $this->migrate();
            $this->info('Migration Executada!');
        } catch (\Exception $e) {
            $this->error('Houve uma falha: '. $e->getMessage());
        }
    }


    private function migrate()
    {
        \DB::statement("
            create view comp.VPessoa as
            select
                p.id,
                c.codCfoCriador,
                c.idTipo as idTipoCriador,
                c.statusCriador,
                p.nomePessoa,
                p.cpfPessoa,
                p.emailPessoa,
                p.loginPessoa,
                p.senhaPessoa,
                p.ultimoAcessoPessoa,
                f.NOME,
                F.NOMEFANTASIA,
                F.TELEFONE,
                F.TELEX,
                F.CGCCFO,
                F.RUA,
                F.CIDADE,
                F.CODETD,
                coalesce(c.statusCriador, 0) as isCriadorAtivo,
                coalesce(fun.statusFuncionario, 0) as isFuncionario,
                coalesce(tec.statusTecnico, 0) as isTecnico,
                coalesce(vet.statusVeterinario, 0) as isVeterinario
            
            FROM 
                adm.pessoa p
            left join adm.Criador c on c.id = p.id
            left join corpore.dbo.fcfo f on f.codcfo = c.codCfoCriador
            left join adm.Funcionario fun on fun.id = p.id and fun.statusFuncionario = 1
            left join adm.Tecnico tec on tec.id = p.id and tec.statusTecnico = 1
            left join adm.Veterinario vet on vet.id = p.id
        ");
    }
}