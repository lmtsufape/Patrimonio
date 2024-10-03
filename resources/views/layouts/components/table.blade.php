@if ($content[0]->count() > 0)
    <table class="table table-hover shadow-lg">
        <thead class="text-md-center align-middle">
            <tr>
                @foreach ($header as $item)
                    <th>{{ $item }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($content[0] as $i => $id)
                <tr>
                    @foreach ($content as $columnSet)
                        @if (is_array($columnSet[$i]))
                            @if (!empty($columnSet[$i]))
                                <td class="text-center py-4">
                                    {!! implode('<br>', $columnSet[$i]) !!}
                                </td>
                            @else
                                <td class="text-center py-4">
                                    N/A
                                </td>
                            @endif
                        @else
                            <td class="text-center py-4">{{ $columnSet[$i] }}</td>
                        @endif
                    @endforeach

                    <td class="py-4">
                        <div class="d-flex justify-content-center">
                            @foreach ($acoes as $acao)
                               @include('layouts.components.action-button', [
                                                                                'modalId' => $acao['modalId'],
                                                                                'modalTitle' => $acao['modalTitle'],
                                                                                'formAction' => route($acao['link'], [$acao['param'] => $id]),
                                                                                'link' => route($acao['link'], [$acao['param'] => $id]),
                                                                                'img' => $acao['img'],
                                                                                'type' => $acao['type'],
                                                                                'id' => $id,
                                                                                'modalInputs' => $acao['modalInputs']
                                                                            ])
                            @endforeach
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h5 class="text-center">Nenhum resultado encontrado.</h5>
@endif
