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

    <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table table-hover">
                <thead class="text-md-center">
                    <tr>
                        <th class = "col-2">ID</th>
                        <th class = "col-3">Nome</th>
                        <th class = "col-3">Data de Criação</th>
                        <th class = "col-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($predios as $predio)
                        <tr class="text-md-center">
                            <td class="py-4">{{ $predio->id }}</td>
                            <td class="py-4">{{ $predio->nome }}</td>
                            <td class="py-4">{{ \Carbon\Carbon::parse($predio->created_at)->format('d-m-Y') }}</td>
                            <td class="py-4">
                                <div class="d-flex align-items-center">
                                    <a onclick="openEditModal('{{ $predio->id }}')"
                                        style="cursor: pointer; margin-right: 5px; text-decoration: none;  margin-left: 60px">
                                        <img src="{{ asset('/images/pencil.png') }}" width="24px" alt="Icon de edição">
                                    </a>
                                    <button class="btn me-1 p-0" onclick="openDeleteModal('{{ $predio->id }}')">
                                        <img src="{{ asset('/images/delete.png') }}" alt="Ícone de Ação">
                                    </button>
                                    </a>
                                    <a href="{{ route('sala.index', ['predio_id' => $predio->id]) }}"
                                        style="text-decoration: none;">
                                        <img src="{{ asset('/images/Vector.png') }}" width="19px" alt="Icon de salas">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-5">
                {{ $predios->links('pagination::bootstrap-5') }}
            </div>
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

        $(document).ready(function () {
            $('#editarPredioModal').on('show.bs.modal', function(event) {
                var formAction = predioUpdateRoute.replace('id', predioId);
                $(this).find('form').attr('action', formAction);
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
