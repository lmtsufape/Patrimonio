@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')
    @include('layouts.components.searchbar', [
        'title' => 'Servidores',
        'addButtonModal' => 'create-servidor-modal',
        'searchForm' => route('patrimonio.busca.get'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Matrícula', 'Cargo', 'Status', 'Ações'],
            'content' => [
                $servidores->pluck('id'),
                $servidores->pluck('user.name'),
                $servidores->pluck('matricula'),
                $servidores->pluck('cargo.nome'),
                $servidores->map(function ($item, $index) {
                    return $item->trashed() ? 'Desativado' : 'Ativado';
                }),
            ],
            'acoes' => [
                [
                    'link' => 'patrimonio.edit',
                    'param' => 'patrimonio_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
                    'link' => 'servidor.delete',
                    'param' => 'servidor_id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $servidores->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @include('layouts.components.modais.modal', [
        'modalId' => 'create-servidor-modal',
        'modalTitle' => 'Criar servidor',
        'type' => 'create',
        'formAction' => route('servidor.store'),
        'fields' => [
            ['type' => 'text', 'name' => 'name', 'id' => 'name', 'label' => 'Nome:'],
            ['type' => 'email', 'name' => 'email', 'id' => 'email', 'label' => 'E-mail:'],
            ['type' => 'text', 'name' => 'cpf', 'id' => 'cpf', 'label' => 'CPF:'],
            ['type' => 'text', 'name' => 'matricula', 'id' => 'matricula', 'label' => 'Matrícula:'],
            ['type' => 'select', 'name' => 'cargo_id', 'id' => 'cargo_id', 'label' => 'Cargo:', 'options' => $cargos->pluck('nome', 'id'), 'placeholder' => 'Selecione um cargo'],
            ['type' => 'select', 'name' => 'role_id', 'id' => 'role', 'label' => 'Tipo do usuário:', 'options' => $roles->pluck('nome', 'id'), 'placeholder' => 'Selecione um tipo de usuário'],
            ['type' => 'password', 'name' => 'password', 'id' => 'password', 'label' => 'Senha:'],
            ['type' => 'password', 'name' => 'confirm_password', 'id' => 'confirm_password', 'label' => 'Confirmar senha:'],
        ],
    ])

    @include('layouts.components.modais.modal', [
        'modalId' => 'edit-servidor-modal',
        'modalTitle' => 'Editar servidor',
        'type' => 'edit',
        'formAction' => route('servidor.update', ['servidor_id' => '0']),
        'fields' => [
            ['type' => 'text', 'name' => 'name', 'id' => 'name', 'label' => 'Nome:'],
            ['type' => 'email', 'name' => 'email', 'id' => 'email', 'label' => 'E-mail:'],
            ['type' => 'text', 'name' => 'cpf', 'id' => 'cpf', 'label' => 'CPF:'],
            ['type' => 'text', 'name' => 'matricula', 'id' => 'matricula', 'label' => 'Matrícula:'],
            ['type' => 'select', 'name' => 'cargo_id', 'id' => 'cargo_id', 'label' => 'Cargo:', 'options' => $cargos->pluck('nome', 'id'), 'placeholder' => 'Selecione um cargo'],
            ['type' => 'select', 'name' => 'role_id', 'id' => 'role', 'label' => 'Tipo do usuário:', 'options' => $roles->pluck('nome', 'id'), 'placeholder' => 'Selecione um tipo de usuário'],
            ['type' => 'password', 'name' => 'password', 'id' => 'password', 'label' => 'Senha:'],
            ['type' => 'password', 'name' => 'confirm_password', 'id' => 'confirm_password', 'label' => 'Confirmar senha:'],
        ]
    ])
@endsection

@push('scripts')
    <script>
        const editModal = $('#edit-servidor-modal');
        const updateRoute = "{{ route('servidor.update', ['servidor_id' => 'id']) }}";
        var servidorId = 0;

        $(document).ready(function() {
            editModal.on('show.bs.modal', function(event) {
                var formAction = updateRoute.replace('/id/', '/' + servidorId + '/');
                editModal.find('form').attr('action', formAction);
            });
        });

        function openEditModal(id) {
            servidorId = id;
            editModal.modal('show');
        }
    </script>
@endpush
