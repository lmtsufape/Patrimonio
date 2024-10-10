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
            'header' => ['ID', 'Nome' , 'Código', 'Vida útil (Meses)', 'Ações'],
            'content' => [
                $classificacaos->pluck('id'),
                $classificacaos->pluck('nome'),
                $classificacaos ->pluck ('codigo'),
                $classificacaos->pluck('vida_util')
            ],
            'acoes' => [
                [
                    'modalId' => 'editarClassificacaoModal',
                    'modalTitle' => 'Editar Classificação',
                    'modalInputs' => [
                                        ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:'],
                                        ['type' => 'text','name' => 'codigo', 'id' => 'codigo',  'label' => 'Código'],
                                        ['type' => 'text','name' => 'residual', 'id' => 'residual',  'label' => 'Valor residual em meses (%):'],
                                        ['type' => 'text','name' => 'vida_util', 'id' => 'vida_util',  'label' => 'Vida útil (em meses):']
                                    ],
                    'type' => 'edit' ,
                    'link' => 'classificacao.update',
                    'param' => 'classificacao_id',
                    'img' => asset('/images/pencil.png')],
                [
                    'modalId' => 'deleteConfirmationModal',
                    'modalTitle' => 'Tem certeza que deseja apagar esta classificação?',
                    'modalInputs' => [
                                    ],
                    'type' => 'delete' , 'link' => 'classificacao.delete', 'param' => 'classificacao_id', 'img' => asset('/images/delete.png')]
            ],
        ])

        <div class="d-flex justify-content-center mt-5">
            {{ $classificacaos->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @stack('modais')

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


    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar esta classificação?',
        'route' => route('classificacao.delete', ['classificacao_id' => ':id']),
    ])
@endsection
@php
    $dados = [
        'nome' => $classificacaos->pluck('nome', 'id'),
        'codigo' => $classificacaos->pluck('codigo', 'id'),
        'residual' => $classificacaos->pluck('residual', 'id'),
        'vidaUtil' => $classificacaos->pluck('vida_util', 'id'),
    ];
@endphp

@push('scripts')
    <script>
        var classificacaoId = 0;
        const dados = {!!json_encode($dados)!!}
        const deleteRoute = "{{ route('classificacao.delete', ['classificacao_id' => ':id']) }}";

        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                let modalId = button.getAttribute('data-bs-target');
                let modalElement = document.querySelector(modalId);

                let entidadeId = button.getAttribute('entidade-id');

                modalElement.querySelector('#nome-edit').value = dados['nome'][entidadeId];
                modalElement.querySelector('#codigo-edit').value = dados['codigo'][entidadeId];
                modalElement.querySelector('#residual-edit').value = dados['residual'][entidadeId];
                modalElement.querySelector('#vida_util-edit').value = dados['vidaUtil'][entidadeId];
            });
        });

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                $(this).find('form').attr('action', $(this).find('form').attr('action').replace(':id', classificacaoId));

            });
        });

        function openDeleteModal(id) {
            classificacaoId = id;
            $('#deleteConfirmationModal').modal('show');
        }

    </script>
@endpush
