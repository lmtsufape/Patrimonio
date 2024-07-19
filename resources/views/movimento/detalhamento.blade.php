@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">

    <style>
        .border-start-blue{
            border-left: 2px solid #1a2876;
        }
        h4{
            color: #1a2876;
        }
    </style>
@endpush

@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Detalhamento de Movimento',
    ])

    <div class="row pb-5">
        <div class="col-md-6 border-start-blue">
            <h4>Dados do Servidor de Origem</h4>
            <p><strong>Nome: </strong>{{$movimento->userOrigem->name}}</p>
            <p><strong>Matrícula: </strong>{{$movimento->userOrigem->matricula}}</p>
            <p><strong>E-mail: </strong>{{$movimento->userOrigem->email}}</p>
            <p><strong>Unidade Administrativa: </strong>{{$movimento->userOrigem->unidades->first()->nome}}</p>
        </div>
        @if($movimento->userDestino)
            <div class="col-md-6 border-start-blue">
                <h4>Dados do Servidor de Destino</h4>
                <p><strong>Nome: </strong>{{$movimento->userDestino->name}}</p>
                <p><strong>Matrícula: </strong>{{$movimento->userDestino->matricula}}</p>
                <p><strong>E-mail: </strong>{{$movimento->userDestino->email}}</p>
                <p><strong>Unidade Administrativa: </strong>{{$movimento->userDestino->unidades->first()->nome}}</p>
            </div>
        @endif
    </div>

    <div class="row pb-5">
        <div class="col-md-6 border-start-blue">
            <h4>Dados dos Patrimônios</h4>
            @foreach($movimento->patrimonios as $patrimonio)
                <p>{{$patrimonio->nome}}</p>

            @endforeach
        </div>
        <div class="col-md-6 border-start-blue">
            <h4>Dados do Movimento</h4>
            <p>Tipo: {{array_search($movimento->tipo, App\Models\Movimento::$tipos)}}</p>
            <p>Data: {{$movimento->data_formatada}}</p>
            @if($movimento->tipo == 1)

            @elseif($movimento->tipo == 2)
                <p>{{$movimento->cidade}}</p>
                <p>{{$movimento->logradouro}}</p>
                <p>{{$movimento->numero}}</p>
                <p>{{$movimento->bairro}}</p>
                <p>{{$movimento->evento}}</p>


            @elseif($movimento->tipo == 3)

            @elseif($movimento->tipo == 4)

            @endif
        </div>
    </div>
    <div class="d-flex justify-content-center gap-4 pb-5">
        <a class="btn btn-blue btn-lg" href="{{route('movimento.aprovar', ['movimento_id' => $movimento->id])}}">Aceitar</a>
        <a class="btn btn-ligth btn-lg border-dark" href="{{route('movimento.reprovar', ['movimento_id' => $movimento->id])}}">Recusar</a>
    </div>



@endsection
