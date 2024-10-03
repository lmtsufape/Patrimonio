@if ($type == 'delete')
    <button class="btn me-1 p-0" onclick="openDeleteModal({{ $id }})">
        <img src="{{ $img }}" alt="Ícone de Ação">
    </button>
@elseif ($type == 'edit')
    <button class="btn p-0" data-bs-toggle="modal" data-bs-target="#{{$modalId . $id}}" entidade-id="{{$id}}">
        <img src="{{ $acao['img'] }}" alt="Ícone de Ação">
    </button>
@else
    <a class="btn p-0" href="{{ $link }}">
        <img src="{{ $acao['img'] }}" alt="Ícone de Ação">
    </a>
@endif

@push('modais')
    @include('layouts.components.modais.modal', [
        'modalId' => $modalId . $id,
        'modalTitle' => $modalTitle,
        'type' => $type,
        'formAction' => $formAction,
        'fields' => $modalInputs
    ])

@endpush
