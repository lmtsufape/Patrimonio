@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Criar Movimentação de Patriminio',
    ])

    <form method="POST" action="{{route('movimento.store')}}" enctype="multipart/form-data">
        @csrf
        @include('movimento.form')
        <div class="row mt-4">
            <div class="">
                <button style="max-width: 200px" type="submit" class="btn btn-success w-100">Salvar</button>
            </div>
        </div>
    </form>

@endsection
