<div class="modal fade" id="filter-modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">{{ $modalTitle }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="filter-form" action="{{ $filterRoute }}" method="GET">
                <div class="modal-body">
                    <input type="hidden" name="busca" id="filter-search">

                    @foreach ($modalContent as $field)
                        <div class="mb-3">
                            <label for="{{ $field['id'] }}">{{ $field['label'] }}</label>
                            <select class="form-select" name="{{ $field['name'] ?? $field['id'] }}"
                                id="{{ $field['id'] }}">
                                <option value="" selected>{{ $field['placeholder'] }}</option>
                                @foreach ($field['options'] as $key => $option)
                                    <option value="{{ $key }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
