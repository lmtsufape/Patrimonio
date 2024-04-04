@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')
    @include('layouts.components.searchbar', [
        'title' => 'Patrimônio',
        'addButton' => route('patrimonio.create'),
        'searchForm' => route('patrimonio.busca.get'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Prédio', 'Sala', 'Ações'],
            'content' => [$patrimonios->pluck('id'), $patrimonios->pluck('nome'), $patrimonios->pluck('sala.predio.nome'), $patrimonios->pluck('sala.nome')],
            'acoes' => [
                ['link' => 'patrimonio.edit', 'param' => 'patrimonio_id', 'img' => asset('/images/pencil.png') , 'type' =>'editLink'],
                ['link' => 'patrimonio.delete', 'param' => 'patrimonio_id', 'img' => asset('/images/delete.png'), 'type' =>'delete'],
                ['link' => 'patrimonio.patrimonio', 'param' => 'patrimonio_id', 'img' => asset('/images/info.png'), 'type' =>''],
            ]
        ])

        <div class="d-flex justify-content-center">
            {{ $patrimonios->links('pagination::bootstrap-5') }}
        </div>
    </div>
    
@endsection

@push('scripts')

@endpush
