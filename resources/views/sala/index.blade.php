@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
    <link rel="stylesheet" href="/css/modal.css">
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
            'header' => ['ID', 'Nome', 'Telefone', 'Data de criação', 'Ações'],
            'content' => [
                $salas->pluck('id'),
                $salas->pluck('nome'),
                $salas->pluck('telefone'),
                $salas->pluck('created_at'),
            ],
            'acoes' => [
                [
                    'link' => 'sala.edit',
                    'param' => 'sala_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                [
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

    @include('layouts.components.modais.modal', [
        'modalId' => 'editarSalaModal',
        'modalTitle' => 'Editar Sala',
        'formAction' => route('sala.update', ['sala_id' => ':id']),
        'type' => ('edit'),
        'fields' => [
            ['type' => 'hidden', 'name' => 'predio_id', 'id' => 'predio_id', 'value' => $predio->id],
            ['type' => 'text', 'name' => 'nome', 'id' => 'nome', 'label' => 'Nome:'],
            ['name' => 'telefone', 'id' => 'telefone', 'type' => 'text' , 'label' => 'Telefone:'],
        ]
    ])
    
@endsection

@push('scripts')
    <script>
        const salaUpdateRoute = "{{ route('sala.update', ['sala_id' => ':id']) }}"; 
        var SalaId = 0;

        $(document).ready(function () {
            $('#editarSalaModal').on('show.bs.modal', function(event) {
                var formAction = salaUpdateRoute.replace(':id', salaId); 
                $(this).find('form').attr('action', formAction);
            });
        });

        function openEditModal(id) {
            salaId = id;
            $('#editarSalaModal').modal('show');
        }
    </script>
@endpush
