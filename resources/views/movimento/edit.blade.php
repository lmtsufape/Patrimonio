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
        <div class="row">
            @if(isset($movimento))
                <input type="hidden" name="movimento_id" value="{{$movimento->id}}">
            @endif
            <div class="col-4">
                <label>Tipo de Movimento:<strong style="color: red">*</strong></label>
                <select class="form-control" id="tipo" name="tipo" required>
                    <option selected disabled>Selecione um Tipo de Movimento</option>
                    @foreach(App\Models\Movimento::$tipos as $texto => $tipo)
                        <option value="{{$tipo}}"
                                @if(isset($movimento) && $tipo == $movimento->tipo)selected @endif>{{$texto}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-4">
                <label>Servidor de Origem:<strong style="color: red">*</strong></label>
                <select class="form-control" name="user_origem_id" required>
                    <option selected disabled>Selecione o Servidor de Origem</option>
                    @foreach($servidores as $servidor)
                        <option value="{{$servidor->id}}"
                                @if(isset($movimento) && $servidor->id == $movimento->user_origem_id)selected @endif>{{$servidor->name}}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="col-4">
                <label>Servidor de Destino:<strong style="color: red">*</strong></label>
                <select class="form-control" name="user_destino_id" required>
                    <option selected disabled>Selecione o Servidor de Destino</option>
                    @foreach($servidores as $servidor)
                        <option value="{{$servidor->id}}"
                                @if(isset($movimento) && $servidor->id == $movimento->user_destino_id)selected @endif>{{$servidor->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-top: 30px" class="d-flex justify-content-between">
            <button style="max-width: 150px" type="submit" class="btn btn-success w-100">Salvar</button>
            <a style="width: 150px" class="btn btn-danger"
               href="{{route('movimento.delete', ['movimento_id' => $movimento->id])}}"> Deletar </a>
        </div>
    </form>

@endsection
