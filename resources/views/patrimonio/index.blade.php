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

    <div class="collapse mb-3 col-4 ms-auto" id="filter-options">
        <form id="filter-form" action="{{ route('patrimonio.index') }}" method="GET">
            <div class="card card-body">
                <input type="hidden" name="busca" id="filter-search">

                <div class="row mb-2">
                    <div class="col-4">
                        <label for="predio_id">Prédio</label>
                        <select class="form-select" name="predio_id" id="predio_id">
                            <option value="" selected>Selecione um prédio</option>
                            @foreach ($predios as $predio)
                                <option value="{{ $predio->id }}">{{ $predio->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4">
                        <label for="servidor_id">Servidor</label>
                        <select class="form-select" name="servidor_id" id="servidor_id">
                            <option value="" selected>Selecione um servidor</option>
                            @foreach ($servidores as $servidor)
                                <option value="{{ $servidor->id }}">{{ $servidor->user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4">
                        <label for="situacao_id">Situação</label>
                        <select class="form-select" name="situacao_id" id="situacao_id">
                            <option value="" selected>Selecione uma situação</option>
                            @foreach ($situacoes as $situacao)
                                <option value="{{ $situacao->id }}">{{ $situacao->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <label for="origem_id">Origem</label>
                        <select class="form-select" name="origem_id" id="origem_id">
                            <option value="" selected>Selecione uma origem</option>
                            @foreach ($origens as $origem)
                                <option value="{{ $origem->id }}">{{ $origem->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4">
                        <label for="setor_id">Setor</label>
                        <select class="form-select" name="setor_id" id="setor_id">
                            <option value="" selected>Selecione um setor</option>
                            @foreach ($setores as $setor)
                                <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4">
                        <label for="classificacao_id">Classificação</label>
                        <select class="form-select" name="classificacao_id" id="classificacao_id">
                            <option value="" selected>Selecione uma classificação</option>
                            @foreach ($classificacoes as $classificacao)
                                <option value="{{ $classificacao->id }}">{{ $classificacao->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card card-footer">
                <button class="btn btn-primary" type="submit">
                    Filtrar
                </button>
            </div>
        </form>

    </div>

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Prédio', 'Sala', 'Ações'],
            'content' => [
                $patrimonios->pluck('id'),
                $patrimonios->pluck('nome'),
                $patrimonios->pluck('sala.predio.nome'),
                $patrimonios->pluck('sala.nome'),
            ],
            'acoes' => [
                [
                    'link' => 'patrimonio.edit',
                    'param' => 'patrimonio_id',
                    'img' => asset('/images/pencil.png'),
                    'type' => 'editLink',
                ],
                [
                    'link' => 'patrimonio.delete',
                    'param' => 'patrimonio_id',
                    'img' => asset('/images/delete.png'),
                    'type' => 'delete',
                ],
                [
                    'link' => 'patrimonio.patrimonio',
                    'param' => 'patrimonio_id',
                    'img' => asset('/images/info.png'),
                    'type' => '',
                ],
            ],
        ])

        <div class="d-flex justify-content-center">
            {{ $patrimonios->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#busca').on('change', function() {
                setSearchValue();
            });

            $('#filter-form').submit(function(event) {
                $(this).find('select').each(function () {
                    if ($(this).val() == '') {
                        $(this).prop('disabled', true);
                    }
                });

                if ($('#filter-search').val() == '') {
                    $('#filter-search').prop('disabled', true);
                }
            });

            setSearchValue();
        });

        function setSearchValue() {
            $('#filter-search').val($('#busca').val());
        }
    </script>
@endpush
