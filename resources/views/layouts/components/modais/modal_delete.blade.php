<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal bg-light">
            <div class="modal-header">
                <a href="#" data-bs-dismiss="modal" aria-label="Fechar">
                    <img src="{{ asset('assets/back.svg') }}" alt="Voltar">
                </a>
                <h5 class="modal-title mx-auto" id="{{ $modalId }}Label">{{ $modalTitle }}</h5>
            </div>
            <div class="modal-body">
                <form action="{{ $route }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <button type="submit" class="btn btn-success w-100">Sim</button>
                        </div>

                        <div class="flex-grow-1">
                            <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Não</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
