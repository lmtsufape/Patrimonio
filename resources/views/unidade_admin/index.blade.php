@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Unidades Administrativas',
        'addButtonModal' => 'cadastrarUnidadeModal',
        'searchForm' => route('unidade.buscar'),
    ])


    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Codigo', 'Prédio', 'Unidade','Ações'],
            'content' => [
                $unidades->pluck('id'),
                $unidades->pluck('nome'),
                $unidades->pluck('codigo'),
                $unidades->pluck('predio.nome'),
                $unidades->pluck('unidadeAdmin_pai.nome'),

            ],
            'acoes' => [
                [
                    'modalId' => 'editarUnidadeModal',
                    'modalTitle' => 'Editar Unidade Administrativa',
                    'modalInputs' => [
                                        ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
                                        ['name' => 'codigo', 'id' => 'codigo', 'type' => 'text', 'label' => 'Codigo:'],
                                        [
                                            'name' => 'predio_id',
                                            'id' => 'predio',
                                            'type' => 'select',
                                            'label' => 'Prédio:',
                                            'placeholder' => 'Selecione o Prédio',
                                            'options' => $predios->pluck('nome', 'id'),
                                        ],
                                        [
                                            'name' => 'unidade_admin_pai_id',
                                            'id' => 'unidade_admin_pai',
                                            'type' => 'select',
                                            'label' => 'Unidade:',
                                            'placeholder' => 'Selecione a Unidade',
                                            'options' => $unidadesAll->pluck('nome', 'id'),
                                        ],
                                    ],
                    'link' => 'unidade.edit',
                    'param' => 'unidade_admin_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
                    'modalId' => 'deleteConfirmationModal',
                    'modalTitle' => 'Tem certeza que deseja apagar essa Unidade Administrativa?',
                    'modalInputs' => [
                                    ],
                    'link' => 'unidade.delete',
                    'param' => 'unidade_admin_id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],
            ],
        ])
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{ $unidades->links('pagination::bootstrap-4') }}
    </div>
    </div>
    </div>

    @stack('modais')

    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarUnidadeModal',
        'modalTitle' => 'Cadastrar Unidade Administrativa',
        'formAction' => route('unidade.store'),
        'type' => 'create',
        'fields' => [
            ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
            ['name' => 'codigo', 'id' => 'codigo', 'type' => 'text', 'label' => 'Código:'],
            [
                'name' => 'predio_id',
                'id' => 'predio',
                'type' => 'select',
                'label' => 'Prédio:',
                'placeholder' => 'Selecione o Prédio',
                'options' => $predios->pluck('nome', 'id'),
            ],
            ['name' => 'unidade_admin_pai_id',
                'id' => 'unidade_admin_pai',
                'type' => 'select',
                'label' => 'Unidade:',
                'placeholder' => 'Selecione a Unidade',
                'options' => $unidadesAll->pluck('nome', 'id'),]
        ],
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar essa Unidade Administrativa?',
        'route' => route('unidade.delete', ['unidade_admin_id' => ':id']),
    ])
@endsection

@php
    $dados = [
        'nome' => $unidades->pluck('nome', 'id'),
        'codigo' => $unidades->pluck('codigo', 'id'),
        'predio' => $unidades->pluck('predio_id', 'id'),
        'unidade' => $unidades->pluck('unidade_admin_pai_id', 'id'),
    ];

@endphp

@push('scripts')
    <script>
        var unidadeId = 0;
        const dados = {!! json_encode($dados) !!};
        const deleteRoute = "{{ route('unidade.delete', ['unidade_admin_id' => ':id']) }}";

        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                let modalId = button.getAttribute('data-bs-target');
                let modalElement = document.querySelector(modalId);

                let entidadeId = button.getAttribute('entidade-id');

                modalElement.querySelector('#nome-edit').value = dados['nome'][entidadeId];
                modalElement.querySelector('#codigo-edit').value = dados['codigo'][entidadeId];
                modalElement.querySelector('#predio-edit').value = dados['predio'][entidadeId];
                let unidadeElement = modalElement.querySelector('#unidade_admin_pai-edit');
                unidadeElement.querySelectorAll('option').forEach(function(option) {
                    option.selected = false;
                });
                unidadeElement.value = dados['unidade'][entidadeId];
            });
        });

        function openDeleteModal(id) {
            unidadeId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = deleteRoute.replace(':id', unidadeId);
                $(this).find('form').attr('action', formAction);
            });
        });
    </script>
@endpush
