@extends('layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Classificação Contábil',
        'addButton' => route ('classificacao.create'),
        'searchForm' =>('#'),
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
                ['link' => 'classificacao.edit', 'param' => 'classificacao_id', 'img' => asset('/images/pencil.png')],
            ],
        ])
        <div class="d-flex justify-content-center mt-5">
            {{ $classificacaos->links('pagination::bootstrap-4') }}
        </div>

</div>

   
    <script>

    </script>
@endsection
