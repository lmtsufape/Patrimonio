@extends('layouts.app')

@section('css')
   
    <link rel="stylesheet" href="/css/cadastros/cadastro_usuario.css">
@endsection

@section('content')

<div class="d-flex justify-content-center align-items-center" style="margin-top: 10px; margin-bottom :10px;">
        <div class="card p-4" style="width: 60%;">
            @include('layouts.components.header', ['page_title' => 'Cadastro', 'back' => false])
            <div class="card-body">      
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-3">
                    <div class="col">
                        <label for="name">{{ __('Nome') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cpf">{{ __('CPF') }}</label>
                        <input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}" autocomplete="cpf" autofocus>
                        @error('cpf')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="matricula">{{ __('Matricula') }}</label>
                        <input id="matricula" type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ old('matricula') }}" required autocomplete="matricula" autofocus>
                        @error('matricula')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="cargo_id">{{ __('Cargo') }}</label>
                        <select class="form-control @error('cargo_id') is-invalid @enderror" id="cargo_id" name="cargo_id" required>
                            <option selected disabled>Selecione um Cargo</option>
                            @foreach($cargos as $cargo)
                                <option value="{{$cargo->id}}" @if(isset($servidor) && $servidor->cargo_id == $cargo->id || old('cargo_id') == $cargo->id) selected @endif>{{$cargo->nome}}</option>
                            @endforeach
                        </select>
                        @error('cargo_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">{{ __('E-Mail') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password">{{ __('Senha') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirm">{{ __('Confirmar Senha') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <a href="{{ url()->previous() }}" class="btn btn-light btn-outline btn-block w-100">Voltar</a>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-blue btn-block">Cadastrar</button>
                    </div>
            </form>
        </div>
    </div>
</div>

@endsection
