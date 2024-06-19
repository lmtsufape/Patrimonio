@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">

    <style>
        label {
            color: #1A2876;

        }
        .red-asterisk {
            color: #AA2E2E;
        }

    </style>
@endpush

@section('content')
    @include('layouts.components.searchbar', [
        'title' => 'Patrimônios > Editar',
        'titleLink' => Route('patrimonio.index'),
    ])

    <div>
        <form method="POST" action="{{ route('patrimonio.update', ['id' => $patrimonio->id]) }}">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col">
                    <label for="nome" class="form-label fw-bold">Nome do
                        item: <span class="red-asterisk">*</span></label>
                    <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $patrimonio->nome) }}" required></textarea>
                </div>
                <div class="col">
                    <label for="descricao" class="form-label fw-bold">Descrição: <span
                            class="red-asterisk">*</span></label>
                    <textarea type="text" class="form-control" rows="2" name="descricao" id="descricao" value="{{old('descricao', $patrimonio->descricao) }}"required>{{$patrimonio->descricao}}</textarea>
                </div>
                <div class="col">
                    <label for="origem" class="form-label fw-bold">Origem: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects" aria-label="Selecione uma Origem" id="origem_id"
                        name="origem_id">
                        <option selected value="">Selecione uma Origem</option>
                        @foreach ($origens as $origem)
                            <option value="{{ $origem->id }}" {{ old('origem_id', $patrimonio->origem_id) == $origem->id ? 'selected' : '' }}>{{ $origem->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="classificacao_id" class="form-label fw-bold">Classificação: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects" aria-label="Selecione uma classificação"{{-- preciso ver direito essa parte de classificacao e subgrupo --}}
                        id="classificacao_id" name="classificacao_id">
                        <option selected value="">Selecione uma classificação</option>
                        @foreach ($classificacoes as $classificacao)
                            <option value="{{ $classificacao->id }}" {{ old('classificacao_id', $patrimonio->subgrupo->classificacao_id) == $classificacao->id ? 'selected' : '' }}>{{ $classificacao->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col">
                    <label for="subgrupo_id" class="form-label fw-bold">Subgrupo: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select" aria-label="Selecione um Subgrupo"
                        id="subgrupo_id" name="subgrupo_id">
                        @foreach ($subgrupos as $subgrupo)
                            <option value="{{ $subgrupo->id }} {{ old('subgrupo_id', $patrimonio->subgrupo_id) == $subgrupo->id ? 'selected' : '' }}">{{ $subgrupo->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="situacao" class="form-label fw-bold">Situação: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects" aria-label="Selecione uma Situação" id="situacao_id"
                        name="situacao_id">
                        <option selected value="">Selecione uma Situação</option>
                        @foreach ($situacoes as $situacao)
                            <option value="{{ $situacao->id }}" {{ old('situacao_id', $patrimonio->situacao_id) == $situacao->id ? 'selected' : '' }}>{{ $situacao->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="predio" class="form-label fw-bold">Prédio: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects" onchange="filtrarSalas()"
                        aria-label="Selecione um prédio" id="predio_id" name="predio_id">
                        <option selected value="">Selecione um prédio</option>
                        @foreach ($predios as $predio)
                        <option value="{{ $predio->id }}" {{ $patrimonio->sala->predio_id == $predio->id ? 'selected' : '' }}>{{ $predio->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="unidade" class="form-label fw-bold">Unidade Administrativa: <span class="red-asterisk">*</span></label>
                    <select class="form-select selects" aria-label="Selecione um Unidade Administrativa" id="unidade_admin_id" name="unidade_admin_id">
                        <option selected value="">Selecione um Unidade Administrativa</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}" {{ old('unidade_admin_id', $patrimonio->unidade_admin_id) == $unidade->id ? 'selected' : '' }}>{{ $unidade->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="sala" class="form-label fw-bold">Sala: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects" aria-label="Selecione uma sala" id="sala_id"
                        name="sala_id">
                        <option selected value="">Selecione uma sala</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="data_compra" class="form-label fw-bold">Data da Nota Fiscal: <span
                            class="red-asterisk">*</span></label>
                    <input type="date" class="form-control selects" name="data_compra" id="data_compra" value="{{ old('data_compra', $patrimonio->data_compra)}}">
                </div>
                <div class="form-group col">
                    <label for="data_incorporacao" class="form-label fw-bold">Data de Incorporação: <span
                            class="red-asterisk">*</span></label>
                    <input type="date" class="form-control" name="data_incorporacao" id="data_incorporacao" value="{{old('data_incorporacao', $patrimonio->data_incorporacao)}}">
                </div>
                <div class="col">
                    <label for="valor" class="form-label fw-bold">Valor do item:</label>
                    <input type="number" class="form-control" name="valor" id="valor" value="{{number_format($patrimonio->valor, 2, '.', '')}}" required>
                </div>
                <div class="col">
                    <label for="conta_contabil" class="form-label fw-bold">Conta contábil: <span
                            class="red-asterisk">*</span></label>
                    <input type="text" class="form-control" name="conta_contabil" id="conta_contabil" value="{{ old('conta_contabil', $patrimonio->conta_contabil)}}"
                        required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col">
                    <label for="empenho" class="form-label fw-bold">Empenho: <span
                            class="red-asterisk">*</span></label>
                    <input type="text" class="form-control" name="empenho" id="empenho" value="{{ old('empenho', $patrimonio->empenho)}}" required>
                </div>
                <div class="col">
                    <label for="nota_fiscal" class="form-label fw-bold">Nota fiscal: <span
                            class="red-asterisk">*</span></label>
                    <input type="text" class="form-control" name="nota_fiscal" id="nota_fiscal" value="{{ old('nota_fiscal', $patrimonio->nota_fiscal)}}">
                </div>
                <div class="col">
                    <label for="processo_licitacao" class="form-label fw-bold">Processo de licitação:</label>
                    <input type="number" class="form-control" id="processo_licitacao" name="processo_licitacao" value="{{ old('processo_licitacao', $patrimonio->processo_licitacao)}}">

                </div>
                <div class="col">
                    <label for="user_id" class="form-label fw-bold">Servidor: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects" aria-label="Selecione um servidor" id="user_id"
                        name="user_id">
                        <option selected value="">Selecione um servidor</option>
                        @foreach ($servidores as $servidor)
                            <option value="{{ $servidor->id }}" {{ old('user_id', $patrimonio->user_id) == $servidor->id ? 'selected' : '' }}>{{ $servidor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col">
                <label for="observacao" class="form-label fw-bold">Observações pertinentes a este
                    patrimônio:</label>
                <textarea class="form-control" id="observacao" name="observacao" rows="4"></textarea>
            </div>


            <div class="row justify-content-center mb-5 mt-5">
                <div class="col-auto">
                    <button class="btn btn-blue btn-lg" type="submit">Editar</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>

var predios = {!! json_encode($predios) !!};

function filtrarSalas() {

    var predioSelecionadoId = document.getElementById("predio_id").value;


    var predioSelecionado = predios.find(function(predio) {
        return predio.id == predioSelecionadoId;
    });

    var salasDoPredio = predioSelecionado ? predioSelecionado.salas : [];


    var selectSala = document.getElementById("sala_id");


    selectSala.innerHTML = "";

    for (var i = 0; i < salasDoPredio.length; i++) {
        var option = document.createElement("option");
        option.text = salasDoPredio[i].nome;
        option.value = salasDoPredio[i].id;
        selectSala.add(option);
    }
}
    </script>
@endpush
