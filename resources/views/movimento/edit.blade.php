@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Editar Movimentação de Patrimonio',
    ])

    <form method="POST" action="{{route('movimento.update')}}" enctype="multipart/form-data">
        @csrf
        @include('movimento.form')
        <div style="margin-top: 30px" class="d-flex justify-content-between">
            <button style="max-width: 150px" type="submit" class="btn btn-success w-100">Salvar</button>
            <a style="width: 150px" class="btn btn-danger"
               href="{{route('movimento.delete', ['movimento_id' => $movimento->id])}}"> Deletar </a>
        </div>
    </form>

    @include('movimento.patrimonio.create')
@endsection
