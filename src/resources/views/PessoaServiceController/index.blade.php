@extends('layout.blank.index')

@section('content')
    <table class="table tooltip-demo table-stripped table-hover comp-tbl-search-animal" data-page-size="10" data-filter=#filter>
        <thead>
        @if(isset($multiple) && $multiple)
            <th>#</th>
        @endif
        <th>Código</th>
        <th>Nome</th>
        <th>Tipo</th>
        @if(!(isset($multiple) && $multiple))
            <th>Selecionar</th>
        @endif
        </thead>
    </table>
@endsection

@section('javascript')
    <script type="text/javascript">

        Componente.scope(function(){ //escopando as variáveis para não conflitarem com possíveis outros componentes do mesmo tipo abertos na tela
            var componente = Componente.AnimalFactory.get('{!! $name !!}');

            var colunas = [
                {
                    name : 'nomeAnimal',
                    data : function(obj){
                        if(!obj.nomeAnimal) return ' - ';
                        return '<label for="_comppessoa_{!! $name !!}_' + obj.codigoAnimal + '">' + obj.nomeAnimal + '</label>';
                    }
                },
                {name : 'nomePessoa', data : 'nomePessoa'},
                {name : 'tipoPessoa', data : function(obj){
                    var tipo = '';

                    if(obj.tipoAssociado == 1 && obj.statusAssociado == 1) {
                        tipo += '<span data-toggle="tooltip" data-placement="top" data-original-title="{!! trans('ComponentePessoa::PessoaServiceController.tipos.associadoAtivo' !!}" class="label label-success">{!! trans('ComponentePessoa::PessoaServiceController.tipos.sgAssociadoAtivo' !!}</span>';
                    }

                    if(obj.tipoAssociado == 1 && obj.statusAssociado == 0) {
                        tipo += '<span data-toggle="tooltip" data-placement="top" data-original-title="{!! trans('ComponentePessoa::PessoaServiceController.tipos.associadoInativo' !!}" class="label">{!! trans('ComponentePessoa::PessoaServiceController.tipos.sgAssociadoInativo' !!}</span>';
                    }

                    if(obj.isFuncionario == 1){
                        tipo += '<span data-toggle="tooltip" data-placement="top" data-original-title="{!! trans('ComponentePessoa::PessoaServiceController.tipos.funcionario' !!}" class="label label-primary">{!! trans('ComponentePessoa::PessoaServiceController.tipos.sgFuncionario' !!}</span>';
                    }

                    if(obj.isTecnico == 1){
                        tipo += '<span data-toggle="tooltip" data-placement="top" data-original-title="{!! trans('ComponentePessoa::PessoaServiceController.tipos.tecnico' !!}" class="label label-warning">{!! trans('ComponentePessoa::PessoaServiceController.tipos.sgTecnico' !!}</span>';
                    }

                    if(obj.isControlador == 1){
                        tipo += '<span data-toggle="tooltip" data-placement="top" data-original-title="{!! trans('ComponentePessoa::PessoaServiceController.tipos.controlador' !!}" class="label label-warning">{!! trans('ComponentePessoa::PessoaServiceController.tipos.sgControlador' !!}</span>';
                    }

                    if(obj.isVeterinario == 1){
                        tipo += '<span data-toggle="tooltip" data-placement="top" data-original-title="{!! trans('ComponentePessoa::PessoaServiceController.tipos.veterinario' !!}" class="label label-info">{!! trans('ComponentePessoa::PessoaServiceController.tipos.sgVeterinario' !!}</span>';
                    }
                    return tipo;

                }}
            ];

            @if(isset($multiple) && $multiple)
                colunas.unshift({
                    name : 'VPessoa.codigoPessoa',
                    data : function(obj){
                        var idfield = '_comppessoa_{!! $name !!}_' + obj.codigoPessoa;
                        if(componente.dataTableInstance.DataTableQuery().isItemChecked(obj.codigopessoa)) {
                            return '<input id="' + idfield + '" class="checkbox checkbox-primary chkSelecionar" type="checkbox" checked="checked" value="' + obj.codigoPessoa + '">';
                        }
                        return '<input id="' + idfield + '" class="checkbox checkbox-primary chkSelecionar" type="checkbox" value="' + obj.codigoPessoa + '">';
                    }
                });
            @else
                colunas.push({
                    name : 'VPessoa.codigoPessoa',
                    data : function(obj){
                        var idfield = '_comppessoa_{!! $name !!}_' + obj.codigoPessoa;
                        return '<button id="' + idfield + '" class="btn btn-sm btn-primary btnSelecionar" codigo="' + obj.codigoPessoa + '">Selecionar</button>';
                    }
                });
            @endif


            componente.dataTableInstance = $(".comp-tbl-search-animal")
                    .on('xhr.dt', function(){
                        setTimeout(function(){
                            $("[data-toggle=tooltip]").tooltip();
                        }, 0);
                    })
                    .CustomDataTable({
                        name : '_dataTableQuery{!! $name !!}',
                        queryParams : {
                            idField : 'codigoPessoa',
                            filtersCallback : function(obj){
                                @if($_attrFilters)
                                    @foreach($_attrFilters as $attr => $val)
                                        obj['{!! $attr !!}'] = '{!! $val !!}';
                                    @endforeach
                                @endif
                            }
                        },
                        columns : colunas,
                        ajax : {
                            url : '/vendor-girolando/componentes/pessoa',
                            data : function(obj){
                                obj.name = '{!! $name !!}';
                            }
                        }
                    });


            @if(isset($multiple) && $multiple)
                componente.modalInstance.delegate('.chkSelecionar', 'change', function(){
                var val = $(this).val();
                var obj = componente.dataTableInstance.row($(this).closest('tr'));
                if(!componente.dataTableInstance.DataTableQuery().isChecked(val)){
                    componente.selectedItems.put(val, obj.data());
                    return componente.dataTableInstance.DataTableQuery().addItem(val);
                }
                componente.selectedItems.remove(val);
                return componente.dataTableInstance.DataTableQuery().removeItem(val);
            });
            @else
                componente.modalInstance.delegate('.btnSelecionar', 'click', function(){
                var instance = componente.dataTableInstance.row($(this).closest('tr')).data();
                componente.selectedItems.clear();
                componente.selectedItems.put($(this).attr('codigo'), instance);
                componente.modalInstance.modal('hide');
                componente.triggerEvent(Componente.EVENTS.ON_FINISH, instance);
            });
            @endif
        });
    </script>
@endsection