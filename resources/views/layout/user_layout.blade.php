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
{{-- =======================================AVISO DO CMT============================================ --}}

@if (!empty($warning))
<div class="modal fade show" id="info_user" aria-labelledby="modal" style="display: block;" aria-modal="true" role="dialog">
    <div class=" modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="c-b modal-title" id="info_user">AVISO DO COMANDANTE</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="hide()" aria-label="Close"></button>
            </div>
            <div class="c-b fs-13 modal-body">
               <h1 class="fs-20">{{ $warning }}</h1><br>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" onclick="hide()">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div id='backdrop' class="modal-backdrop fade show"></div>
 @endif


   <footer>
    <div class="copyright">
        &copy;Dispatch 2021 (v1.1) <br>
        Desenvolvido por: Sgt Souza Lima e Cb Eduardo
    </div>
</footer>
  {{-- SCRIPTS --}}
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('bootstrap/bootstrap.bundle.js') }}"></script>
  {{-- /SCRIPTS --}}
</body>
</html>
