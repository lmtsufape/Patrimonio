@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')
    @include('layouts.components.searchbar', [
        'title' => 'Servidores',
        'addButtonModal' => 'create-servidor-modal',
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
                    'modalId' => 'edit-servidor-modal',
                    'modalTitle' => 'Editar servidor',
                    'modalInputs' => [
                                        ['type' => 'text', 'name' => 'name', 'id' => 'name', 'label' => 'Nome:'],
                                        ['type' => 'email', 'name' => 'email', 'id' => 'email', 'label' => 'E-mail:'],
                                        ['type' => 'text', 'name' => 'cpf', 'id' => 'cpf', 'label' => 'CPF:'],
                                        ['type' => 'text', 'name' => 'matricula', 'id' => 'matricula', 'label' => 'Matrícula:'],
                                        ['type' => 'checkbox', 'name' => 'cargo_id', 'id' => 'cargo_id', 'label' => 'Cargo:', 'options' => $cargos->pluck('nome', 'id'), 'placeholder' => 'Selecione um cargo'],
                                        ['type' => 'select', 'name' => 'role_id', 'id' => 'role_id', 'label' => 'Tipo do usuário:', 'options' => $roles->pluck('nome', 'id'), 'placeholder' => 'Selecione um tipo de usuário'],
                                    ],
                    'link' => 'servidor.update',
                    'param' => 'id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
                    'modalId' => 'deleteConfirmationModal',
                    'modalTitle' => 'Tem certeza que deseja apagar esse servidor?',
                    'modalInputs' => [
                                    ],
                    'link' => 'servidor.delete',
                    'param' => 'id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],
                [
                    'modalId' => 'teste',
                    'modalTitle' => 'teste',
                    'modalInputs' => [
                                    ],
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

    @stack('modais')

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
            ['type' => 'select', 'name' => 'role_id', 'id' => 'role_id', 'label' => 'Tipo do usuário:', 'options' => $roles->pluck('nome', 'id'), 'placeholder' => 'Selecione um tipo de usuário'],
            ['type' => 'password', 'name' => 'password', 'id' => 'password', 'label' => 'Senha:', 'value' => 'password'],
        ],
    ])
    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar esse servidor?',
        'route' => route('servidor.delete', ['id' => 'id']),
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
        const deleteRoute = "{{ route('servidor.delete', ['id' => ':id']) }}";
        let servidorId;

        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                let modalId = button.getAttribute('data-bs-target');
                let modalElement = document.querySelector(modalId);

                let entidadeId = button.getAttribute('entidade-id');

                modalElement.querySelector('#name-edit').value = dados['name'][entidadeId];
                modalElement.querySelector('#email-edit').value = dados['email'][entidadeId];
                modalElement.querySelector('#cpf-edit').value = dados['cpf'][entidadeId];
                modalElement.querySelector('#matricula-edit').value = dados['matricula'][entidadeId];

                let roleElement = modalElement.querySelector('#role_id-edit');
                roleElement.querySelectorAll('option').forEach(function(option) {
                    option.selected = false;
                });
                roleElement.value = dados['role'][entidadeId];
                console.log(dados);

                modalElement.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                });

                dados['cargos'][entidadeId].forEach(function(cargoId) {
                    let cargoCheckbox = modalElement.querySelector('#cargo_id-edit-' + cargoId);
                    if (cargoCheckbox) {
                        cargoCheckbox.checked = true;
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                    var formAction = deleteRoute.replace(':id', servidorId);
                    $(this).find('form').attr('action', formAction);
                });
            });

        function openDeleteModal(id) {
            servidorId = id;
            $('#deleteConfirmationModal').modal('show');
        }
    </script>
@endpush
