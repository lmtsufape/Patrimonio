@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')
    @if (isset($predio))
        @include('layouts.components.searchbar', [
            'title' => 'Prédios > Salas',
            'titleLink' => Route('predio.index', ['predio_id' => $predio->id]),
            'addButtonModal' => 'cadastrarSalaModal',
            'searchForm' => route('sala.buscar'),
        ])
    @else
        @include('layouts.components.searchbar', [
            'title' => 'Salas',
            'searchForm' => route('sala.buscar'),
        ]);
    @endif

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Telefone', 'Ações'],
            'content' => [
                $salas->pluck('id'),
                $salas->pluck('nome'),
                $salas->pluck('telefone'),
            ],
            'acoes' => [
                [
                    'modalId' => 'editarSalaModal',
                    'modalTitle' => 'Editar Sala',
                    'modalInputs' => [
                        ['type' => 'hidden', 'name' => 'predio_id', 'id' => 'predio_id', 'value' => $predio->id],
                        ['type' => 'text', 'name' => 'nome', 'id' => 'nome', 'label' => 'Nome:'],
                        ['name' => 'telefone', 'id' => 'telefone', 'type' => 'text' , 'label' => 'Telefone:'],

                                    ],
                    'link' => 'sala.update',
                    'param' => 'sala_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
                    'modalId' => 'deleteConfirmationModal',
                    'modalTitle' => 'Tem certeza que deseja apagar esta Sala?',
                    'modalInputs' => [
                                    ],
                    'link' => 'sala.delete',
                    'param' => 'sala_id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $salas->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @stack('modais')

    @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarSalaModal',
        'modalTitle' => 'Cadastrar Sala',
        'formAction' => route('sala.store'),
        'type' => ('create'),
        'fields' => [
            ['type' => 'hidden', 'name' => 'predio_id', 'id' => 'predio_id', 'value' => $predio->id],
            ['type' => 'text', 'name' => 'nome', 'id' => 'nome', 'label' => 'Nome:'],
            ['name' => 'telefone', 'id' => 'telefone', 'type' => 'text' , 'label' => 'Telefone:'],
        ]
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar esta Sala?',
        'route' => route('sala.delete', ['sala_id' => 'id']),
    ])

@endsection

@php
  $dados = [
        'nome' => $salas->pluck('nome', 'id'),
        'telefone' => $salas->pluck('telefone', 'id'),

    ];
@endphp

@push('scripts')
    <script>
        var salaId = 0;
        const dados = {!! json_encode($dados) !!};
        const deleteRoute = "{{ route('sala.delete', ['sala_id' => ':id']) }}";


        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function(button) {
            button.addEventListener('click', function() {
                let modalId = button.getAttribute('data-bs-target');
                let modalElement = document.querySelector(modalId);

                let entidadeId = button.getAttribute('entidade-id');

                modalElement.querySelector('#nome-edit').value = dados['nome'][entidadeId];
                modalElement.querySelector('#telefone-edit').value = dados['telefone'][entidadeId];
            });
        });

        $(document).ready(function () {
            $('#editarSalaModal').on('show.bs.modal', function(event) {
                $(this).find('form').attr('action', $(this).find('form').attr('action').replace('id', salaId));

                $('#nome-edit').val(salasNome[salaId]);
                $('#telefone-edit').val(salasTelefone[salaId]);

            });
        });


        function openDeleteModal(id) {
            salaId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = deleteRoute.replace(':id', salaId);
                $(this).find('form').attr('action', formAction);
            });
        });
    </script>
@endpush
