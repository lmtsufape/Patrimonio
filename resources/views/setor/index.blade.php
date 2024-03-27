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

    <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table table-hover">
                <thead class="text-md-center">
                    <tr>
                        <th class="col-2">ID</th>
                        <th class="col-3">Nome</th>
                        <th class="col-3">Codigo</th>
                        <th class="col-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($setores as $setor)
                        <tr class="text-md-center">
                            <td class="py-4">{{ $setor->id }}</td>
                            <td class="py-4">{{ $setor->nome }}</td>
                            <td class="py-4">{{ $setor->codigo }}</td>
                            <td class="py-4">
                                <div class="text-center d-flex justify-content-center">
                                    <a onclick="openEditModal('{{ $setor->id }}')"
                                        style="cursor: pointer; text-decoration: none;">
                                        <img src="{{ asset('/images/pencil.png') }}" width="24px" alt="Icon de edição">
                                    </a>
                                    <form id="deleteForm{{ $setor->id }}"
                                        action="{{ route('setor.delete', ['setor_id' => $setor->id]) }}" method="POST"
                                        onsubmit="return confirmDelete(event, {{ $setor->id }})">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background: none; border: none; padding: 0;">
                                            <img src="{{ asset('/images/delete.png') }}" width="24px"
                                                alt="Icon de remoção">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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


    <script>
         
        const setorUpdateRoute = "{{ route('setor.update', ['id' => ':id']) }}"; 
        var setorId = 0;

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
@endsection
