@extends('layout.user_layout')

@section('content')

        <div class="container-profile" >
            <div class="wrap-profile p-t-10 p-b-8">
                <div class="home-user c-b p-t-10">
                    @if (!isset($status) || $status->status_dispatch == 1)
                    <script>
                        setTimeout(function(){
                    window.location.reload(1);
                    }, 30000);
                    </script>
                        <div class="p-t-20 fs-17 alert alert-warning">
                            <h5>O comandante não está recebendo despacho no momento.</h5>
                            @if ($fila >= 1)
                                As solicitações que haviam não foram canceladas.
                            @else
                                Todas as solicitações que haviam foram canceladas.
                            @endif
                        </div>
                            <div class="fs-25">
                            <h1 class="p-t-10">Aviso</h1>
                            @isset($status->warning)
                                {{ $status->warning }}
                            @endisset

                    @else
                        @if (isset($dispatch[0]))
                        <script>
                            setTimeout(function(){
                        window.location.reload(1);
                        }, 40000);
                        </script>
                            @if ($dispatch[0]->status == 0)
                                <h1>SOLICITAÇÃO DE DESPACHO</h1>
                                <h3>Sua posição na fila é:</h3>
                                <p class="c-b fs-100">{{ $fila }}º</p>
                                <div class="fs-25">
                                    @if ($fila == 1)
                                    Em breve você será chamado.
                                    @endif
                                <br>
                                Solicitação enviada, aguardando atendimento.<br>
                                <a data-bs-toggle="modal" data-bs-target="#cancel_dispatch"  class="m-t-30 btn btn-danger">CANCELAR</a>
                                </div>
                            @elseif($dispatch[0]->status == 1)
                                <h1>SOLICITAÇÃO DE DESPACHO</h1>
                                <p class="c-b p-t-85 p-b-85 fs-30">Chegou a sua vez desloque-se até a sala do comandante.</p>
                                <div class="fs-25 ">
                                <a data-bs-toggle="modal" data-bs-target="#cancel_dispatch" class="m-t-35 btn btn-danger">CANCELAR</a>
                                </div>
                            @endif
                        @else
                            <h1>SOLICITAR DESPACHO</h1>
                            <form action="{{ route('request_dispatch') }}" method="POST">
                                @csrf
                                <textarea placeholder="Assunto:" class="subject-dispatch fs-18" name="descripition" id="descripition"></textarea>
                                <div class="notification">
                                    <input checked class="form-check-input" type="checkbox" value="1" id="notification" name="notification" >
                                    <label class="form-check-label m-l-10" for="notification">
                                       Receber notificações via e-mail
                                    </label>
                                  </div>
                                <div class="fs-25 ">
                                    <button type="submit" class="m-t-10 btn btn-success">SOLICITAR</button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
@endsection

@section('modal')
<div class="modal fade" id="cancel_dispatch" aria-labelledby="modal" >
    <div class=" modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="c-b modal-header">
              <h5 class=" modal-title" id="cancel_dispatch">{{ session('name') }}, deseja mesmo cancelar sua solicitação de despacho ?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="c-b modal-body">
                <h5 class="modal-title" id="TituloModalCentralizado"><strong>Essa operação não pode ser desfeita!</strong></h5>
		  <br>
        Confirmando  de está ação, você perderá seu lugar na fila.<br>
        Mas você poderá criar outra solicitação.
                </div>
                <div class="modal-footer">
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="{{ route('cancel_dispatch') }}" type="submit" class="btn btn-success">Confirmar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
