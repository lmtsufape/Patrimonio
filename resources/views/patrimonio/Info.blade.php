@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4" style="width: 55%;">
        @include('layouts.components.header', ['page_title' => 'Detalhes do Patrimônio', 'back' => true])
        <div class="card-body">
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="row">
                        <div class="col-md-6 ">
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
                            <p><strong>Unidade Administrativa:</strong> {{ $patrimonio->unidade->nome ?? 'Não especificado'}}</p>
                            <p><strong>Prédio:</strong> {{ $patrimonio->sala->predio->nome ?? 'Não especificado' }}</p>
                            <p><strong>Sala:</strong> {{ $patrimonio->sala->nome ?? 'Não especificado' }}</p>
                        </div>
                    </div>
                </div>
                <hr>
                <h5> Detalhe Contábil </h5>
                <hr>
                <p><strong>Meses de Depreciação:</strong> <span id="meses"></span></p>
                <p><strong>Valor Inicial do Item:</strong> R$ <span id="valor_inicial"></span></p>
                <p><strong>Depreciação Atual do Item:</strong> R$ <span id="depreciacao_atual"></span></p>
                <p><strong>Valor Atual do Item:</strong> R$ <span id="valor_atual"></span></p>
        </div>
    </div>
</div> 

@endsection

@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var patrimonioValor = {{ $patrimonio->valor }};
        var residual = {{ $classificacao->residual }};
        var vidaUtil = {{ $classificacao->vida_util }};
        var dataCompra = new Date("{{ $patrimonio->data_compra }}");
        var hoje = new Date();
        var diferencaMeses = (hoje.getFullYear() - dataCompra.getFullYear()) * 12 + (hoje.getMonth() - dataCompra.getMonth());

        var depreciacaoMensal = (patrimonioValor - residual) / vidaUtil;
        var depreciacaoAtual = depreciacaoMensal * diferencaMeses;
        var valorAtual = patrimonioValor - depreciacaoAtual;

        document.getElementById("meses").textContent = diferencaMeses + " meses";
        document.getElementById("valor_inicial").textContent = patrimonioValor.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.getElementById("depreciacao_atual").textContent = depreciacaoAtual.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        document.getElementById("valor_atual").textContent = valorAtual.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
</script>

@endpush
