@extends('layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
        <link rel="stylesheet" href="/css/modal.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Subgrupos',
        'addButtonModal' => ('cadastrarSubgrupoModal'),
        'searchForm' =>  route('subgrupo.buscar'),
    ])

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Marca', 'Modelo', 'Classificação', 'Ações'],
            'content' => [
                $subgrupos->pluck('id'),
                $subgrupos->pluck('nome'),
                $subgrupos->pluck('marca'),
                $subgrupos->pluck('modelo'),
                $subgrupos->map(function ($subgrupo) {
                    return $subgrupo->classificacao->nome; 
                }),
            ],
            'acoes' => [
                [
                    'link' => 'subgrupo.edit',
                    'param' => 'subgrupo_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'edit',
                ],
                ['link' => 'subgrupo.delete', 'param' => 'subgrupo_id', 'img' => asset('/images/delete.png') , 'type' => 'delete'],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $subgrupos->links('pagination::bootstrap-4') }}
        </div>
    </div>

        @include('layouts.components.modais.modal', [
        'modalId' => 'cadastrarSubgrupoModal',
        'modalTitle' => 'Cadastrar Subgrupo',
        'formAction' => route('subgrupo.store'), 
        'type'=> 'create',
        'fields' => [
            ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
            ['name' => 'marca', 'id' => 'marca', 'type' => 'text', 'label' => 'Marca:'],
            ['name' => 'modelo', 'id' => 'Modelo', 'type' => 'text', 'label' => 'Modelo:'],
            [
            'name' => 'classificacao_id',
            'id' => 'classificacao_id',
            'type' => 'select',
            'label' => 'Classificação:',
            'options' => $classificacoes->pluck('nome'), 
            'placeholder' => 'Escolha uma Classificação'
            ],
    ],
    ])

    @include('layouts.components.modais.modal', [
        'modalId' => 'editarSubgrupoModal',
        'modalTitle' => 'Editar Subgrupo',
        'formAction' => route('unidade.update', ['id' => 'id']),
        'type'=> 'edit',
        'fields' => [
            ['name' => 'nome', 'id' => 'nome', 'type' => 'text', 'label' => 'Nome:'],
            ['name' => 'marca', 'id' => 'marca', 'type' => 'text', 'label' => 'Marca:'],
            ['name' => 'modelo', 'id' => 'Modelo', 'type' => 'text', 'label' => 'Modelo:'],
            [
            'name' => 'classificacao_id',
            'id' => 'classificacao_id',
            'type' => 'select',
            'label' => 'Classificação:',
            'options' => $classificacoes->pluck('nome'), 
            'placeholder' => 'Escolha uma Classificação'
            ],
    ],
    ])

@endsection

@push('scripts')

    <script>
            const subgrupoUpdateRoute = "{{ route('subgrupo.update', ['id' => ':id']) }}"; 
            var subgrupoId = 0;

            $(document).ready(function () {
                $('#editarSubgrupoModal').on('show.bs.modal', function(event) {
                    var formAction = subgrupoUpdateRoute.replace(':id', subgrupoId); 
                    $(this).find('form').attr('action', formAction);
                });
            });

            function openEditModal(id) {
                subgrupoId = id;
                $('#editarSubgrupoModal').modal('show');
            }

    </script>

@endpush