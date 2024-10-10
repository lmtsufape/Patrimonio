@extends('layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Subgrupos',
        'addButtonModal' => ('cadastrarSubgrupoModal'),
        'searchForm' =>  route('subgrupo.buscar'),
    ])

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Marca', 'Modelo', 'Classificação', 'Ações'],
            'content' => [
                $subgrupos->pluck('id'),
                $subgrupos->pluck('nome'),
                $subgrupos->pluck('marca'),
                $subgrupos->pluck('modelo'),
                $subgrupos->pluck('classificacao.nome')
            ],
            'acoes' => [
                [
                    'modalId' => 'editarSubgrupoModal',
                    'modalTitle' => 'Editar Subgrupo',
                    'modalInputs' => [
                                        ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
                                        ['name' => 'marca', 'id' => 'marca', 'type' => 'text', 'label' => 'Marca:'],
                                        ['name' => 'modelo', 'id' => 'modelo', 'type' => 'text', 'label' => 'Modelo:'],
                                        [
                                            'name' => 'classificacao_id',
                                            'id' => 'classificacao',
                                            'type' => 'select',
                                            'label' => 'Classificação:',
                                            'options' => $classificacoes->pluck('nome', 'id'),
                                            'placeholder' => 'Escolha uma Classificação'
                                        ],
                                    ],
                    'link' => 'subgrupo.update',
                    'param' => 'subgrupo_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
                    'modalId' => 'deleteConfirmationModal',
                    'modalTitle' => 'Tem certeza que deseja apagar este Subgrupo?',
                    'modalInputs' => [

                                    ],
                    'link' => 'subgrupo.delete', 'param' => 'subgrupo_id', 'img' => asset('/images/delete.png') , 'type' => 'delete'],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $subgrupos->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @stack('modais')

        @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarSubgrupoModal',
        'modalTitle' => 'Cadastrar Subgrupo',
        'formAction' => route('subgrupo.store'),
        'type'=> 'create',
        'fields' => [
                ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
                ['name' => 'marca', 'id' => 'marca', 'type' => 'text', 'label' => 'Marca:'],
                ['name' => 'modelo', 'id' => 'Modelo', 'type' => 'text', 'label' => 'Modelo:'],
                ['name' => 'classificacao_id', 'id' => 'classificacao', 'type' => 'select', 'label' => 'Classificação:', 'options' => $classificacoes->pluck('nome', 'id'), 'placeholder' => 'Escolha uma Classificação'
                ],
            ],
        ])


    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar este Subgrupo?',
        'route' => route('subgrupo.delete', ['subgrupo_id' => 'id']),
    ])

@endsection

@php
    $dados = [
        'nome' => $subgrupos->pluck('nome', 'id'),
        'marca' => $subgrupos->pluck('marca', 'id'),
        'modelo' => $subgrupos->pluck('modelo', 'id'),
        'classificacao' => $subgrupos->pluck('classificacao_id', 'id'),
    ];

@endphp

@push('scripts')

    <script>
        var subgrupoId = 0;
        const dados = {!! json_encode($dados) !!};

        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                let modalId = button.getAttribute('data-bs-target');
                let modalElement = document.querySelector(modalId);

                let entidadeId = button.getAttribute('entidade-id');

                modalElement.querySelector('#nome-edit').value = dados['nome'][entidadeId];
                modalElement.querySelector('#marca-edit').value = dados['marca'][entidadeId];
                modalElement.querySelector('#modelo-edit').value = dados['modelo'][entidadeId];
                let classificacaoElement = modalElement.querySelector('#classificacao-edit');
                classificacaoElement.querySelectorAll('option').forEach(function(option) {
                    option.selected = false;
                });
                classificacaoElement.value = dados['classificacao'][entidadeId];
            });
        });

        function openDeleteModal(id) {
            subgrupoId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                $(this).find('form').attr('action', $(this).find('form').attr('action').replace('id', subgrupoId));
            });
        });

    </script>

@endpush
