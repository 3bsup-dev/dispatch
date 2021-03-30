@extends('layout.admin_layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class=" m-r-l  col">
                <div class="my-4 d-inline-block">
                 <h3>LIXEIRA</h3>
                </div>
                <div>
                    @if($dispatch->count() == 0)
                        <div class="alert-success rounded-3">
                            <p class="p-10 c-g mt-4"> - Não há despachos na lixeira.</p>
                        </div>
                    @else

                    <table class="table table-striped bg-white">

                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="150px">Data / hora</th>
                                <th scope="col" width="60px">P/G</th>
                                <th scope="col" width="150px">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Ações</th>
                                <th class=" text-end"  scope="col" width="150px"> <a class="btn btn-danger btn-sm" href="{{ route('clean_trash') }}"><i class="fa fa-trash"></i> Esvaziar lixeira</a></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($dispatch as $dispatchs)
                                    <tr>
                                        <th scope="row">{{ date( 'd/m/Y  h:m' , strtotime($dispatchs->updated_at)) }}</th>
                                        <td scope="row">{{ $dispatchs->user->pg}}</td>
                                        <td scope="row">{{ $dispatchs->user->name}}</td>
                                        <td scope="row">{{ $dispatchs->descripition }}</td>
                                        <td  colspan="2" scope="row">
                                        <a href="{{ route('action_dispatch' , ['id_dispatch' => $dispatchs->id ,'action' => 6 ]) }}" class="btn btn-success btn-sm" title="Restaurar"><i class="fa fa-reply"></i></a>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>

                        <div>
                            <p>Total de despachos na lixeira: <strong>{{ $dispatch->count() }}</strong></p>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
