<div class="modal fade" id="modal-aceitar" tabindex="-1" aria-labelledby="modal-aceitar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-aceitar-label">Aceitar Movimentação</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja aceitar a movimentação?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a type="button" class="btn btn-primary" href="{{route('movimento.aprovar', ['movimento_id' => $movimento->id])}}">Aceitar</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-recusar" tabindex="-1" aria-labelledby="modal-recusar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-recusar-label">Recusar Movimentação</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja recusar a movimentação?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="{{ route('movimento.reprovar', ['movimento_id' => $movimento->id]) }}">Recusar</a>
            </div>
        </div>
    </div>
</div>