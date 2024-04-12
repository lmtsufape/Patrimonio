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
            'header' => ['ID', 'Nome', 'Data de Criação', 'Ações'],
            'content' => [
                $cargos->pluck('id'),
                $cargos->pluck('nome'),
                $cargos->pluck('created_at')->map(function($date) {
                    return \Carbon\Carbon::parse($date)->format('d-m-Y');
                })
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
        'formAction' => route('cargo.update', ['cargo_id' => 'cargo_id']),
        'type' => ('edit'),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
        ]
    ])
@endsection

@push('scripts')
    <script>
        const editModal = $('#editarCargoModal');
        const updateRoute = "{{ route('cargo.update', ['cargo_id' => 'cargo_id']) }}";
        var cargoId = 0;

        $(document).ready(function() {
            editModal.on('show.bs.modal', function(event) {
                var formAction = updateRoute.replace('cargo_id', cargoId);
                editModal.find('form').attr('action', formAction);
            });
        });

        function openEditModal(id) {
            cargoId = id;
            editModal.modal('show');
        }
    </script>
@endpush
