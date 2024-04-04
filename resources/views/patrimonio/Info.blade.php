@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4" style="width: 55%;">
        @include('layouts.components.header', ['page_title' => 'Detalhes do Patrimônio', 'back' => true])
        <div class="card-body">
            <div class="modal-body">
                <p><strong>Nome do Patrimônio:</strong> <span id="patrimonio_nome">{{ $patrimonio->nome }}</span></p>
                <p><strong>Classificação:</strong> <span id="classificacao">{{ $classificacao->nome }}</span></p>
                <p><strong>Valor Residual:</strong> <span id="valor_residual">R$ {{ number_format($classificacao->residual, 2, ',', '.') }}</span></p>
                <p><strong>Vida Útil:</strong> <span id="vida_util">{{ $classificacao->vida_util }} meses</span></p>
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
                
                <p><strong>Meses de Depreciação:</strong> <span id="meses">{{ $diferencaMeses }} meses</span></p>
                <p><strong>Valor Inicial do Item:</strong> R$ <span id="valor_inicial">{{ number_format($patrimonio->valor, 2, ',', '.') }}</span></p>
                <p><strong>Depreciação Atual do Item:</strong> R$ <span id="depreciacao_atual">{{ number_format($depreciacaoAtual, 2, ',', '.') }}</span></p>
                <p><strong>Valor Atual do Item:</strong> R$ <span id="valor_atual">{{ number_format($valorAtual, 2, ',', '.') }}</span></p>
            </div>
        </div>
    </div>
</div>

@endsection
