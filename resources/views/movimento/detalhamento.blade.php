@extends('layouts.app')
@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Detalhamento de Movimento',
    ])

    <div class="row">
        <h2>Dados dos servidores</h2>

        <div class="col-md-6">
            <h4>Servidor de Origem</h4>
            <p>Nome: {{$movimento->userOrigem->nome}}</p>
        </div>
        <div class="col-md-6">
            <h4>Servidor de Destino</h4>
            <p>Nome: {{$movimento->userOrigem->nome}}</p>
        </div>
    </div>

    <div class="row">
        <h2>Dados do Movimento</h2>
    </div>

    <div class="row">
        <h2>Dados dos Patrimônios</h1>
    </div>

@endsection
