<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal bg-light">
            <div class="modal-header">
                <a href="#" data-bs-dismiss="modal" aria-label="Fechar">
                    <img src="{{ asset('assets/back.svg') }}" alt="Voltar">
                </a>
                <h5 class="modal-title mx-auto" id="{{ $modalId }}Label">{{ $modalTitle }}</h5>
            </div>
            <div class="modal-body row d-flex justify-content-center">
                <div class="col-md-3">
                    <form action="{{ $route }}" method="DELETE">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-success w-100">Sim</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Não</button>
                </div>
        </div>
    </div>
</div>
