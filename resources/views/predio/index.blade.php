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
            'header' => ['ID', 'Nome','Data de Criação', 'Ações'],
            'content' => [
                $predios->pluck('id'),
                $predios->pluck('nome'),
                $predios->pluck('created_at')->map(function($date) {
                    return \Carbon\Carbon::parse($date)->format('d-m-Y');
                })
            ],
            'acoes' => [
                [
                    'link' => 'predio.update',
                    'param' => 'id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
                    'link' => 'predio.delete',
                    'param' => 'predio_id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],
                [
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


    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarPredioModal',
        'modalTitle' => 'Cadastrar Prédio',
        'type' => 'create',
        'formAction' => route('predio.store'),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
        ]
    ])

    @include('layouts.components.modais.modal', [
        'modalId' => 'editarPredioModal',
        'modalTitle' => 'Editar Prédio',
        'type' => 'edit',
        'formAction' => route('predio.update', ['id' => '0']),
        'fields' => [
            ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:']
        ]
    ])

    
    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar este Predio?',
        'route' => route('predio.delete', ['predio_id' => 'id']), 
    ])
@endsection

@push('scripts')
    <script>
        const predioDeleteRoute = "http://127.0.0.1:8000/predio/id/delete";
        const predioUpdateRoute = "http://127.0.0.1:8000/predio/id/update";
        var predioId = false;
        const predios = {!! json_encode($predios->pluck('nome', 'id')) !!}

        $(document).ready(function () {
            $('#editarPredioModal').on('show.bs.modal', function(event) {
                var formAction = predioUpdateRoute.replace('id', predioId);
                $(this).find('form').attr('action', formAction);
                $('#nome-edit').val(predios[predioId]);
            });
        });

        function openEditModal(id) {
            predioId = id;
            $('#editarPredioModal').modal('show');
        }

        function openDeleteModal(id) {
            predioId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = predioDeleteRoute.replace('id', predioId);
                $(this).find('form').attr('action', formAction);
            });
        });
    </script>
@endpush