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
                    'img' => asset('/assets/vision.svg'),
                    'type' => 'link',
                ],
                [
                    'link' => 'movimento.reprovar',
                    'param' => 'id',
                    'img' => asset('/assets/cancel.svg'),
                    'type' => 'link',
                ],
                [
                    'link' => 'movimento.aprovar',
                    'param' => 'id',
                    'img' => asset('/assets/check.svg'),
                    'type' => 'link',
                ],

            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $movimentos->links('pagination::bootstrap-4') }}
        </div>
    </div>




@endsection

@push('scripts')

@endpush
