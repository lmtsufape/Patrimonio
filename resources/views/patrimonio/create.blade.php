@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">

    <style>
        label{
            color: #1A2876;
            
        }
        .red-asterisk {
            color: #AA2E2E;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5 mx-auto">

        @include('layouts.components.searchbar', [
            'title' => 'Patrimônios > Cadastrar',
            'titleLink' => Route('patrimonio.index'),
        ])

        <div>
            <form action="{{ route('patrimonio.store') }}" method="post">
                @csrf

                <div class="row mb-3">
                    <div class="form-group col-md-4">
                        <label for="nome" class="form-label fw-bold">Nome do
                            item: <span class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="nome" id="nome" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="descricao" class="form-label fw-bold">Descrição: <span
                                class="red-asterisk">*</span></label>
                        <textarea type="text" class="form-control" rows="1" name="descricao" id="descricao" ></textarea>
                    </div>
                    <div class="form-group col">
                        <label for="origem" class="form-label fw-bold">Origem: <span
                                class="red-asterisk">*</span></label>
                        <select class="form-select" aria-label="Selecione uma Origem" id="origem_id"
                            name="origem_id">
                            <option selected value="">Selecione uma Origem</option>
                            @foreach ($origens as $origem)
                                <option value="{{ $origem->id }}">{{ $origem->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group col">
                        <label for="classificacao" class="form-label fw-bold">Classificação</label>
                        <select class="form-select" name="classificacao" id="classificacao">
                            <option selected value="">Selecione uma classificação</option>
                            @foreach ($classificacoes as $classificacao)
                                <option value="{{$classificacao->id}}">{{$classificacao->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="classificacao" class="form-label fw-bold">Subgrupo: <span
                                class="red-asterisk">*</span></label>
                        <select class="form-select" aria-label="Selecione uma classificação"
                            id="subgrupo_id" name="subgrupo_id">
                            <option selected value="">Selecione um subgrupo</option>
                            @foreach ($subgrupos as $subgrupo)
                                <option value="{{ $subgrupo->id }}">{{ $subgrupo->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="situacao" class="form-label fw-bold">Situação: <span
                                class="red-asterisk">*</span></label>
                        <select class="form-select" aria-label="Selecione uma Situação" id="situacao_id"
                            name="situacao_id">
                            <option selected value="">Selecione uma Situação</option>
                            @foreach ($situacoes as $situacao)
                                <option value="{{ $situacao->id }}">{{ $situacao->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="form-group col">
                        <label for="predio" class="form-label fw-bold">Prédio: <span
                                class="red-asterisk">*</span></label>
                        <select class="form-select" onchange="filtrarSalas()"
                            aria-label="Selecione um prédio" id="predio_id" name="predio_id">
                            <option selected value="">Selecione um prédio</option>
                            @foreach ($predios as $predio)
                                <option value="{{ $predio->id }}">{{ $predio->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="unidade" class="form-label fw-bold">Unidade Administrativa: <span class="red-asterisk">*</span></label>
                        <select class="form-select" aria-label="Selecione uma unidade" id="unidade_admin_id" name="unidade_admin_id">
                            <option selected value="">Selecione uma Unidade Administrativa</option>
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="sala" class="form-label fw-bold">Sala: <span
                                class="red-asterisk">*</span></label>
                        <select class="form-select" aria-label="Selecione uma sala" id="sala_id"
                            name="sala_id">
                            <option selected value="">Selecione uma sala</option>
                        </select>
                    </div>
                    
                </div>

                <div class="row mb-3">
                    <div class="form-group col">
                        <label for="data_compra" class="form-label fw-bold">Data da Nota Fiscal: <span
                                class="red-asterisk">*</span></label>
                        <input type="date" class="form-control" name="data_compra" id="data_compra">
                    </div>
                    <div class="form-group col">
                        <label for="data_incorporação" class="form-label fw-bold">Data de Incorporação: <span
                                class="red-asterisk">*</span></label>
                        <input type="date" class="form-control" name="data_incorporação" id="data_incorporação">
                    </div>
                    <div class="form-group col">
                        <label for="valor" class="form-label fw-bold">Valor do item:</label>
                        <input type="number" class="form-control" name="valor" id="valor" required>
                    </div>
                    <div class="form-group col">
                        <label for="conta_contabil" class="form-label fw-bold">Conta contábil: <span
                                class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="conta_contabil" id="conta_contabil"
                            required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="empenho" class="form-label fw-bold">Empenho: <span
                                class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="empenho" id="empenho" required>
                    </div>
                    <div class="col">
                        <label for="nota_fiscal" class="form-label fw-bold">Nota fiscal: <span
                                class="red-asterisk">*</span></label>
                        <input type="text" class="form-control" name="nota_fiscal" id="nota_fiscal">
                    </div>
                    <div class="col">
                        <label for="processoLicitacao" class="form-label fw-bold">Processo de licitação:</label>
                        <select class="form-select" aria-label="Selecione o processo de licitação"
                            id="processoLicitacao" name="processoLicitacao">
                            <option selected value="">Selecione o processo de licitação</option>
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="servidor" class="form-label fw-bold">Servidor: <span
                                class="red-asterisk">*</span></label>
                        <select class="form-select" aria-label="Selecione um servidor" id="user_id"
                            name="user_id">
                            <option selected value="">Selecione um servidor</option>
                            @foreach ($servidores as $servidor)
                                <option value="{{ $servidor->id }}">{{ $servidor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="col">
                        <label for="observacao" class="form-label fw-bold">Observações pertinentes a este
                            patrimônio:</label>
                        <textarea class="form-control" id="observacao" name="observacao" rows="4"></textarea>
                    </div>
                </div>

                <div class="row justify-content-center mb-5 mt-5">
                    <div class="col-auto">
                        <button class="btn btn-blue btn-lg" type="submit">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Convertendo os dados PHP para JavaScript
        var predios = {!! json_encode($predios) !!};

        function filtrarSalas() {
            // Obter o valor selecionado do prédio
            var predioSelecionadoId = document.getElementById("predio_id").value;

            // Encontrar o prédio selecionado nos dados carregados
            var predioSelecionado = predios.find(function(predio) {
                return predio.id == predioSelecionadoId;
            });

            // Obter as salas do prédio selecionado
            var salasDoPredio = predioSelecionado ? predioSelecionado.salas : [];

            // Atualizar as opções do select de salas
            var selectSala = document.getElementById("sala_id");

            // Limpar as opções existentes
            selectSala.innerHTML = "";

            // Adicionar as novas opções
            for (var i = 0; i < salasDoPredio.length; i++) {
                var option = document.createElement("option");
                option.text = salasDoPredio[i].nome;
                option.value = salasDoPredio[i].id;
                selectSala.add(option);
            }
        }
    </script>
@endpush