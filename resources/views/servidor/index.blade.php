@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')
    @include('layouts.components.searchbar', [
        'title' => 'Servidores',
        //'addButtonModal' => 'create-servidor-modal',
        'searchForm' => route('servidor.buscar'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Matrícula', 'Cargos', 'Status', 'Ações'],
            'content' => [
                $servidores->pluck('id'),
                $servidores->pluck('name'),
                $servidores->pluck('matricula'),
                $servidores->map(function ($servidor) {
                    return $servidor->cargos->pluck('nome')->toArray();
                }),
                $servidores->map(function ($item, $index) {
                    return $item->ativo ? 'Ativo' : 'Inativo';
                }),

            ],
            'acoes' => [
                [
                    'link' => 'servidor.edit',
                    'param' => 'id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
                    'link' => 'servidor.delete',
                    'param' => 'id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],
                [
                    'link' => 'servidor.validar',
                    'param' => 'id',
                    'img' => asset('/assets/person-fill-check.svg'),
                    'type' => 'post',
                ],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $servidores->links('pagination::bootstrap-4') }}
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
            ['type' => 'checkbox', 'name' => 'cargo_id', 'id' => 'cargo_id', 'label' => 'Cargo:', 'options' => $cargos->pluck('nome', 'id'), 'placeholder' => 'Selecione um cargo'],
            ['type' => 'select', 'name' => 'role_id', 'id' => 'role', 'label' => 'Tipo do usuário:', 'options' => $roles->pluck('nome', 'id'), 'placeholder' => 'Selecione um tipo de usuário'],
            ['type' => 'password', 'name' => 'password', 'id' => 'password', 'label' => 'Senha:'],
            ['type' => 'password', 'name' => 'confirm_password', 'id' => 'confirm_password', 'label' => 'Confirmar senha:'],
        ],
    ])

    @include('layouts.components.modais.modal', [
        'modalId' => 'edit-servidor-modal',
        'modalTitle' => 'Editar servidor',
        'type' => 'edit',
        'formAction' => route('servidor.update', ['id' => ':id']),
        'fields' => [
            ['type' => 'text', 'name' => 'name', 'id' => 'name', 'label' => 'Nome:'],
            ['type' => 'email', 'name' => 'email', 'id' => 'email', 'label' => 'E-mail:'],
            ['type' => 'text', 'name' => 'cpf', 'id' => 'cpf', 'label' => 'CPF:'],
            ['type' => 'text', 'name' => 'matricula', 'id' => 'matricula', 'label' => 'Matrícula:'],
            ['type' => 'checkbox', 'name' => 'cargo_id', 'id' => 'cargo_id', 'label' => 'Cargo:', 'options' => $cargos->pluck('nome', 'id'), 'placeholder' => 'Selecione um cargo'],
            ['type' => 'select', 'name' => 'role_id', 'id' => 'role', 'label' => 'Tipo do usuário:', 'options' => $roles->pluck('nome', 'id'), 'placeholder' => 'Selecione um tipo de usuário'],
        ]
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar esse servidor ?',
        'route' => route('servidor.delete', ['id' => ':id']),
    ])
@endsection

@php
    $dados = [
        'name' => $servidores->pluck('name', 'id'),
        'email' => $servidores->pluck('email', 'id'),
        'cpf' => $servidores->pluck('cpf', 'id'),
        'matricula' => $servidores->pluck('matricula', 'id'),
    ];

    foreach ($servidores as $servidor) {
        $dados['cargos'][$servidor->id] = $servidor->cargos->pluck('id');
        $dados['role'][$servidor->id] = $servidor->roles->first()->id;
    }
@endphp

@push('scripts')
    <script>
        const dados = {!! json_encode($dados) !!};
        const editModal = $('#edit-servidor-modal');
        const updateRoute = "{{ route('servidor.update', ['id' => ':id']) }}";
        const deleteRoute = "{{ route('servidor.delete', ['id' => ':id']) }}";
        var servidorId = 0;

        $(document).ready(function() {
            editModal.on('show.bs.modal', function(event) {
                var formAction = updateRoute.replace(':id', servidorId);
                editModal.find('form').attr('action', formAction);
                $('#name-edit').val(dados['name'][servidorId]);
                $('#email-edit').val(dados['email'][servidorId]);
                $('#cpf-edit').val(dados['cpf'][servidorId]);
                $('#matricula-edit').val(dados['matricula'][servidorId]);

                $('#role-edit option').prop('selected', false);
                $('#role-edit').val(dados['role'][servidorId]);

                $('input[type="checkbox"]').prop('checked', false);

                dados['cargos'][servidorId].forEach(element => {
                    $('#cargo_id-edit-' + element).prop('checked', true);
                });
            });

            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = deleteRoute.replace(':id', servidorId);
                $(this).find('form').attr('action', formAction);
            });
        });

        function openEditModal(id) {
            servidorId = id;
            editModal.modal('show');
        }

        function openDeleteModal(id) {
            servidorId = id;
            $('#deleteConfirmationModal').modal('show');
        }
    </script>
@endpush
