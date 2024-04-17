@if ($content[0]->count() > 0)
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
                    @foreach ($content as $columnSet)
                        @if (is_array($columnSet[$i]))
                            @if (!empty($columnSet[$i]))
                                <td class="py-4">
                                    {{ implode(', ', $columnSet[$i]) }}
                                </td>
                            @else
                                <td class="py-4">
                                    N/A
                                </td>
                            @endif
                        @else
                            <td class="py-4">{{ $columnSet[$i] }}</td>
                        @endif
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
@else
    <h5 class="text-center">Nenhum resultado encontrado.</h4>
@endif