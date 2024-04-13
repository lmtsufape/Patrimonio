@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Unidades Administrativas',
        'addButtonModal' => ('cadastrarUnidadeModal'),
        'searchForm' => route('unidade.buscar'),
    ])

    
    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Codigo', 'Ações'],
            'content' => [
                $unidades->pluck('id'),
                $unidades->pluck('nome'),
                $unidades->pluck('codigo'),
            ],
            'acoes' => [
                [
                    'link' => 'unidade.edit',
                    'param' => 'unidade_admin_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                ['link' => 'unidade.delete', 'param' => 'unidade_admin_id', 'img' => asset('/images/delete.png') , 'type' => 'delete'],
            ],
        ])
    </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $unidades->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarUnidadeModal',
        'modalTitle' => 'Cadastrar Unidade Administrativa',
        'formAction' => route('unidade.store'),
        'type'=> ('create'),
        'fields' => [
            ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
            ['name' => 'codigo', 'id' => 'codigo', 'type' => 'text', 'label' => 'Codigo:'],
        ]
    ])
    
    @include('layouts.components.modais.modal', [
        'modalId' => 'editarUnidadeModal',
        'modalTitle' => 'Editar Unidade Administrativa',
        'formAction' => route('unidade.update', ['id' => 'id']),
        'type'=> ('edit'),
        'fields' => [
            ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
            ['name' => 'codigo', 'id' => 'codigo', 'type' => 'text', 'label' => 'Codigo:'],
        ]
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar essa Unidade Administrativa?',
        'route' => route('unidade.delete', ['unidade_admin_id' => 'id']),
    ])

@endsection

@push('scripts')
    <script>
         
        const unidadeDeleteRoute = "http://127.0.0.1:8000/unidade/unidade_id/delete";
        const unidadeUpdateRoute = "{{ route('unidade.update', ['id' => ':id']) }}"; 
        var unidadeId = 0;
            
        function openDeleteModal(id) {
            unidadeId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = unidadeDeleteRoute.replace('unidade_id', unidadeId);
                $(this).find('form').attr('action', formAction);
            });
        });

        $(document).ready(function () {
            $('#editarUnidadeModal').on('show.bs.modal', function(event) {
                var formAction = unidadeUpdateRoute.replace(':id', unidadeId); 
                $(this).find('form').attr('action', formAction);
            });
        });

        function openEditModal(id) {
            unidadeId = id;
            $('#editarUnidadeModal').modal('show');
        }

    </script>
@endpush
