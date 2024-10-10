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

        <div class="d-none row" id="emprestimo">
            <div class="form-group col-md-4">
                <label for="cidade">Cidade</label>
                <input class="form-control @error('cidade') is-invalid @enderror" type="text" id="cidade" name="cidade" value="{{old('cidade')}}">

                @error('cidade')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="logradouro">Logradouro</label>
                <input class="form-control @error('logradouro') is-invalid @enderror" type="text" id="logradouro" name="logradouro" value="{{old('logradouro')}}">

                @error('logradouro')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-2">
                <label for="numero">Número</label>
                <input class="form-control @error('numero') is-invalid @enderror" type="text" id="numero" name="numero" value="{{old('numero')}}">

                @error('numero')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label for="bairro">Bairro</label>
                <input class="form-control @error('bairro') is-invalid @enderror" type="text" id="bairro" name="bairro" value="{{old('bairro')}}">

                @error('bairro')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label for="evento">Evento</label>
                <input class="form-control @error('evento') is-invalid @enderror" type="text" id="evento" name="evento" value="{{old('evento')}}">

                @error('evento')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="data_devolucao">Data de devolução</label>
                <input class="form-control @error('data_devolucao') is-invalid @enderror" type="date" min="{{Date::tomorrow()->toDateString()}}" id="data_devolucacao" name="data_devolucao" value="{{old('data_devolucao')}}">

                @error('data_devolucao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

        </div>

        <div class="d-none row" id="transferencia">
            <div class="col-4">
                <label>Servidor de Destino:<strong style="color: red">*</strong></label>
                <select class="form-control @error('user_destino_id') is-invalid @enderror" name="user_destino_id" id="user_destino_id" required>
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

            <div class="col-4 d-none" id="salas">
                <label for="sala_id">Sala: </label>

                <select class="form-select @error('sala_id') is-invalid @enderror" name="sala_id" id="sala_id">
                    <option selected disabled>Selecione uma sala</option>

                </select>

                @error('sala_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
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

<script>
    let patrimoniosData = @json($patrimonios);
    patrimonios = document.querySelector('#patrimonios_id');

    document.addEventListener('DOMContentLoaded', function(){
        let tabela = document.getElementsByClassName('patrimoniolist')[0];
        let tbody = tabela.getElementsByTagName('tbody')[0];

        patrimonios.value = JSON.parse(localStorage.getItem('patrimoniosAdicionados'))
        if(patrimonios.value != ''){
            patrimonios.value.split(",").forEach(function (patrimonioId, indice){
                let exibirpatrimonio = patrimoniosData.find(function(element){
                        return element.id == patrimonioId}
                        );
                let linha = tbody.insertRow();
                linha.insertCell(0).textContent = ++indice;
                linha.insertCell(1).textContent = exibirpatrimonio.nome;
                linha.insertCell(2).textContent = exibirpatrimonio.sala.predio.nome;
                linha.insertCell(3).textContent = exibirpatrimonio.sala.nome;
                linha.insertCell(4).innerHTML = '<td><button class="btn btn-danger" type="button" onclick="removerPatrimonio(this)">Remover</button></td>';


                document.querySelector(`#patrimonio_id option[value="${patrimonioId}"]`).disabled = true;

                document.querySelector('#patrimonio_id').value = '';
           })
        }
    })

    document.addEventListener("submit", function(){
        localStorage.removeItem("patrimoniosAdicionados")
    })

    function adicionarPatrimonio(){
        let patrimonioId = document.querySelector('#patrimonio_id').value;

        if(patrimonioId === ''){
            alert('Selecione um patrimônio para adicionar.')
        }else{
            let tabela = document.getElementsByClassName('patrimoniolist')[0];
            let tbody = tabela.getElementsByTagName('tbody')[0];

            if(patrimonios.value === ''){
                patrimonios.value = patrimonioId
            }else{
                patrimonios.value = patrimonios.value.split(',').concat(patrimonioId).join(',');
                localStorage.setItem('patrimoniosAdicionados', JSON.stringify(patrimonios.value));
            }


            let exibirpatrimonio = patrimoniosData.find(function(element){
                return element.id == patrimonioId}
                );

            let linha = tbody.insertRow();
            linha.insertCell(0).textContent = patrimonios.value.split(',').length;
            linha.insertCell(1).textContent = exibirpatrimonio.nome;
            linha.insertCell(2).textContent = exibirpatrimonio.sala.predio.nome;
            linha.insertCell(3).textContent = exibirpatrimonio.sala.nome;
            linha.insertCell(4).innerHTML = '<td><button class="btn btn-danger" type="button" onclick="removerPatrimonio(this)">Remover</button></td>';


            document.querySelector(`#patrimonio_id option[value="${patrimonioId}"]`).disabled = true;

            document.querySelector('#patrimonio_id').value = '';

        }
    };

    function removerPatrimonio(botao){
        let linha = botao.parentNode.parentNode;
        document.querySelector(`#patrimonio_id option[value="${patrimonios.value.split(',')[parseInt(linha.textContent[0] - 1)]}"]`).disabled = false;

        arrayPatrimonio = patrimonios.value.split(',');
        arrayPatrimonio.splice(linha.textContent[0] - 1, 1)
        patrimonios.value = arrayPatrimonio.join(',')

        pai = linha.parentNode
        linha.parentNode.removeChild(linha);//fazer assyncwait

        for(i = 1; i <= pai.children.length; i++){
            pai.children[i - 1].children[0].textContent = i;
        }// fazer que a atualização acontecesse somente nas linhas posteriores a mudança

    }


    document.querySelector("#tipo").addEventListener("change", function(){
        acaoDivs(this.value);
    });

    if(@json(old('tipo')) != null){
        acaoDivs(@json(old('tipo')))
    }

    function acaoDivs(valor){
        if(valor == 1){
            document.querySelector("#solicitacao").classList.remove("d-none");
            document.querySelector("#devolucao").classList.add("d-none");
            document.querySelector("#transferencia").classList.add("d-none");
            document.querySelector("#patrimonio").classList.add("d-none");
            document.querySelector("#emprestimo").classList.add("d-none");

        }else if(valor == 2){
            document.querySelector("#emprestimo").classList.remove("d-none");
            document.querySelector("#patrimonio").classList.remove("d-none");
            document.querySelector("#solicitacao").classList.add("d-none");
            document.querySelector("#transferencia").classList.add("d-none");
            document.querySelector("#devolucao").classList.add("d-none");

        }else if(valor == 3){
            document.querySelector("#devolucao").classList.remove("d-none");
            document.querySelector("#patrimonio").classList.remove("d-none");
            document.querySelector("#solicitacao").classList.add("d-none");
            document.querySelector("#transferencia").classList.add("d-none");
            document.querySelector("#emprestimo").classList.add("d-none");

        }else if(valor == 4){
            document.querySelector("#transferencia").classList.remove("d-none");
            document.querySelector("#patrimonio").classList.remove("d-none");
            document.querySelector("#solicitacao").classList.add("d-none");
            document.querySelector("#devolucao").classList.add("d-none");
            document.querySelector("#emprestimo").classList.add("d-none");

        }

        $('#user_destino_id').change(function() {
            let servidorId = $(this).val();
            axios.get('{{route('salas.buscar', ['user_id'=>':userId'])}}'.replace(':userId', servidorId))
                .then(function(response) {
                    $('#salas').removeClass("d-none")
                    let salas = response.data;
                    $('#sala_id').empty().append('<option selected disabled>Selecione uma sala</option>');
                    $.each(salas, function(index, sala) {
                        $('#sala_id').append('<option value="' + sala.id + '">' + sala.nome + '</option>');
                    });
                })
                .catch(function(error) {
                    console.error('Erro ao buscar salas:', error);
                });
        });
    }
</script>
@endsection
