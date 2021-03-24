@extends('layout.admin_layout')

@section('content')



    <div class="container-fluid">
        <div class="row">
            <div class=" m-r-l  col">
                <div class="my-4 d-inline-block w-full ">
                    <h3 class="d-inline-block m-r-30">USUÁRIOS</h3>
                        <button  class="float-r btn btn-success" data-bs-toggle="modal" data-bs-target="#create_user"> <i class="fa fa-user-plus"></i> CRIAR USUÁRIO</button>
                        <button  class="float-r m-r-10 btn btn-primary" data-bs-toggle="modal" data-bs-target="#require_dispatch"> <i class="fa fa-paper-plane"></i> REQUERER DESPACHO</button>
                </div>

                @if($list_users->count() == 0)
                    <div class="alert-success rounded-3">
                        <p class="p-10 c-g mt-4"> - Não há usuários no momento</p>
                    </div>
                @else

                <table class="table table-striped bg-white">

                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">P/G</th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Seção</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($list_users as $user)
                            <tr>
                                <th scope="row"> {{ $i++ }} </th>
                                <td scope="row">{{ $user->pg}}</td>
                                <td scope="row">{{ $user->name}}</td>
                                <td scope="row">
                                    @if ($user->email == null)
                                        <strong> - </strong>
                                    @else
                                        {{ $user->email }}
                                    @endif
                                </td>
                                <td scope="row">{{ $user->section }}</td>
                                <td colspan='2' scope="row">
                                    @if (!empty($user->deleted_at))
                                        <a href="{{ route('action_user' , ['id_user' => $user->id ,'action' => 2 ]) }}" class="btn btn-secondary btn-sm" title="Click para ativar usuário"> <i class="fs-12  fa fa-user-slash"></i> </a>
                                    @else
                                        <a href="{{ route('action_user' , ['id_user' => $user->id ,'action' => 1 ]) }}" class="btn btn-success btn-sm" title="Click para desativar usuário"><i class="fs-17 fa fa-user"></i></a>
                                    @endif
                                     <a href="{{ route('user_profile' , ['user' => $user->id]) }}" class="btn btn-dark btn-sm" title="Editar usuário"><i class="fs-15 fa fa-user-edit"></i></a>
                                    <a href="{{ route('action_user' , ['id_user' => $user->id ,'action' => 4 ]) }}" class="btn btn-primary btn-sm" title="Resetar senha usuário"><img class="icon" src="{{ asset('images/pwd-reset.png') }}" /></a>
                                    <a data-bs-toggle="modal" data-bs-target="#delete_user_{{ $user->id }}" class="btn btn-danger btn-sm" title="Excluir usuário"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                    <div>
                        <p>Total de usuários: <strong>{{ $list_users->count() }}</strong></p>
                    </div>

                @endif
            </div>
        </div>
    </div>
@endsection


{{-- Modals --}}
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
 {{-- Informações do usuario criado --}}
 @if (!empty($info_user))
<div class="modal fade show" id="info_user" aria-labelledby="modal" style="display: block;" aria-modal="true" role="dialog">
    <div class=" modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="c-b modal-title" id="info_user">USUÁRIO E SENHA DO NOVO USUÁRIO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="hide()" aria-label="Close"></button>
            </div>
            <div class="c-b fs-13 modal-body">
               <h1 class="fs-15">REPASSAR AS SEGUINTES INFORMAÇÕES AO USUÁRIO:</h1><br>
                <strong>- Usuário:</strong> {{ $info_user['login']}} <br>
                <strong>- Senha provisória:</strong> {{ $info_user['password'] }}
                <ul class="mt-3">
                    <li>1. Algumas questões importantes de segurança devem ser observadas:</li>
                    <li>a. Para a troca da senha provisória basta acessar seu perfil . A alteração da senha ocorre de forma imediata;</li>
                    <li>b .Atente para a forma da senha (deverá ser alfanumérica com no mínimo 8 caracteres - incluir letras maiúsculas, minúsculas e números)</li>
                    <li>c. é recomendado que o usuário troque sua senha mensalmente;</li>
                    <li>d. a senha é pessoal e intransferível, portanto não deve ser compartilhada;</li>
                </ul>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" onclick="hide()">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div id='backdrop' class="modal-backdrop fade show"></div>
 @endif

