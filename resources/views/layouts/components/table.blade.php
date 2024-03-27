<table class="table table-hover">
    <thead class="text-md-center">
        <tr>
            @foreach ($header as $item)
                <th>{{ $item }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($content[0] as $i => $id)
            <tr class="text-md-center">
                @foreach ($content as $column)
                    <td class="py-4">{{ $column[$i] }}</td>
                @endforeach
                <td class="py-4 d-flex flex-row justify-content-center">
                    @foreach ($acoes as $acao)
                        @include('layouts.components.action-button', ['link' => route($acao['link'], [$acao['param'] => $id]), 'img' => $acao['img'], 'type' => $acao['type'], 'id' => $id])
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>