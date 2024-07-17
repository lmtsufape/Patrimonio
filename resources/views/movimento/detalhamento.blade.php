@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Detalhamento de Movimento',
    ])

    <div class="row">
        <h3>Dados dos servidores</h3>

        <div class="col-md-6">
            <h5>Servidor de Origem</h5>
            <p>Nome: {{$movimento->userOrigem->name}}</p>
            <p>Matrícula: {{$movimento->userOrigem->matricula}}</p>
            <p>E-mail: {{$movimento->userOrigem->email}}</p>
            <p>Unidade Administrativa: {{$movimento->userOrigem->unidade->nome}}</p>
        </div>
        @if($movimento->userDestino)
            <div class="col-md-6">
                <h5>Servidor de Destino</h5>
                <p>Nome: {{$movimento->userDestino->name}}</p>
                <p>Matrícula: {{$movimento->userDestino->matricula}}</p>
                <p>E-mail: {{$movimento->userDestino->email}}</p>
                <p>Unidade Administrativa: {{$movimento->userDestino->unidade->nome}}</p>

            </div>
        @endif
    </div>

    <div class="row">
        <h3>Dados do Movimento</h3>
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

    <div class="row">
        <h3>Dados dos Patrimônios</h3>
        @foreach($movimento->patrimonios as $patrimonio)
            <p>{{$patrimonio->nome}}</p>

        @endforeach
    </div>

@endsection
