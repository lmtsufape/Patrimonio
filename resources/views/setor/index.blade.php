@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="/css/modal.css">
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Setores',
        'addButtonModal' => ('cadastrarSetorModal'),
        'searchForm' => route('setor.buscar'),
    ])

    
    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Codigo', 'Ações'],
            'content' => [
                $setores->pluck('id'),
                $setores->pluck('nome'),
                $setores->pluck('codigo'),
            ],
            'acoes' => [
                [
                    'link' => 'setor.edit',
                    'param' => 'setor_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                ['link' => 'setor.delete', 'param' => 'setor_id', 'img' => asset('/images/delete.png') , 'type' => 'delete'],
            ],
        ])
    </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $setores->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarSetorModal',
        'modalTitle' => 'Cadastrar Setor',
        'formAction' => route('setor.store'),
        'type'=> ('create'),
        'fields' => [
            ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
            ['name' => 'codigo', 'id' => 'codigo', 'type' => 'text', 'label' => 'Codigo:'],
        ]
    ])
    
    @include('layouts.components.modais.modal', [
        'modalId' => 'editarSetorModal',
        'modalTitle' => 'Editar Setor',
        'formAction' => route('setor.update', ['id' => 'id']),
        'type'=> ('edit'),
        'fields' => [
            ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
            ['name' => 'codigo', 'id' => 'codigo', 'type' => 'text', 'label' => 'Codigo:'],
        ]
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar este Setor?',
        'route' => route('setor.delete', ['setor_id' => 'id']), 
    ])

@endsection

@push('scripts')
    <script>
         
        const setorUpdateRoute = "{{ route('setor.update', ['id' => ':id']) }}"; 
        var setorId = 0;
        const setorDeleteRoute = "http://127.0.0.1:8000/setor/id/delete";
            
        function openDeleteModal(id) {
            setorId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = setorDeleteRoute.replace('id', setorId);
                $(this).find('form').attr('action', formAction);
            });
        });
    


        $(document).ready(function () {
            $('#editarSetorModal').on('show.bs.modal', function(event) {
                var formAction = setorUpdateRoute.replace(':id', setorId); 
                $(this).find('form').attr('action', formAction);
            });
        });

        function openEditModal(id) {
            setorId = id;
            $('#editarSetorModal').modal('show');
        }

        function confirmDelete(event, setorId) {
            event.preventDefault();
            if (confirm("Tem certeza que deseja excluir este setor?")) {
                document.getElementById("deleteForm" + setorId).submit();
            }
        }
    </script>
@endpush
