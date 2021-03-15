@extends('layout.admin_layout')

@section('content')
<script>
    setTimeout(function(){
   window.location.reload(1);
}, 100000);
</script>
    <div class="container-fluid">
        <div class="row">
            <div class=" m-r-l  col">
                <div class="my-4 d-inline-block">
                    Aceitando despacho?
                    @if (!isset($status) || $status->status_dispatch == 1 )
                        <a class="btn btn-danger text-uppercase">Não</a>
                        <a href="{{ route('status_dispatch', ['status_dispatch' => 2]) }}" class="btn btn-secondary btn-sm text-uppercase">sim</a>
                    @elseif($status->status_dispatch == 2)
                        <a href="{{ route('status_dispatch', ['status_dispatch' => 1]) }}" class="btn btn-secondary btn-sm text-uppercase">Não</a>
                        <a class="btn btn-success  text-uppercase">sim</a>
                    @endif
                </div>
                <div>
                    @if($dispatch->count() == 0)
                        <div class="alert-success rounded-3">
                            <p class="p-10 c-g mt-4"> - Não há despachos no momento</p>
                        </div>
                    @else

                    <table class="table table-striped bg-white">

                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Posição</th>
                                <th scope="col">P/G</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dispatch as $dispatchs)
                                @if ($dispatchs->status == 1)
                                    <tr class="table-success" >
                                        <th scope="row"> Despachando </th>
                                        <td scope="row">{{ $dispatchs->user->pg}}</td>
                                        <td scope="row">{{ $dispatchs->user->name}}</td>
                                        <td scope="row">{{ $dispatchs->descripition }}</td>
                                        <td scope="row">
                                        <a class="btn btn-secondary btn-sm" title="Chamar"><i class="fa fa-clipboard-check"></i></a>
                                        <a href="{{ route('action_dispatch' , ['id_dispatch' => $dispatchs->id ,'action' => 2 ]) }}"  class="btn btn-success btn-sm" title="Despachado"><i class="fa fa-check"></i></a>
                                        <a class="btn btn-secondary btn-sm" title="Apagar"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @php
                                $i=0
                            @endphp
                            @foreach($dispatch as $dispatchs)
                                @if($dispatchs->status == 0)
                                    <tr>
                                        @php
                                            $i= $i; $i++;
                                        @endphp

                                        <th scope="row">{{ $i.'°' }}</th>
                                        <td scope="row">{{ $dispatchs->user->pg}}</td>
                                        <td scope="row">{{ $dispatchs->user->name}}</td>
                                        <td scope="row">{{ $dispatchs->descripition }}</td>
                                        <td scope="row">
                                        <a href="{{ route('action_dispatch' , ['id_dispatch' => $dispatchs->id ,'action' => 1 ]) }}" class="btn btn-primary btn-sm" title="Chamar"><i class="fa fa-clipboard-check"></i></a>
                                        <a href="{{ route('action_dispatch' , ['id_dispatch' => $dispatchs->id ,'action' => 2 ]) }}"  class="btn btn-success btn-sm" title="Despachado"><i class="fa fa-check"></i></a>
                                        <a href="{{ route('action_dispatch' , ['id_dispatch' => $dispatchs->id ,'action' => 3 ]) }}" class="btn btn-danger btn-sm" title="Apagar"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                        <div>
                            <p>Total de despachos em fila: <strong>{{ $dispatch->count() }}</strong></p>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
