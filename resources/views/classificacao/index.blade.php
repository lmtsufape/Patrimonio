@extends('layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Classificação Contábil',
        'addButtonModal' => 'cadastrarClassificacaoModal',
        'searchForm' => route ('classificacao.buscar'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Código' , 'Nome', 'Data de Criação', 'Ações'],
            'content' => [
                $classificacaos->pluck('id'),
                $classificacaos ->pluck ('codigo'),
                $classificacaos->pluck('nome'),
                $classificacaos->pluck('created_at')->map(function($date) {
                    return \Carbon\Carbon::parse($date)->format('d-m-Y');
                })
            ],
            'acoes' => [
                ['type' => 'edit' , 'link' => 'classificacao.edit', 'param' => 'classificacao_id', 'img' => asset('/images/pencil.png')],
                ['type' => 'delete' , 'link' => 'classificacao.delete', 'param' => 'classificacao_id', 'img' => asset('/images/delete.png')]
            ],
        ])
        <div class="d-flex justify-content-center mt-5">
            {{ $classificacaos->links('pagination::bootstrap-4') }}
        </div>

</div>

    @include('layouts.components.modais.modal', [
    'modalId' => 'cadastrarClassificacaoModal',
    'modalTitle' => 'Cadastrar Classificação',
    'type' => 'create',
    'formAction' => route('classificacao.store'),
    'fields' => [
        ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:'],
        ['type' => 'text','name' => 'codigo', 'id' => 'codigo',  'label' => 'Código'],
        ['type' => 'text','name' => 'residual', 'id' => 'residual',  'label' => 'Valor residual em meses (%):'],
        ['type' => 'text','name' => 'vida_util', 'id' => 'vida_util',  'label' => 'Vida útil (em meses):']
        ]
    ])

@include('layouts.components.modais.modal', [
    'modalId' => 'editarClassificacaoModal',
    'modalTitle' => 'Editar Classificação',
    'type' => 'edit',
    'formAction' => route('classificacao.update'),
    'fields' => [
        ['type' => 'text','name' => 'nome', 'id' => 'nome',  'label' => 'Nome:'],
        ['type' => 'text','name' => 'codigo', 'id' => 'codigo',  'label' => 'Código'],
        ['type' => 'text','name' => 'residual', 'id' => 'residual',  'label' => 'Valor residual em meses (%):'],
        ['type' => 'text','name' => 'vida_util', 'id' => 'vida_util',  'label' => 'Vida útil (em meses):']
        ]
    ])


@endsection
@push('scripts')
    <script>
        const editModal = $('#editarClassificacaoModal');
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