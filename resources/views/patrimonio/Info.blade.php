@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4" style="width: 55%;">
        @include('layouts.components.header', ['page_title' => 'Detalhes do Patrimônio', 'back' => true])
        <div class="card-body">
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="col-md-6">
                        <p><strong>Nome do Patrimônio:</strong> <span id="patrimonio_nome">{{ $patrimonio->nome }}</span></p>
                        <p><strong>Servidor:</strong> <span id="servidor">{{ $patrimonio->user->name }}</span></p>
                        <p><strong>Nota Fiscal:</strong> <span id="nota_fiscal">{{ $patrimonio->nota_fiscal }}</span></p>
                        <p><strong>Descrição:</strong> <span id="descricao">{{ $patrimonio->descricao }}</span></p>
                        <p><strong>Valor:</strong> <span id="valor">R$ {{ number_format($patrimonio->valor, 2, ',', '.') }}</span></p>
                        <p><strong>Data de Compra:</strong> <span id="data_compra">{{ $patrimonio->data_compra }}</span></p>
                        <p><strong>Data de Incorporação:</strong> <span id="data_incorporacao">{{ $patrimonio->data_incorporação }}</span></p>
                    </div>
                    <div class="col-md-6">
                                <p><strong>Localização:</strong></p>
                                <p>
                                    <strong>Unidade Administrativa:</strong> {{ $patrimonio->unidAdmin->nome ?? 'Não especificado'}}
                                </p>
                                <p>
                                    <strong>Prédio:</strong> {{ $patrimonio->sala->predio->nome ?? 'Não especificado' }}
                                </p>
                                <p>
                                    <strong>Sala:</strong> {{ $patrimonio->sala->nome ?? 'Não especificado' }}
                                </p>
                    </div>
                </div>
                <hr>
                @php
                    // Calcular depreciação mensal
                    $depreciacaoMensal = (($patrimonio->valor - $classificacao->residual) / $classificacao->vida_util);
                    
                    // Calcular diferença em meses entre data de compra e data atual
                    $dataCompra = new DateTime($patrimonio->data_compra);
                    $dataAtual = new DateTime();
                    $diferencaMeses = $dataCompra->diff($dataAtual)->format('%m') + 12 * $dataCompra->diff($dataAtual)->format('%y');
                    
                    // Calcular depreciação atual e valor atual do item
                    $depreciacaoAtual = $diferencaMeses * $depreciacaoMensal;
                    $valorAtual = $patrimonio->valor - $depreciacaoAtual;
                @endphp
                <h5> Detalhe Contábil </h5>
                <p><strong>Meses de Depreciação:</strong> <span id="meses">{{ $diferencaMeses }} meses</span></p>
                <p><strong>Valor Inicial do Item:</strong> R$ <span id="valor_inicial">{{ number_format($patrimonio->valor, 2, ',', '.') }}</span></p>
                <p><strong>Depreciação Atual do Item:</strong> R$ <span id="depreciacao_atual">{{ number_format($depreciacaoAtual, 2, ',', '.') }}</span></p>
                <p><strong>Valor Atual do Item:</strong> R$ <span id="valor_atual">{{ number_format($valorAtual, 2, ',', '.') }}</span></p>
            </div>
        </div>
    </div>
</div>

@endsection
