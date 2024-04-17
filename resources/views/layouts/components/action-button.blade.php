@if ($type == 'delete')
    <button class="btn me-1 p-0" onclick="openDeleteModal({{ $id }})">
        <img src="{{ $img }}" alt="Ícone de Ação">
    </button>
@elseif ($type == 'edit')
    <button class="btn p-0" onclick="openEditModal({{ $id }})">
        <img src="{{ $acao['img'] }}" alt="Ícone de Ação">
    </button>
@else
    <a class="btn p-0" href="{{ $link }}">
        <img src="{{ $acao['img'] }}" alt="Ícone de Ação">
    </a>
@endif
