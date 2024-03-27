@extends('layouts.app')

@push('styles')
    <style>
        
    </style>
@endpush

@section('content')
    <div class="container mt-5 mx-auto">
        <div class="mb-4">
            <div class="row align-items-start">
                <h1 class="display-6 text-nowrap" style="font-weight: 500; font-size: 34px; color: #676767;">
                    <strong>
                        <a href="{{ route('patrimonio.index') }}" class="text-decoration-none link-primary"><span
                                style="color: #3252C1">Patrimônio</span></a>
                        > Editar Patrimônio
                    </strong>
                </h1>
            </div>
        </div>
        <div>
        <form method="POST" action="{{ route('patrimonio.update', ['id' => $patrimonio->id]) }}">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col">
                    <label for="nome" class="form-label labels">Nome do
                        item: <span class="red-asterisk">*</span></label>
                    <input type="text" class="form-control inputs" name="nome" id="nome" value="{{ old('nome', $patrimonio->nome) }}" required>
                </div>
                <div class="col">
                    <label for="descricao" class="form-label labels">Descrição: <span
                            class="red-asterisk">*</span></label>
                    <input type="text" class="form-control inputs" name="descricao" id="descricao" value="{{ old('descricao', $patrimonio->descricao) }}"required>
                </div>
                <div class="col">
                    <label for="setor" class="form-label labels">Setor: <span class="red-asterisk">*</span></label>
                    <select class="form-select selects inputs" aria-label="Selecione um setor" id="setor_id" name="setor_id">
                        <option selected value="">Selecione um setor</option>
                        @foreach ($setores as $setor)
                            <option value="{{ $setor->id }}" {{ old('setor_id', $patrimonio->setor_id) == $setor->id ? 'selected' : '' }}>{{ $setor->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="classificacao" class="form-label labels">Classificação: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects inputs" aria-label="Selecione uma classificação"
                        id="subgrupo_id" name="subgrupo_id">
                        <option selected value="">Selecione uma classificação</option>
                        @foreach ($subgrupos as $subgrupo)
                            <option value="{{ $subgrupo->id }}" {{ old('subgrupo_id', $patrimonio->subgrupo_id) == $subgrupo->id ? 'selected' : '' }}>{{ $subgrupo->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="origem" class="form-label labels">Origem: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects inputs" aria-label="Selecione uma Origem" id="origem_id"
                        name="origem_id">
                        <option selected value="">Selecione uma Origem</option>
                        @foreach ($origens as $origem)
                        <option value="{{ $origem->id }}" {{ old('origem_id', $patrimonio->origem_id) == $origem->id ? 'selected' : '' }}>{{ $origem->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="situacao" class="form-label labels">Situação: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects inputs" aria-label="Selecione uma Situação" id="situacao_id"
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
                    <label for="predio" class="form-label labels">Prédio: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects inputs" onchange="filtrarSalas()"
                        aria-label="Selecione um prédio" id="predio_id" name="predio_id">
                        <option selected value="">Selecione um prédio</option>
                        @foreach ($predios as $predio)
                        <option value="{{ $predio->id }}" {{ $patrimonio->sala->predio_id == $predio->id ? 'selected' : '' }}>{{ $predio->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="sala" class="form-label labels">Sala: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects inputs" aria-label="Selecione uma sala" id="sala_id"
                        name="sala_id">
                        <option selected value="">Selecione uma sala</option>
                    </select>
                </div>
                <div class="col">
                    <label for="servidor" class="form-label labels">Servidor: <span
                            class="red-asterisk">*</span></label>
                    <select class="form-select selects inputs" aria-label="Selecione um servidor" id="servidor_id"
                        name="servidor_id">
                        <option selected value="">Selecione um servidor</option>
                        @foreach ($servidores as $servidor)
                        <option value="{{ $servidor->id }}" {{ old('servidor_id', $patrimonio->servidor_id) == $servidor->id ? 'selected' : '' }}>{{ $servidor->user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="data_compra" class="form-label labels">Data de compra: <span
                            class="red-asterisk">*</span></label>
                    <input type="date" class="form-control selects inputs" name="data_compra" id="data_compra" value="{{ old('data_compra', $patrimonio->data_compra)}}" >
                </div>
                <div class="col">
                    <label for="valor" class="form-label labels">Valor do item:</label>
                    <input type="number" class="form-control inputs" name="valor" id="valor" value="{{ old('valor', $patrimonio->valor)}}" required>
                </div>
                <div class="col">
                    <label for="contaContabil" class="form-label labels">Conta contábil: <span
                            class="red-asterisk">*</span></label>
                    <input type="text" class="form-control inputs" name="contaContabil" id="contaContabil" value="{{ old('contaContabil', $patrimonio->contaContabil)}}"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="empenho" class="form-label labels">Empenho: <span
                            class="red-asterisk">*</span></label>
                    <input type="text" class="form-control inputs" name="empenho" id="empenho" value="{{ old('empenho', $patrimonio->empenho)}}" required>
                </div>
                <div class="col">
                    <label for="nota_fiscal" class="form-label labels">Nota fiscal: <span
                            class="red-asterisk">*</span></label>
                    <input type="text" class="form-control inputs" name="nota_fiscal" id="nota_fiscal" value="{{ old('nota_fiscal', $patrimonio->nota_fiscal)}}">
                </div>
                <div class="col">
                    <label for="processoLicitacao" class="form-label labels">Processo de licitação:</label>
                    <select class="form-select selects inputs" aria-label="Selecione o processo de licitação"
                        id="processoLicitacao" name="processoLicitacao" value="{{ old('processoLicitacao', $patrimonio->processoLicitacao)}}">
                        <option selected value="">Selecione o processo de licitação</option>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-3">
                    <label for="#" class="mb-2 labels">Bem privado? <span
                            class="red-asterisk">*</span></label>
                    <div class="form-check d-flex justify-content-between px-0 me-4">
                        <input class="btn-check" type="radio" name="bemPrivado" id="privadoSim"
                            value="1">
                        <label class="btn btn-primary col-5 py-2 radio-label" for="privadoSim"
                            style="background-color: #1A2876;">
                            SIM
                        </label>
                        <input class="btn-check" type="radio" name="bemPrivado" id="privadoNao"
                            value="0" checked>
                        <label class="btn btn-secondary col-5 py-2 radio-label" for="privadoNao">
                            NÃO
                        </label>
                    </div>
                </div>
                <div class="col">
                    <label for="observacao" class="form-label labels">Observações pertinentes a este
                        patrimônio:</label>
                    <textarea class="form-control" id="observacao" name="observacao" rows="4"></textarea>
                </div>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-auto">
                    <button class="btn btn-primary submit radio-label p-2"
                        style="background-color: #3252C1; height: 120%; width: 140%; font-weight: 500; font-size: 27px">Cadastrar</button>
                </div>
            </div>
            </form>
        </div>
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
