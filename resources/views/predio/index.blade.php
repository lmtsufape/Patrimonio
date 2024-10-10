@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/modal.css">
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Prédios',
        'addButtonModal' => 'cadastrarPredioModal',
        'searchForm' => route('predio.busca.get'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Ações'],
            'content' => [
                $predios->pluck('id'),
                $predios->pluck('nome')
            ],
            'acoes' => [
                [
                    'modalId' => 'editarPredioModal',
                    'modalTitle' => 'Editar Prédio',
                    'modalInputs' => [
                                        ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
                                    ],
                    'link' => 'predio.update',
                    'param' => 'id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
                    'modalId' => 'deleteConfirmationModal',
                    'modalTitle' => 'Tem certeza que deseja apagar este Prédio?',
                    'modalInputs' => [
                                    ],
                    'link' => 'predio.delete',
                    'param' => 'predio_id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],
                [
                    'modalId' => 'teste',
                    'modalTitle' => 'teste',
                    'modalInputs' => [
                                    ],
                    'link' => 'sala.index',
                    'param' => 'predio_id',
                    'img' => asset('/images/Vector.png'),
                    'type' => 'get',
                ],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $predios->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @stack('modais')

    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarPredioModal',
        'modalTitle' => 'Cadastrar Prédio',
        'type' => 'create',
        'formAction' => route('predio.store'),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
        ]
    ])


    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar este Prédio?',
        'route' => route('predio.delete', ['predio_id' => ':id']),
    ])
@endsection

@php
    $dados = [
        'nome' => $predios->pluck('nome', 'id'),

    ];
@endphp

@push('scripts')
    <script>
        var predioId;
        const deleteRoute = "{{ route('predio.delete', ['predio_id' => ':id']) }}";
        const dados = {!! json_encode($dados) !!}

        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                let modalId = button.getAttribute('data-bs-target');
                let modalElement = document.querySelector(modalId);

                let entidadeId = button.getAttribute('entidade-id');

                modalElement.querySelector('#nome-edit').value = dados['nome'][entidadeId];
            });
        });

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = deleteRoute.replace(':id', predioId);
                $(this).find('form').attr('action', formAction);
            });
        });

        function openDeleteModal(id) {
            predioId = id;
            $('#deleteConfirmationModal').modal('show');
        }

    </script>
@endpush
