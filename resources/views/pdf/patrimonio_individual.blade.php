<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Patrimônio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #1A2876;
            padding: 20px;
        }
        h1 {
            color: #3252C1;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #3252C1;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #3252C1;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h2 {
            text-decoration: underline; 
        }
    </style>
</head>
<body>
    <h1>Relatório do Patrimônio: {{ $patrimonio->nome }}</h1>
    <h3>Dados do Patrimônio</h3>
    <p><strong>Nome:</strong> {{ $patrimonio->nome }}</p>
    <p><strong>Nota Fiscal:</strong> {{ $patrimonio->nota_fiscal }}</p>
    <p><strong>Descrição:</strong> {{ $patrimonio->descricao }}</p>
    <p><strong>Data de Compra:</strong> {{ $patrimonio->data_compra }}</p>
    
    <h3>Detalhes Adicionais</h3>

    <p><strong>Origem:</strong> {{ $patrimonio->origem->nome }}</p>
    <p><strong>Prédio:</strong> {{ $patrimonio->sala->predio->nome }}</p>
    <p><strong>Sala:</strong> {{ $patrimonio->sala->nome }}</p>
    <p><strong>Servidor:</strong> {{ $patrimonio->servidor->user->name }}</p>
    <p><strong>Valor do Item:</strong> R$ {{ number_format($patrimonio->valor, 2, ',', '.') }}</p>
    
    <h2>Historico de Movimentações:</h2>

    @if($movimentos->isEmpty())
    <p>Não há movimentações registradas para este patrimônio.</p>
    @else
    <ul>
        @foreach($movimentos as $movimento)
            <li>
                <strong>Tipo de Movimento:</strong> {{ $movimento->tipo_movimento_id }} <br>
                <strong>ID do Movimento:</strong> {{ $movimento->id }} <br>
                <strong>Observação:</strong> {{ $movimento->observacao }} <br>
                <strong>Status:</strong> {{ $movimento->status }} <br>
                <strong>Data do Movimento:</strong> {{ $movimento->data_movimento }} <br>
                <strong>Data de Conclusão:</strong> {{ $movimento->data_conclusao ?: 'N/A' }} <br>
                <strong>Servidor Destino:</strong> {{ $movimento->servidor_destino_id }} <br>
                <strong>Servidor Origem:</strong> {{ $movimento->servidor_origem_id }} <br>
                
            </li>
        @endforeach
    </ul>
    @endif

</body>
</html>
