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
            <div class="col-md-6 form-group d-none" id="patrimonio">
                <label class="" for="patrimonio_id">Patrimônios</label>
                <select class="form-control" name="patrimonio_id" id="patrimonio_id">
                    <option selected disabled>Escolha o Patrimônio para traferencia</option>
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

        
        <div class="d-none row" id="devolucao">
            <div class="col mt-2">
                <label>Motivo:</label>
                <textarea class="form-control" name="observacao" id="observacao"
                          placeholder="Digite uma observação sobre o movimento">@if(isset($movimento)){{$movimento->observacao}}@endif</textarea>
            </div>
        </div>

        <div class="row mt-4">
            <div class="">
                <button style="max-width: 200px" type="submit" class="btn btn-success w-100">Salvar</button>
            </div>
        </div>
    </form>
<script>
    document.getElementById("tipo").addEventListener("change", function(){
        if(this.value == 1){
            document.getElementById("solicitacao").classList.remove("d-none");
            document.getElementById("devolucao").classList.add("d-none");
            document.getElementById("transferencia").classList.add("d-none");
            document.getElementById("patrimonio").classList.add("d-none");

        }else if(this.value == 2){
            
        }else if(this.value == 3){
            document.getElementById("devolucao").classList.remove("d-none");
            document.getElementById("patrimonio").classList.remove("d-none");
            document.getElementById("solicitacao").classList.add("d-none");
            document.getElementById("transferencia").classList.add("d-none");
        }else{
            document.getElementById("transferencia").classList.remove("d-none");
            document.getElementById("patrimonio").classList.remove("d-none");
            document.getElementById("solicitacao").classList.add("d-none");
            document.getElementById("devolucao").classList.add("d-none");

        }
    });
</script>
@endsection
