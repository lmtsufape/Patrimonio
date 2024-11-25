@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">

    <style>
        .border-start-blue{
            border-left: 2px solid #1a2876;
            padding: 0 20px;        }
        h4{
            color: #1a2876;
        }
    </style>
@endpush

@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Detalhamento de Movimento',
    ])

    <div class="d-flex flex-wrap justify-content-center align-items-baseline gap-5 pb-5">
        <div class="col-md-5 border-start-blue">
            <h4>Dados do Servidor de Origem</h4>
            <p><strong>Nome: </strong>{{$movimento->userOrigem->name}}</p>
            <p><strong>Matrícula: </strong>{{$movimento->userOrigem->matricula}}</p>
            <p><strong>E-mail: </strong>{{$movimento->userOrigem->email}}</p>
            <p><strong>Unidade Administrativa: </strong>{{$movimento->userOrigem->unidades->first()->nome}}</p>
        </div>
        @if($movimento->userDestino)
            <div class="col-md-5 border-start-blue">
                <h4>Dados do Servidor de Destino</h4>
                <p><strong>Nome: </strong>{{$movimento->userDestino->name}}</p>
                <p><strong>Matrícula: </strong>{{$movimento->userDestino->matricula}}</p>
                <p><strong>E-mail: </strong>{{$movimento->userDestino->email}}</p>
                <p><strong>Unidade Administrativa: </strong>{{$movimento->userDestino->unidades->first()->nome}}</p>
            </div>
        @endif

        <div class="col-md-5 border-start-blue">
            <h4>Dados dos Patrimônios</h4>
            @foreach($movimento->patrimonios as $patrimonio)
                <p><strong>Nome: </strong>{{$patrimonio->nome}}</p>
                <p><strong>Código: </strong> {!! $patrimonio->codigos->implode('codigo','<br>') !!}</p>
            @endforeach
        </div>
        <div class="col-md-5 border-start-blue">
            <h4>Dados do Movimento</h4>
            <p><strong>Tipo: </strong>{{array_search($movimento->tipo, App\Models\Movimento::$tipos)}}</p>
            <p><strong>Data: </strong>{{$movimento->data_formatada}}</p>
            @if($movimento->tipo == 1)

            @elseif($movimento->tipo == 2)
                <p><strong>Cidade: </strong>{{$movimento->cidade}}</p>
                <p><strong>Logradouro: </strong>{{$movimento->logradouro}}</p>
                <p><strong>Número: </strong>{{$movimento->numero}}</p>
                <p><strong>Bairro: </strong>{{$movimento->bairro}}</p>
                <p><strong>Evento: </strong>{{$movimento->evento}}</p>


            @elseif($movimento->tipo == 3)
                <p><strong>Motivo da Devolução: </strong>{{$movimento->motivo}}</p>
            @elseif($movimento->tipo == 4)

            @endif
        </div>
    </div>

    @if (!in_array($movimento->status, ['Aprovado', 'Reprovado']))
        <div class="d-flex justify-content-center gap-4 pt-5 pb-5">
            <a class="btn btn-blue btn-lg" href="{{route('movimento.aprovar', ['movimento_id' => $movimento->id])}}">Aceitar</a>
            <a class="btn btn-ligth btn-lg border-dark" href="{{route('movimento.reprovar', ['movimento_id' => $movimento->id])}}">Recusar</a>
        </div>
    @else
        <h5 class="text-center">Status do movimento: {{ $movimento->status }}</h3>
    @endif
@endsection
