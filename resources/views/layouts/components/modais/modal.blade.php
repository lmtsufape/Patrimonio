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
            <div class="modal-body">
                <form action="{{ $formAction }}" method="POST">
                    @csrf

                    @if ($type == 'edit')
                        @method('PUT')
                    @endif

                    <input type="hidden" name="modalId" id="modalId" value="{{$modalId}}">{{-- variavel usada para diferenciar os modais quando houver falha na validação --}}

                    @foreach ($fields as $field)
                        @if ($field['type'] == 'text' || $field['type'] == 'email' || $field['type'] == 'password')
                            <div class="mb-3">
                                <label for="{{ $field['id'] . "-$type" }}" class="form-label">
                                    {{ $field['label'] }}
                                </label>
                                <input type="{{ $field['type'] }}" id="{{ $field['id'] . "-$type" }}" name="{{ $field['name'] }}" class="form-control @error($field['name']) is-invalid @enderror" value="{{old($field['id'])}}" required>
                                @error($field['name'])
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @elseif ($field['type'] == 'hidden')
                            <input type="{{ $field['type'] }}" class="form-control" id="{{ $field['id'] . "-$type" }}"
                                name="{{ $field['name'] }}" value="{{ $field['value'] ?? null }}">
                        @elseif ($field['type'] == 'select')
                            <div class="mb-3">
                                <label for="{{ $field['id'] . "-$type" }}"
                                    class="form-label">{{ $field['label'] ?? $field['name'] }}</label>

                                <select type="{{ $field['type'] }}" class="form-control  @error($field['name']) is-invalid @enderror" id="{{ $field['id'] . "-$type" }}"
                                    name="{{ $field['name'] }}" required>

                                    <option value="" selected disabled>{{ $field['placeholder'] }}</option>
                                    @foreach ($field['options'] as $i => $option)
                                        <option value="{{ $i }}">{{ $option }}</option>
                                    @endforeach
                                    @error($field['name'])
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </select>
                            </div>
                        @elseif ($field['type'] == 'checkbox')
                            <div class="mb-3">
                                <label class="form-label">{{ $field['label'] }}</label>
                                @foreach ($field['options'] as $i => $option)
                                    <div class="form-check">
                                        <input class="form-check-input @error($field['name']) is-invalid @enderror" type="checkbox" value="{{ $i }}" id="{{ $field['id'] . "-$type" . "-$i" }}" name="{{ $field['name'] }}[]">
                                        <label class="form-check-label" for="{{ $field['id'] . "-$type" . "-$i" }}">{{ $option }}</label>
                                    </div>
                                @endforeach
                                @error($field['name'])
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    @endforeach
                    <div class="text-center">
                        <button type="submit" class="btn btn-blue">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if ($errors->any())
            let myModal = new bootstrap.Modal(document.getElementById('{{  old('modalId')  }}'));
            myModal.show();
        @endif
    });
    document.getElementById('{{  old('modalId')  }}').addEventListener('hidden.bs.modal', function () {
        let modalElement = document.getElementById('{{  old('modalId')  }}');

        modalElement.querySelectorAll('.is-invalid').forEach(function(element) {
            element.classList.remove('is-invalid');
            element.classList.remove('invalid-feedback');
            element.value = ''
        });
    });
</script>
