<div id="searchbar" class="my-5">
    <div class="d-flex align-items-center mb-2">
        @php
            $title = explode('>', $title);
        @endphp
        @if (count($title) > 1)
            <h3 id="subtitle"><a class="text-decoration-none" href="{{ $titleLink }}">{{ $title[0] }}</a> > {{ $title[1] }}</h3>
        @else
            <h3 id="title">{{ $title[0] }}</h3>
        @endif
        @if (isset($addButton))
            <a href="{{ $addButton }}" class="ms-2 mb-1">
                <img src="{{ asset('assets/plus-circle-fill.svg') }}" alt="Ícone de Adição" id="addButton">
            </a>
        @endif
        @if (isset($addButtonModal))
            <button style="background-color: transparent; border: none; margin-left: 5px;" data-bs-toggle="modal" data-bs-target="#{{ $addButtonModal }}">
                <img src="{{ asset('assets/plus-circle-fill.svg') }}" alt="Ícone de Adição"
                    style="width: 30px; height: 30px;">
            </button>
        @endif
    </div>

    @if (isset($searchForm))
        <div class="d-flex justify-content-center align-items-center">
            <div class="flex-fill">
                <form class="mb-0" id="search-form" action="{{ $searchForm }}" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="text" name="busca" id="busca" value="{{ request()->query('busca') }}"
                            placeholder="Pesquisar por nome">
                        <button class="btn" type="submit" id="searchButton">
                            <img src="{{ asset('images/busca.png') }}" alt="Buscar">
                        </button>
                    </div>
                </form>
            </div>
            <div class="ms-3">
                <button class="px-0" id="filterButton" data-bs-toggle="modal" data-bs-target="#filter-modal">
                    <img src="{{ asset('assets/Vector.svg') }}" alt="Ícone de filtro" class="me-1">
                    <span>Filtrar</span>
                </button>
            </div>
        </div>
    @endif
</div>
