@extends('layouts.app')

@section('content')

    @push('styles')
        <link rel="stylesheet" href="/css/layouts/searchbar.css">
        <link rel="stylesheet" href="/css/layouts/table.css">
    @endpush

    @include('layouts.components.searchbar', [
        'title' => 'Movimentações de Patrimonios',
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
                                {{$movimento->patrimonios()->pluck('nome')}}
                            </td>
                            <td class="py-4">
                                <div class="d-flex justify-content-center">
                                    <a class="btn me-1 p-0" href="{{route('movimento.detalhamento', ['movimento_id' => $movimento->id])}}">
                                        <img src="{{asset('/images/vision.png')}}" alt="Ícone de Detalhamento">
                                    </a>
                                    @if(Auth::user()->hasAnyRoles(['Administrador']))
                                        @if($movimento->status != 'Finalizado')
                                            <a class="btn me-1 p-0" href="{{route('movimento.finalizar', ['movimento_id' => $movimento->id])}}">
                                                <img src="{{asset('/assets/check.svg')}}" alt="Ícone de Finalização">
                                            </a>
                                        @endif
                                    @else
                                        @if($movimento->status == 'Pendente')
                                            <a class="btn me-1 p-0" href="{{route('movimento.reprovar', ['movimento_id' => $movimento->id])}}">
                                                <img src="{{asset('/assets/cancel.svg')}}" alt="Ícone de Reprovar">
                                            </a>

                                            <a class="btn me-1 p-0" href="{{route('movimento.aprovar', ['movimento_id' => $movimento->id])}}">
                                                <img src="{{asset('/assets/check.svg')}}" alt="Ícone de Aprovar">
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $movimentos->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @else
        <h5 class="text-center">Nenhuma solicitação existente.</h5>
    @endif



@endsection

@push('scripts')

@endpush
