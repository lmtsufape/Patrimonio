@extends('layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
            'title' => 'Patrimônios > Relatórios',
            'titleLink' => Route('patrimonio.index'),
    ])
    <div class="col-md-10 mx-auto">
        <form method="GET" action="{{ route('patrimonio.relatorio.index') }}" class="mb-3">
            <div class="row">
                <div class="col">
                    <label for="unidade_admin_id" class="form-label">Unidade Administrativa:</label>
                    <select name="unidade_admin_id" id="unidade_admin_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="situacao_id" class="form-label">Situação:</label>
                    <select name="situacao_id" id="situacao_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($situacoes as $situacao)
                            <option value="{{ $situacao->id }}">{{ $situacao->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="ano" class="form-label">Ano de Compra:</label>
                    <select name="ano" id="ano" class="form-select">
                        <option value="">Todos</option>
                        @for ($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mt-4">Filtrar</button>
                </div>
            </div>
        </form>

        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Prédio', 'Sala', 'Ações'],
            'content' => [$patrimonios->pluck('id'), $patrimonios->pluck('nome'), $patrimonios->pluck('sala.predio.nome'), $patrimonios->pluck('sala.nome')],
            'acoes' => [
                ['type'=> 'editLink' ,'link' => 'patrimonio.relatorio.pdf', 'param' => 'id', 'img' => asset('/assets/relatorio.svg')],
            ]
        ])

        <div class="d-flex justify-content-center">
            {{ $patrimonios->links('pagination::bootstrap-4') }}
        </div>
    </div>

@endsection