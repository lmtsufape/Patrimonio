@extends('layouts.app')

@section('content')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
@endpush

@section('content')

    @include('layouts.components.searchbar', [
        'title' => 'Movimentações de Patrimonios',
        'addButton' => route('movimento.create'),
      
    ])


    <div class="container">
        <table class="table table-hover shadow-lg" style="border-radius: 10px; overflow:hidden; ">
            <thead class="text-md-center" style="background-color: #1A2876; color: white;">
            <tr>
                <th>#</th>
                <th>Servidor de Origem</th>
                <th>Servidor de Destino</th>
                <th>Tipo do Movimento</th>
                <th>Itens do Movimento</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($movimentos as $movimento)
                <tr class="text-md-center">
                <td class="py-3">{{$movimento->id}}</td>
                        <td class="py-3">{{$movimento->userOrigem->name}}</td>
                        <td class="py-3">{{$movimento->userDestino->name}}</td>
                        <td class="py-3">{{$movimento->tipo_movimento->nome}}</td>
                        <td class="py-3">
                        @foreach($movimento->itens_movimento->take(3) as $index => $item)
                            {{Str::limit($item->nome, 15)}}@if($index < 2)
                                ,
                            @endif
                        @endforeach
                    </td>
                    <td class="py-4">
                        @if($movimento->status != 'Concluido')
                            <a href="{{route('movimento.edit', ['movimento_id' => $movimento->id])}}">
                                <img src="{{asset('/images/pencil.png')}}" width="24px" alt="Icon de edição">
                            </a>
                            <a href="{{route('movimento.delete', ['movimento_id' => $movimento->id])}}">
                                <img src="{{asset('/images/delete.png')}}" width="24px" alt="Icon de remoção">
                            </a>
                        @else
                            <button class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center action-button" disabled>
                                <img src="{{asset('/images/pencil.png')}}" width="24px" alt="Icon de edição">
                            </button>
                            <button class="btn btn-danger rounded-circle d-flex justify-content-center align-items-center action-button" disabled>
                                <img src="{{asset('/images/delete.png')}}" width="24px" alt="Icon de remoção">
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            $('#movimento_table').DataTable({
                searching: true,
                "language": {
                    "search": "Pesquisar: ",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "info": "Exibindo página _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro disponível",
                    "zeroRecords": "Nenhum registro disponível",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Próximo"
                    }
                },
                "columnDefs": [{
                    "targets": [0, 5],
                    "orderable": false
                }]
            });
        });
    </script>

@endsection
