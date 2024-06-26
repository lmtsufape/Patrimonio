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
                    'link' => 'cargo.edit',
                    'param' => 'cargo_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                ['link' => 'cargo.delete', 'param' => 'cargo_id', 'img' => asset('/images/delete.png') , 'type' => 'delete'],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $cargos->links('pagination::bootstrap-4') }}
        </div>
    </div>


    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarCargoModal',
        'modalTitle' => 'Cadastrar Cargo',
        'formAction' => route('cargo.store'),
        'type' => ('create'),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
        ]
    ])

    @include('layouts.components.modais.modal', [
        'modalId' => 'editarCargoModal',
        'modalTitle' => 'Editar Cargo',
        'formAction' => route('cargo.update', ['cargo_id' => 'id']),
        'type' => ('edit'),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
        ]
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar este Cargo?',
        'route' => route('cargo.delete', ['cargo_id' => 'id']),
    ])

@endsection

@push('scripts')
    <script>
        const editModal = $('#editarCargoModal');
        var cargoId = 0;
        const cargos = {!! json_encode($cargos->pluck('nome', 'id')) !!}
        $(document).ready(function() {
            editModal.on('show.bs.modal', function(event) {
                editModal.find('form').attr('action', $(this).find('form').attr('action').replace('id', cargoId));
                $('#nome-edit').val(cargos[cargoId]);

            });
        });

        function openEditModal(id) {
            cargoId = id;
            editModal.modal('show');
        }

        function openDeleteModal(id) {
            cargoId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                $(this).find('form').attr('action', $(this).find('form').attr('action').replace('id', cargoId));
            });
        });

    </script>
@endpush
