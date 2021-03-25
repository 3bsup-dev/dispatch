<!DOCTYPE html>
<html lang="pt-br">
<head>

    @if ( !empty($dispatch[0]->status) && $dispatch[0]->status == 1)
       <title>Chegou a sua vez desloque-se até a sala do comandante &nbsp&nbsp</title>
        <script src="{{ asset('js/title-effect.js') }}"></script>

    @else
        <title>{{ $title }}</title>
    @endif

    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images/logo.png') }}"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('bootstrap/bootstrap.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('fonts/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/util.css') }}">
     {{-- SCRIPTS --}}
     <script src="{{ asset('js/jquery-3.5.1.slim.min.js') }}"></script>
     <script src="{{ asset('bootstrap/bootstrap.bundle.js') }}"></script>
     {{-- /SCRIPTS --}}
</head>
<body>
    <!-- Header -->
    <div id="header" class="header">
        <div id="logo">
            <h1><img src="{{ asset('images/acanto.png') }}"><strong>despacho</strong></h1>
            <span class="tag">3° Batalhão de Suprimento</span>
        </div>
        <nav id="nav">
            <ul>
                <li><a href="{{ route('panel') }}">Fila de despacho</a></li>
                <li><a href="{{ route('user_history') }}">Histórico</a></li>
            </ul>
        </nav>
        <div class="logout" >
            <div class="dropdown">
              <span><i class="fa fa-chevron-down"></i> {{ session('pg') }} {{ session('name') }}</span>
                    <ul class="dropdown-content">
                        <li><a href="{{ route('user_profile') }}">Perfil</a></li>
                        <li><a data-bs-toggle="modal" data-bs-target="#atl_pwd" >Alterar senha</a></li>
                    </ul>
            </div>
            <a href="{{ route('logout') }}" class="btn btn-dark btn-sm">SAIR</a>
        </div>
    </div>

    @if (isset($erro))
    <div id="error" class="align-alert d-inline-block">
         <p class="alert alert-info">{{ $erro }}</p>
    </div>
    @endif
    @if($errors->any())
    <div  id="error" class="align-alert d-inline-block">
        <ul class="alert alert-info" >
            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach
        </ul>
    </div>
@endif

    {{-- CONTEUDO --}}
    <div class="content">
       @yield('content')
    </div>


{{-- ============================================Botão flutuante========================================= --}}
@if (isset($req->status) && $req->status == 0)
    <div class="fab show">
@else
    <div class="fab">
@endif

    <button alt="Mensagem do comandante" class="main"></button>
    <ul>
        @if (isset($req->status) && $req->status == 0)
            <li>
                <div class="alert alert_default_g">
                    <p class="m-t-1 fs-12 b-b-1-g"><strong>&nbsp&nbsp Mensagem do comandante (NOVA)</strong></p>
                    <p class="fs-15 m-t-10 m-b-10 m-l-10">- {{ $req->message }}</p>
                    <p class="fs-12 float-end b-b-1-g"><strong> {{ date( 'd F Y  h:m' , strtotime($req->created_at)) }}</strong></p>
                </div>
            </li>
        @elseif (isset($req->status) && $req->status == 1)
            <li>
                <div class="alert alert_default">
                    <p class="m-t-1 fs-12 b-b-1"><strong>&nbsp&nbsp Mensagem do comandante</strong></p>
                    <p class="fs-15 m-t-10 m-b-10 m-l-10">- {{ $req->message }}</p>
                    <p class="fs-12 float-end b-b-1"><strong> {{ date( 'd F Y  h:m' , strtotime($req->created_at)) }}</strong></p>
                </div>
            </li>
        @else
            <li>
                <div class="alert alert_default">
                    <p class="fs-15 m-t-10 m-b-10 m-l-10">- Não há mensagens</p>
                </div>
            </li>
        @endif
    </ul>
</div>
{{-- =================================================================================================== --}}

    {{-- MODALS --}}
    @yield('modal')

{{-- ===================================Modal SENHA====================================================== --}}
<div class="modal fade" id="atl_pwd" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="c-b modal-title" id="TituloModalCentralizado"> Alterar a senha de {{ session('pg') }} {{ session('name') }}</h5>
        </div>
        <div class="modal-body">
      <div>
            <form action="{{ route('alt_user_pwd') }}" method="POST">
                @csrf
                <div class="wrap-input">

                    <input required class="input" type="password"  name="old_pwd" id="old_pwd">
                    <span class="focus-input" data-placeholder="Senha atual"></span>
                </div>
               <div class="wrap-input">

                    <input required class="input" type="password"  name="new_pwd" id="new_pwd">
                    <span class="focus-input" data-placeholder="Nova senha"></span>
               </div>
                <div class="wrap-input">

                    <input required class="input" type="password"  name="rep_new_pwd" id="rep_new_pwd">
                    <span class="focus-input" data-placeholder="Confirmar senha"></span>
                </div>

                <p class="c-b" >(A senha deve conter no minimo 6 digitos)</p>
      </div>
        </div>
            <div class="modal-footer">

                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
                <button type="submit" class="btn btn-success">Alterar</button>

          </form>
        </div>
      </div>
    </div>
  </div>

{{-- ============================================================================================================================= --}}


   <footer>
    <div class="copyright">
        &copy;Dispatch 2021 (v2.0) <br>
        Desenvolvido por: Sgt Souza Lima e Cb Eduardo
    </div>
</footer>
  {{-- SCRIPTS --}}
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('bootstrap/bootstrap.bundle.js') }}"></script>
  {{-- /SCRIPTS --}}
</body>
</html>
