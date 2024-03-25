@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4" style="width: 55%;">
                @include('layouts.components.header', [
                    'page_title' => 'Editar Classificação Contábil',
                    'back' => true,
                ])
            <div class="card-body">
                <form method="POST" action="{{ route('classificacao.update') }}" enctype="multipart/form-data">
                    @csrf
                    @include('classificacao.form')
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary w-50"style="background-color: #3252C1;">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