{{-- Criar novo usuario --}}
<div class="modal fade" id="create_user" aria-labelledby="modal" >
    <div class=" modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="c-b modal-header">
              <h5 class=" modal-title" id="create_user">NOVO USUÁRIO <p class="fs-12 c-b"> (A senha é gerada automaticamente)</p></h5>

              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="c-b modal-body">
            <form action="{{ route('create_user') }}" method="POST">
                @csrf
                        <!--PG-->
                    <div class="wrap-input">
                        <select required class="input"  name="pg" id="pg">
                            <option value=""></option>
                            <option value="Gen">Gen</option>
                            <option value="Cel">Cel</option>
                            <option value="TC">TC</option>
                            <option value="Maj">Maj</option>
                            <option value="Cap">Cap</option>
                            <option value="Ten">Ten</option>
                            <option value="ST">ST</option>
                            <option value="Sgt">Sgt</option>
                            <option value="Cb">Cb</option>
                            <option value="Sd">Sd</option>
                        </select>
                        <span class="focus-input" data-placeholder="Post/Grad"></span>
                    </div>

                    <!--nome guerra-->
                    <div class="wrap-input">
                        <input required class="input" type="text"  name="name" id="name">
                        <span class="focus-input" data-placeholder="Nome de guerra"></span>
                    </div>

                     <!--nome login-->
                     <div class="wrap-input">
                        <input required class="input" type="text" name="login" id="login">
                        <span class="focus-input" data-placeholder="Login"></span>
                    </div>

                    <!--section-->
                    <div class="wrap-input">
                        <select required class="input" name="section" id="section">
                            <option  value=""></option>
                            <option  value="COMANDANTE">COMANDANTE</option>
                            <option  value="Cmt Cia - 1ª Cia">Cmt Cia - 1ª Cia</option>
                            <option  value="Arrecadação - 1ª Cia">Arrecadação - 1ª Cia</option>
                            <option  value="Sargenteação - 1ª Cia">Sargenteação - 1ª Cia</option>
                            <option  value="Cmt Cia - 2ª Cia">Cmt Cia - 2ª Cia</option>
                            <option  value="Arrecadação - 2ª Cia">Arrecadação - 2ª Cia</option>
                            <option  value="Sargenteação - 2ª Cia">Sargenteação - 2ª Cia</option>
                            <option  value="LQR/3">LQR/3</option>
                            <option  value="Cmt Cia - 3ª Cia">Cmt Cia - 3ª Cia</option>
                            <option  value="Arrecadação - 3ª Cia">Arrecadação - 3ª Cia </option>
                            <option  value="Sargenteação - 3ª Cia">Sargenteação - 3ª Cia</option>
                            <option  value="Almoxarifado">Almoxarifado</option>
                            <option  value="Aprovisionamento">Aprovisionamento</option>
                            <option  value="Canil - Seção Cães de Guerra">Seção Cães de Guerra</option>
                            <option  value="Cmt Cia - CCSv">Cmt Cia - CCSv</option>
                            <option  value="Arrecadação - CCSv">Arrecadação - CCSv</option>
                            <option  value="Sargenteação da CCSv">Sargenteação da CCSv</option>
                            <option  value="Seção de Saúde">Seção de Saúde</option>
                            <option  value="Classe I">Classe I</option>
                            <option  value="Classe II">Classe II</option>
                            <option  value="Classe III-IX">Classe III-IX</option>
                            <option  value="Classe VIII">Classe VIII</option>
                            <option  value="COST">COST</option>
                            <option  value="Classe V">Classe V</option>
                            <option  value="Pelotão de Armamento">Pelotão de Armamento</option>
                            <option  value="Pelotão de Munição">Pelotão de Munição</option>
                            <option  value="Escritório de Projetos e Gestão">Escritório de Projetos e Gestão </option>
                            <option  value="Fiscalização Administrativa">Fiscalização Administrativa</option>
                            <option  value="LIAB">LIAB</option>
                            <option  value="Patrimônio">Patrimônio</option>
                            <option  value="Pelotão de Comunicações">Pelotão de Comunicações</option>
                            <option  value="Pelotão de Obras">Pelotão de Obras</option>
                            <option  value="Pelotão de Segurança">Pelotão de Segurança</option>
                            <option  value="Pelotão de Transporte">Pelotão de Transporte</option>
                            <option  value="Relações Públicas">Relações Públicas</option>
                            <option  value="1ª Seção">1ª Seção</option>
                            <option  value="2ª Seção">2ª Seção</option>
                            <option  value="3ª Seção">3ª Seção</option>
                            <option  value="SALC">SALC</option>
                            <option  value="Seção Mobilizadora">Seção Mobilizadora</option>
                            <option  value="Secretaria">Secretaria</option>
                            <option  value="Setor Financeiro">Setor Financeiro</option>
                            <option  value="Setor Pagamento">Setor Pagamento</option>
                            <option  value="SFPC">SFPC</option>
                            <option  value="Subcomandante">Subcomandante</option>
                            <option  value="Suporte Documental">Suporte Documental</option>
                        </select>
                        <span class="focus-input" data-placeholder="Seção"></span>
                    </div>

                    <!--email-->
                    <div class="wrap-input">
                        <input class="input" type="email" name="email" id="email">
                        <span class="focus-input" data-placeholder="Email"></span>
                    </div>

                    <!--profile-->
                    <div class="wrap-input">
                        <select required class="input" name="profile" id="profile">
                            <option value=""></option>
                            <option value="1" >Administrador</option>
                            <option value="0">Convencional</option>
                        </select>
                        <span class="focus-input" data-placeholder="Tipo de conta"></span>
                    </div>
                </div>

                <div class="footer-modal-c-users">
                    <div class="float-l p-t-10  form-check">
                        <input checked class="p-r-10 form-check-input" type="checkbox" value="yes" name="send_info" id="send_info">
                        <label class="form-check-label c-b" for="send_info">
                            Enviar dados por e-mail
                        </label>
                    </div>
                    <div class="float-r">
                    <button type="button"  class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ( $list_users as $user )
<div class="modal fade" id="delete_user_{{ $user->id }}" aria-labelledby="modal" >
    <div class=" modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="c-b modal-header">
              <h5 class=" modal-title" id="delete_user">{{ session('name') }}, deseja mesmo excluir {{ $user->pg }} {{ $user->name }} ?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="c-b modal-body">
                <h5 class="modal-title" id="TituloModalCentralizado"><strong>Essa operação não pode ser desfeita!</strong></h5>
		  <br>
        Confirmando a exclusão de <strong>{{ $user->pg }} {{ $user->name }}</strong>, todos os dados contidos neste usuário serão excluidos <strong>permanentementes</strong>
                </div>
                <div class="modal-footer">

                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="{{ route('action_user' , ['id_user' => $user->id ,'action' => 3 ]) }}" type="submit" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<script src="{{ asset('js/create-user.js') }}"></script>
@endsection
