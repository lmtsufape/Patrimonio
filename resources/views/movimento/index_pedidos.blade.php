@extends('layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Movimentações de Patrimonios',
        'searchForm' => route('movimento.buscar'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['#', 'Servidor de Origem', 'Servidor de Destino', 'Tipo do Movimento', 'Itens do Movimento', 'Ações'],

            'content' => [
                $movimentos->pluck('id'),
                $movimentos->map(function ($movimento) {
                    return $movimento->userOrigem->name;
                }),
                $movimentos->map(function ($movimento) {
                    return $movimento->userDestino->name;
                }),
                $movimentos->map(function ($movimento) {
                    return array_search($movimento->tipo, $movimento::$tipos);
                }),
                $movimentos->map(function ($movimento) {
                    return $movimento->patrimonios()->pluck('nome');
                }),
            ],

            'acoes' => [
                [
                    'link' => 'movimento.reprovar',
                    'param' => 'id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'editar',
                ],
                [
                    'link' => 'movimento.reprovar',
                    'param' => 'id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],

            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $movimentos->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar esta Movimentação?',
        'route' => route('movimento.delete', ['movimento_id' => 'id']),
    ])


@endsection

@push('scripts')
    <script>
        const movimentacaoDeleteRoute = "http://127.0.0.1:8000/movimento/id/delete";
        var movimentoId = 0;
        function openDeleteModal(id) {
            movimentoId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                var formAction = movimentacaoDeleteRoute.replace('id', movimentoId);
                $(this).find('form').attr('action', formAction);
            });
        });


    </script>
@endpush
