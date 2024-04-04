@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/layouts/searchbar.css">
    <link rel="stylesheet" href="/css/layouts/table.css">
@endpush

@section('content')
    @include('layouts.components.searchbar', [
        'title' => 'Patrimônio',
        'addButton' => route('patrimonio.create'),
        'searchForm' => route('patrimonio.busca.get'),
    ])

    <div class="col-md-10 mx-auto">
        @include('layouts.components.table', [
            'header' => ['ID', 'Nome', 'Prédio', 'Sala', 'Ações'],
            'content' => [$patrimonios->pluck('id'), $patrimonios->pluck('nome'), $patrimonios->pluck('sala.predio.nome'), $patrimonios->pluck('sala.nome')],
            'acoes' => [
                ['link' => 'patrimonio.edit', 'param' => 'patrimonio_id', 'img' => asset('/images/pencil.png') , 'type' =>'editLink'],
                ['link' => 'patrimonio.delete', 'param' => 'patrimonio_id', 'img' => asset('/images/delete.png'), 'type' =>'delete'],
                ['link' => 'patrimonio.patrimonio', 'param' => 'patrimonio_id', 'img' => asset('/images/info.png'), 'type' =>''],
            ]
        ])

        <div class="d-flex justify-content-center">
            {{ $patrimonios->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Detalhes do Patrimônio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nome do Patrimônio:</strong> <span id="patrimonio_nome"></span></p>
                    <p><strong>Classificação:</strong> <span id="classificacao"></span></p>
                    <p><strong>Valor Residual:</strong> <span id="valor_residual"></span></p>
                    <p><strong>Vida Útil:</strong> <span id="vida_util"></span> meses</p>
                    <hr>
                    <p><strong>Meses de Depreciação:</strong> <span id="meses"></span></p>
                    <p><strong>Valor Inicial do Item:</strong> R$ <span id="valor_inicial"></span></p>
                    <p><strong>Depreciação Atual do Item:</strong> R$ <span id="depreciacao_atual"></span></p>
                    <p><strong>Valor Atual do Item:</strong> R$ <span id="valor_atual"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
