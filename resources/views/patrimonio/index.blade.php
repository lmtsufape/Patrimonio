@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')
    @include('layouts.components.searchbar', [
        'title' => 'Patrimônio',
        'addButton' => route('patrimonio.create'),
        'searchForm' => route('patrimonio.index'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Código', 'Prédio', 'Sala', 'Ações'],
            'content' => [
                $patrimonios->pluck('id'),
                $patrimonios->pluck('nome'),
                $patrimonios->pluck('codigos.*.codigo'),
                $patrimonios->pluck('sala.predio.nome'),
                $patrimonios->pluck('sala.nome'),
            ],
            'acoes' => [
                [
                    'modalId' => '',
                    'modalTitle' => '',
                    'modalInputs' => [
                                    ],
                    'link' => 'patrimonio.edit',
                    'param' => 'patrimonio_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'editLink',
                ],
                [
                    'modalId' => 'deleteConfirmationModal',
                    'modalTitle' => 'Tem certeza que deseja apagar este Patrimônio?',
                    'modalInputs' => [
                                    ],
                    'link' => 'patrimonio.delete',
                    'param' => 'patrimonio_id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],
                [
                    'modalId' => '',
                    'modalTitle' => '',
                    'modalInputs' => [
                                    ],
                    'link' => 'patrimonio.patrimonio',
                    'param' => 'patrimonio_id',
                    'img' => asset('/images/info.png'),
                    'type' => '',
                ],
            ],
       ])

        <div class="d-flex justify-content-center">
            {{ $patrimonios->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @stack('modais')

    @include('layouts.components.modais.filter-modal', [
        'modalTitle' => 'Filtrar patrimônio',
        'filterRoute' => route('patrimonio.index'),
        'modalContent' => [
            ['id' => 'predio_id', 'label' => 'Prédio', 'placeholder' => 'Selecione um prédio', 'options' => $predios->pluck('nome', 'id')],
            ['id' => 'servidor_id', 'label' => 'Servidor', 'placeholder' => 'Selecione um servidor', 'options' => $servidores->pluck('user.name', 'id')],
            ['id' => 'situacao_id', 'label' => 'Situacao', 'placeholder' => 'Selecione uma situação', 'options' => $situacoes->pluck('nome', 'id')],
            ['id' => 'origem_id', 'label' => 'Origem', 'placeholder' => 'Selecione uma origem' , 'options' => $origens->pluck('nome', 'id')],
            ['id' => 'unidade_admin_id', 'label' => 'Unidades', 'placeholder' => 'Selecione uma unidade administrativa', 'options' => $unidades->pluck('nome', 'id')],
            ['id' => 'classificacao_id', 'label' => 'Classificação', 'placeholder' => 'Selecione uma classificação', 'options' => $classificacoes->pluck('nome', 'id')]
        ]
    ])

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar este Patrimonio?',
        'route' => route('patrimonio.delete', ['patrimonio_id' => ':id']),
    ])

@endsection

@push('scripts')
    <script src="{{ asset('js/filter.js') }}"></script>

    <script>
        var patrimonioId = 0;
        const patrimonioDeleteRoute = "{{ route('patrimonio.delete', ['patrimonio_id' => ':id']) }}";

        function openDeleteModal(id) {
            patrimonioId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = patrimonioDeleteRoute.replace(':id', patrimonioId);
                $(this).find('form').attr('action', formAction);
            });
        });
    </script>
@endpush
