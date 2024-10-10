@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Cargos',
        'addButtonModal' => 'cadastrarCargoModal',
        'searchForm' => route('cargo.buscar'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Ações'],
            'content' => [
                $cargos->pluck('id'),
                $cargos->pluck('nome'),
            ],
            'acoes' => [
                [
                    'modalId' => 'editarCargoModal',
                    'modalTitle' => 'Editar Cargo',
                    'modalInputs' => [
                                        ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
                                    ],
                    'link' => 'cargo.update',
                    'param' => 'cargo_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
                    'modalId' => 'deleteConfirmationModal',
                    'modalTitle' => 'Tem certeza que deseja apagar este Cargo?',
                    'modalInputs' => [

                                    ],
                    'link' => 'cargo.delete', 'param' => 'cargo_id', 'img' => asset('/images/delete.png') , 'type' => 'delete'],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $cargos->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @stack('modais')

    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarCargoModal',
        'modalTitle' => 'Cadastrar Cargo',
        'formAction' => route('cargo.store'),
        'type' => ('create'),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
        ]
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar este Cargo?',
        'route' => route('cargo.delete', ['cargo_id' => ':id']),
    ])

@endsection

@php
    $dados = [
        'nome' => $cargos->pluck('nome', 'id'),
    ];

@endphp

@push('scripts')
    <script>
        const dados = {!! json_encode($dados) !!};
        const deleteRoute = "{{ route('cargo.delete', ['cargo_id' => ':id']) }}";

        var cargoId = 0;

        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                let modalId = button.getAttribute('data-bs-target');
                let modalElement = document.querySelector(modalId);

                let entidadeId = button.getAttribute('entidade-id');

                modalElement.querySelector('#nome-edit').value = dados['nome'][entidadeId];

            });
        });

        function openDeleteModal(id) {
            cargoId = id;
            $('#deleteConfirmationModal').modal('show');
        }


        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = deleteRoute.replace(':id', cargoId);
                $(this).find('form').attr('action', formAction);
            });
        });

    </script>
@endpush
