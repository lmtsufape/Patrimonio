@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-center align-items-center" style="margin-top: 10px; margin-bottom :10px;">
        <div class="card p-4" style="width: 60%;">
            @include('layouts.components.header', ['page_title' => 'Editar Perfil', 'back' => false])
            <div class="card-body">
                <form method="POST" action="{{ route('servidor.update_dados') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <div class="col">
                            <label for="name">{{ __('Nome') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $servidor->name }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cpf">{{ __('CPF') }}</label>
                            <input id="cpf" type="text" class="form-control" name="cpf" value="{{ $servidor->cpf }}" autocomplete="cpf" autofocus>
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
                            <input id="matricula" type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ $servidor->matricula }}" required autocomplete="matricula" autofocus>
                            @error('matricula')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="cargo_id">{{ __('Cargo') }}</label>
                            @foreach ($servidor->cargos as $cargo)
                                <div class="form-check">
                                    <input class="form-check-input @error('cargo_id') is-invalid @enderror" type="checkbox" value="{{$cargo->id}}" name="cargos[]" checked>
                                    <label class="form-check-label" for="cargos_{{$cargo->id}}"> {{ $cargo->nome }}</label>
                                </div>
                            @endforeach


                            @foreach ($cargos as $cargo)
                                <div class="form-check">
                                    <input class="form-check-input @error('cargo_id') is-invalid @enderror" type="checkbox" value="{{$cargo->id}}" name="cargos[]">
                                    <label class="form-check-label" for="cargos_{{$cargo->id}}"> {{ $cargo->nome }}</label>
                                </div>
                            @endforeach

                            @error('cargo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">{{ __('E-Mail') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$servidor->email}}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3" id="senha">
                        <input type="checkbox" id="update-password-checkbox" onchange="togglePasswordFields()">
                        <label for="update-password-checkbox">{{ __('Deseja atualizar a senha?') }}</label>

                        <div id="password-fields" style="display: none;">
                            <label for="password">{{ __('Nova Senha') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <label for="password-confirm">{{ __('Confirmar Nova Senha') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <a href="{{ url()->previous() }}" class="btn btn-light btn-outline btn-block w-100">Voltar</a>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-blue btn-block">Atualizar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordFields() {
            var checkbox = document.getElementById('update-password-checkbox');
            var passwordFields = document.getElementById('password-fields');
            if (checkbox.checked) {
                passwordFields.style.display = 'block';
            } else {
                passwordFields.style.display = 'none';
            }
        }
    </script>
@endsection
