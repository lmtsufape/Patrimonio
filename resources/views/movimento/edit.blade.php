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
        @method('PUT')

        <input type="hidden" id="patrimonios_id" name="patrimonios_id[]">
        <div class="row">
            @if(isset($movimento))
                <input type="hidden" id="movimento_id" name="movimento_id" value="{{$movimento->id}}">
            @endif
            <div class="col-4">
                <label>Tipo de Movimento:<strong style="color: red">*</strong></label>
                <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                    <option selected disabled>Selecione um Tipo de Movimento</option>
                    @foreach(App\Models\Movimento::$tipos as $texto => $tipo)
                        <option value="{{$tipo}}"
                                @if($tipo == old('tipo'))selected @endif>{{$texto}}</option>
                    @endforeach
                </select>

                @error('tipo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6 form-group d-none" id="patrimonio">
                <label class="" for="patrimonio_id">Patrimônios</label>
                <select class="form-control" name="patrimonio_id" id="patrimonio_id">
                    <option value="" selected disabled>Escolha o Patrimônio para traferencia</option>
                    @foreach ($patrimonios as $patrimonio)
                        <option value="{{$patrimonio->id}}">{{$patrimonio->nome}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group d-none" id="solicitacao">
                <label class="" for="patrimonio_id">Patrimônios</label>
                <select class="form-control" name="patrimonio_id" id="patrimonio_id">
                    <option selected disabled>Escolha o Patrimônio para solicitação</option>
                    @foreach ($patrimoniosDisponi as $patrimonio)
                        <option value="{{$patrimonio->id}}">{{$patrimonio->nome}}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="d-none row" id="transferencia">
            <div class="col-4">
                <label>Servidor de Destino:<strong style="color: red">*</strong></label>
                <select class="form-control @error('user_destino_id') is-invalid @enderror" name="user_destino_id" required>
                    <option selected disabled>Selecione o Servidor de Destino</option>
                    @foreach($servidores as $servidor)
                        <option value="{{$servidor->id}}"
                                @if(isset($movimento) && $servidor->id == $movimento->user_destino_id)selected @endif>{{$servidor->name}}</option>
                    @endforeach
                </select>

                @error('user_destino_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            {{-- <div class="col-4">
                <label>Sala de Destino:<strong style="color: red">*</strong></label>
                <select class="form-control" name="sala_id" required>
                    <option selected disabled>Selecione o Servidor de Destino</option>
                    @foreach($servidores as $servidor)
                        <option value="{{$servidor->id}}"
                                @if(isset($movimento) && $servidor->id == $movimento->user_destino_id)selected @endif>{{$servidor->name}}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>


        <div class="d-none row" id="devolucao">
            <div class="col mt-2">
                <label>Motivo:</label>
                <textarea class="form-control @error('observacao') is-invalid @enderror" name="observacao" id="observacao"
                          placeholder="Digite uma observação sobre o movimento">@if(isset($movimento)){{$movimento->observacao}}@endif</textarea>

                @error('observacao')
                    <span class="invalid-feedback"  role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4 mb-5">
            <button type="button" class="btn btn-blue px-5 py-2" onclick="adicionarPatrimonio()">Adicionar</button>
        </div>

        <div>
            <table class="table table-hover patrimoniolist">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Prédio</th>
                        <th>Sala</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="row mt-4 mb-5">
            <div class="d-flex justify-content-center">
                <button style="max-width: 200px" type="submit" class="btn btn-success w-100">Concluir</button>
                <button style="max-width: 200px" class="btn btn-danger w-100">Cancelar</button>
            </div>
        </div>
    </form>

@endsection
