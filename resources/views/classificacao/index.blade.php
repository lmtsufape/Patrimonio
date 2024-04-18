@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')
    @include('layouts.components.searchbar', [
        'title' => 'Classificação Contábil',
        'addButtonModal' => 'cadastrarClassificacaoModal',
        'searchForm' => route ('classificacao.buscar'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Código' , 'Nome', 'Data de Criação', 'Ações'],
            'content' => [
                $classificacaos->pluck('id'),
                $classificacaos ->pluck ('codigo'),
                $classificacaos->pluck('nome'),
                $classificacaos->pluck('created_at')->map(function($date) {
                    return \Carbon\Carbon::parse($date)->format('d-m-Y');
                })
            ],
            'acoes' => [
                ['type' => 'edit' , 'link' => 'classificacao.edit', 'param' => 'classificacao_id', 'img' => asset('/images/pencil.png')],
                ['type' => 'delete' , 'link' => 'classificacao.delete', 'param' => 'classificacao_id', 'img' => asset('/images/delete.png')]
            ],
        ])

        <div class="d-flex justify-content-center mt-5">
            {{ $classificacaos->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarClassificacaoModal',
        'modalTitle' => 'Cadastrar Classificação',
        'type' => 'create',
        'formAction' => route('classificacao.store'),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:'],
            ['type' => 'text','name' => 'codigo', 'id' => 'codigo',  'label' => 'Código'],
            ['type' => 'text','name' => 'residual', 'id' => 'residual',  'label' => 'Valor residual em meses (%):'],
            ['type' => 'text','name' => 'vida_util', 'id' => 'vida_util',  'label' => 'Vida útil (em meses):']
        ]
    ])

    @include('layouts.components.modais.modal', [
        'modalId' => 'editarClassificacaoModal',
        'modalTitle' => 'Editar Classificação',
        'type' => 'edit',
        'formAction' => route('classificacao.update', ['classificacao_id' => 'id']),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:'],
            ['type' => 'text','name' => 'codigo', 'id' => 'codigo',  'label' => 'Código'],
            ['type' => 'text','name' => 'residual', 'id' => 'residual',  'label' => 'Valor residual em meses (%):'],
            ['type' => 'text','name' => 'vida_util', 'id' => 'vida_util',  'label' => 'Vida útil (em meses):']
        ]
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar esta classificação?',
        'route' => route('classificacao.delete', ['classificacao_id' => 'id']), 
    ])
@endsection

@push('scripts')
    <script>
        const classificacaoDeleteRoute = "http://127.0.0.1:8000/classificacao/id/delete";
        var classificacaoId = 0;
        const classificacao = {!!json_encode($classificacaos->pluck('nome', 'id'))!!}
        const codigo = {!!json_encode($classificacaos->pluck('codigo', 'id'))!!}
        const residual = {!!json_encode($classificacaos->pluck('residual', 'id'))!!}
        const vidaUtil = {!!json_encode($classificacaos->pluck('vida_util', 'id'))!!}


        function openDeleteModal(id) {
            classificacaoId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = classificacaoDeleteRoute.replace('id', classificacaoId);
                $(this).find('form').attr('action', formAction);
            });
        });

        const classificacaoUpdateRoute = "http://127.0.0.1:8000/classificacao/update/id";
            
            function openEditModal(id) {
                classificacaoId = id;
                $('#editarClassificacaoModal').modal('show');
            }
    
            $(document).ready(function () {
                $('#editarClassificacaoModal').on('show.bs.modal', function(event) {
                    var formAction = classificacaoUpdateRoute.replace('id', classificacaoId);
                    $(this).find('form').attr('action', formAction);
                    $('#nome-edit').val(classificacao[classificacaoId]);
                    $('#codigo-edit').val(codigo[classificacaoId]);
                    $('#residual-edit').val(residual[classificacaoId]);
                    $('#vida_util-edit').val(vidaUtil[classificacaoId]);


                });
            });
            
    </script>
@endpush