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
                <div class="my-4 d-inline-block w-full ">
                        Aceitando despacho?
                        @if (!isset($status) || $status->status_dispatch == 1 )
                            <a class="btn btn-danger text-uppercase">Não</a>
                            <a href="{{ route('status_dispatch', ['status_dispatch' => 2]) }}" class="btn btn-secondary btn-sm text-uppercase">sim</a>
                        @elseif($status->status_dispatch == 2)
                            <a href="{{ route('status_dispatch', ['status_dispatch' => 1]) }}" class="btn btn-secondary btn-sm text-uppercase">Não</a>
                            <a class="btn btn-success  text-uppercase">sim</a>
                        @endif

                        <button  class="float-r m-r-10 btn btn-primary" data-bs-toggle="modal" data-bs-target="#require_dispatch"> <i class="fa fa-paper-plane"></i> REQUERER DESPACHO</button>
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

@section('modal')
{{-- require_dispatch --}}
<div class="modal fade" id="require_dispatch" aria-labelledby="modal" >
    <div class=" modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="c-b modal-header">
              <h5 class=" modal-title" id="require_dispatch">REQUERER DESPACHO</h5>

              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="c-b modal-body">
            <form action="{{ route('require_dispatch') }}" method="POST">
                @csrf
                 <!--usuario-->
                 <div class="wrap-input">
                    <select required class="input" name="user" id="user">
                        <option value=""></option>
                        @foreach ( $users as $user )
                            <option value="{{  $user->id }}" >{{ $user->pg }} {{ $user->name }}</option>
                        @endforeach
                    </select>
                    <span class="focus-input" data-placeholder="Usuário"></span>
                </div>

                <!--nome guerra-->
                <textarea required class="textarea" maxlength="250" placeholder="Digite a mensagem..." name="message" id="message" cols="30" rows="5"></textarea>

            </div>
                <div class="footer-modal-c-users">
                    <div class="float-l p-t-10  form-check">
                        <input checked class="p-r-10 form-check-input" type="checkbox" value="1" name="email" id="email">
                        <label class="form-check-label c-b" for="send_info">
                            Enviar via e-mail
                        </label>
                    </div>
                    <div class="float-r">
                    <button type="button"  class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
