@extends('layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Movimentações de Patrimonios',
        'addButton' => route('movimento.create'),
        'searchForm' => route('movimento.buscar'),
    ])
    @if($movimentos->count() != 0)
        <div class="col-md-10 mx-auto">
            <table class="table table-hover shadow-lg">
                <thead class="text-md-center align-middle">
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
                    @foreach ($movimentos as $i => $movimento)
                        <tr class="text-md-center">
                            <td class="py-4">
                                {{$movimento->id}}
                            </td>
                            <td class="py-4">
                                {{$movimento->userOrigem->name}}
                            </td>
                            <td class="py-4">
                                @if($movimento->tipo == 4)
                                    {{$movimento->userDestino->name}}
                                @else
                                    Não aplicavel ao tipo de Movimentação
                                @endif
                            </td>
                            <td class="py-4">
                                {{array_search($movimento->tipo, $movimento::$tipos)}}
                            </td>
                            <td class="py-4">
                                {{$movimento->patrimonios()->value('nome')}}
                            </td>
                            <td class="py-4">
                                <div class="d-flex justify-content-center">
                                    @if($movimento->status == 'Pendente')
                                        <a class="btn p-0" href="{{route('movimento.edit', ['movimento_id'=> $movimento->id])}}">
                                            <img src="{{asset('/images/pencil.png')}}" alt="Ícone de Editar">
                                        </a>

                                        <button class="btn me-1 p-0" onclick="openDeleteModal({{ $movimento->id }})">
                                            <img src="{{asset('/images/delete.png')}}" alt="Ícone de Deletar">
                                        </button>
                                    @endif
                                    <a class="btn me-1 p-0" href="{{route('movimento.detalhamento', ['movimento_id' => $movimento->id])}}">
                                        <img src="{{asset('/images/vision.png')}}" alt="Ícone de Detalhamento">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center pb-5">
                {{ $movimentos->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @else
        <h5 class="text-center">Nenhuma movimentação existente.</h5>
    @endif

    @include('layouts.components.modais.modal_delete', [
        'modalId' => 'deleteConfirmationModal',
        'modalTitle' => 'Tem certeza que deseja apagar esta Movimentação?',
        'route' => route('movimento.delete', ['movimento_id' => ':id']),
    ])


@endsection

@push('scripts')
    <script>
        var movimentoId = 0;
        function openDeleteModal(id) {
            movimentoId = id;
            $('#deleteConfirmationModal').modal('show');
        }

        $(document).ready(function () {
            $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
                $(this).find('form').attr('action', $(this).find('form').attr('action').replace(':id', movimentoId));
            });
        });

    </script>
@endpush
