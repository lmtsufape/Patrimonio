@extends('layouts.app')
@section('content')

@push('styles')
        <link rel="stylesheet" href="/css/modal.css">
@endpush

<div class="card mx-auto my-5 p-4" style="max-width: 600px;">
    <div class="d-flex align-items-center mb-2 mt-3">
        @include('layouts.components.header', ['page_title' => 'Códigos do Patrimônio '. $patrimonio->nome, 'back' => route('patrimonio.index')])
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
            style="background-color: transparent; border: none; margin-bottom: 8px;">
            <img src="{{ asset('assets/plus-circle-fill.svg') }}" alt="Ícone de Adição"
                style="width: 30px; height: 30px;">
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($patrimonio->codigos as $index => $codigo)
            <div class="col-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Código {{$index+1}}</h5>
                        <div class="d-flex align-items-center">
                            <input class="form-control @error('codigo') is-invalid @enderror" type="text"
                                name="codigo" @if(isset($codigo->codigo)) value="{{$codigo->codigo}}" @endif required
                                autocomplete="codigo" autofocus>
                            <a href="{{route('patrimonio.codigo.delete', ['codigo_id' => $codigo->id])}}"
                                class="btn ms-2"><img src="{{ asset('/images/delete.png') }}" alt="Excluir"
                                    style="width: 20px; height: 20px;"></a>
                        </div>
                        @error('codigo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            @endforeach

            @empty($patrimonio->codigos[0])
            <div class="col-12">
                <div class="alert" role="alert">
                    Não há códigos cadastrados ainda.
                </div>
            </div>
            @endempty
        </div>
    </div>
</div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content custom-modal bg-light">
                    <div class="modal-header">
                        <a href="#" data-bs-dismiss="modal" aria-label="Fechar">
                            <img src="{{ asset('assets/back.svg') }}" alt="Voltar">
                        </a>
                        <h5 class="modal-title mx-auto" id="exampleModalLabel">Adicionar Código ao Patrimônio</h5>
                    </div>
            <div class="modal-body">
                <form method="POST" action="{{route('patrimonio.codigo.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        @include('patrimonio.codigo.form')
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
