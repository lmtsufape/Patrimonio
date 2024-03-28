@if ($type == 'delete')
    <form action="{{ $link }}" method="POST">
        @csrf
        @method('delete')
        <button class="btn me-1 p-0"><img src="{{ $img }}" alt="Ícone de Ação"></button>
    </form>
@elseif ($type == 'edit')
    <button class="btn me-1 p-0" onclick="openEditModal({{ $id }})">
        <img src="{{ $acao['img'] }}" alt="Ícone de Ação">
    </button>
@else
    <a class="btn me-1 p-0" href="{{ $link }}">
        <img src="{{ $acao['img'] }}" alt="Ícone de Ação" style="height: 25px; color: grey">
    </a>
@endif
