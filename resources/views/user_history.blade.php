@extends('layout.user_layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class=" m-r-l  col">
                <div class="my-4 d-inline-block">
                    <h3>HISTÓRICO</h3>
                </div>
                <div>
                    @if ($dispatch->count() == 0)
                        <div class="alert-success rounded-3">
                            <p class="p-10 c-g mt-4"> - Não há despachos no histórico</p>
                        </div>
                    @else

                        <table class="table table-striped bg-white">

                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Data / hora</th>
                                    <th scope="col">P/G</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Descrição</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($dispatch as $dispatchs)
                                    <tr>
                                        <th scope="row">{{ date('d/m/Y  h:m', strtotime($dispatchs->updated_at)) }}</th>
                                        <td scope="row">{{ $dispatchs->user->rank->rankAbbreviation }}</td>
                                        <td scope="row">{{ $dispatchs->user->professionalName }}</td>
                                        <td scope="row">{{ $dispatchs->descripition }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div>
                            <p>Total de despachos: <strong>{{ $dispatch->count() }}</strong></p>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
