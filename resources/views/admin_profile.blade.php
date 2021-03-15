@extends('layout.admin_layout')

@section('content')

                <div class="container-profile" >
                    <div class="wrap-profile p-t-10 p-b-10">

                        <span class="login100-form-title p-b-41">
                          <a href="{{route('user')}}" class="c-b p-t-10 float-l"><i class=" fs-1 fa fa-arrow-left"></i></a>  <div class="c-b p-t-10">{{$info_user->pg }} {{ $info_user->name }}<button id="enable-form" class="fa fa-user-edit float-r "></button></div>
                        </span>
                        <form action="{{ route('edit_user_profile') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $info_user->id }}"  name="user_id" id="user_id" >
                                    <!--PG-->
                                <div class="wrap-input">
                                    <select disabled required class="input has-val"  name="pg" id="pg">
                                        <option value=""></option>
                                        <option @if($info_user->pg == "Gen") selected="selected" @endif value="Gen">Gen</option>
                                        <option @if($info_user->pg == "Cel") selected="selected" @endif value="Cel">Cel</option>
                                        <option @if($info_user->pg == "TC") selected="selected" @endif value="TC">TC</option>
                                        <option @if($info_user->pg == "Maj") selected="selected" @endif value="Maj">Maj</option>
                                        <option @if($info_user->pg == "Cap") selected="selected" @endif value="Cap">Cap</option>
                                        <option @if($info_user->pg == "Ten") selected="selected" @endif value="Ten">Ten</option>
                                        <option @if($info_user->pg == "ST") selected="selected" @endif value="ST">ST</option>
                                        <option @if($info_user->pg == "Sgt") selected="selected" @endif value="Sgt">Sgt</option>
                                        <option @if($info_user->pg == "Cb") selected="selected" @endif  value="Cb">Cb</option>
                                        <option @if($info_user->pg == "Sd") selected="selected" @endif value="Sd">Sd</option>
                                    </select>
                                    <span class="focus-input" data-placeholder="Post/Grad"></span>
                                </div>

                                <!--nome guerra-->
                                <div class="wrap-input">
                                    <input disabled required class="input has-val" type="text" value="{{ $info_user->name }}"  name="name" id="name">
                                    <span class="focus-input" data-placeholder="Nome de guerra"></span>
                                </div>

                                 <!--nome login-->
                                 <div class="wrap-input">
                                    <input disabled required class="input has-val" type="text" value="{{ str_replace('3bsup-', '', $info_user->login ) }}" name="login" id="login">
                                    <span class="focus-input" data-placeholder="Usuário"></span>
                                </div>

                                <!--section-->
                                <div class="wrap-input">
                                    <select disabled required class="input has-val" name="section" id="section">
                                        <option  value=""></option>
                                        <option @if($info_user->section == "COMANDANTE") selected="selected" @endif value="COMANDANTE">COMANDANTE</option>
                                        <option @if($info_user->section == "Cmt Cia - 1ª Cia") selected="selected" @endif value="Cmt Cia - 1ª Cia">Cmt Cia - 1ª Cia</option>
                                        <option @if($info_user->section == "Cmt Cia - 1ª Cia") selected="selected" @endif value="Cmt Cia - 1ª Cia">Arrecadação - 1ª Cia</option>
                                        <option @if($info_user->section == "Sargenteação - 1ª Cia") selected="selected" @endif value="Sargenteação - 1ª Cia">Sargenteação - 1ª Cia</option>
                                        <option @if($info_user->section == "Cmt Cia - 2ª Cia") selected="selected" @endif value="Cmt Cia - 2ª Cia">Cmt Cia - 2ª Cia</option>
                                        <option @if($info_user->section == "Arrecadação - 2ª Cia") selected="selected" @endif value="Arrecadação - 2ª Cia">Arrecadação - 2ª Cia</option>
                                        <option @if($info_user->section == "Sargenteação - 2ª Cia") selected="selected" @endif value="Sargenteação - 2ª Cia">Sargenteação - 2ª Cia</option>
                                        <option @if($info_user->section == "LQR/3") selected="selected" @endif value="LQR/3">LQR/3</option>
                                        <option @if($info_user->section == "Cmt Cia - 3ª Cia") selected="selected" @endif value="Cmt Cia - 3ª Cia">Cmt Cia - 3ª Cia</option>
                                        <option @if($info_user->section == "Arrecadação - 3ª Cia") selected="selected" @endif value="Arrecadação - 3ª Cia">Arrecadação - 3ª Cia </option>
                                        <option @if($info_user->section == "Sargenteação - 3ª Cia") selected="selected" @endif value="Sargenteação - 3ª Cia">Sargenteação - 3ª Cia</option>
                                        <option @if($info_user->section == "Almoxarifado") selected="selected" @endif value="Almoxarifado">Almoxarifado</option>
                                        <option @if($info_user->section == "Aprovisionamento") selected="selected" @endif value="Aprovisionamento">Aprovisionamento</option>
                                        <option @if($info_user->section == "Canil - Seção Cães de Guerra") selected="selected" @endif value="Canil - Seção Cães de Guerra">Seção Cães de Guerra</option>
                                        <option @if($info_user->section == "Cmt Cia - CCSv") selected="selected" @endif value="Cmt Cia - CCSv">Cmt Cia - CCSv</option>
                                        <option @if($info_user->section == "Arrecadação - CCSv") selected="selected" @endif value="Arrecadação - CCSv">Arrecadação - CCSv</option>
                                        <option @if($info_user->section == "Sargenteação da CCSv") selected="selected" @endif value="Sargenteação da CCSv">Sargenteação da CCSv</option>
                                        <option @if($info_user->section == "Seção de Saúde") selected="selected" @endif value="Seção de Saúde">Seção de Saúde</option>
                                        <option @if($info_user->section == "Classe I") selected="selected" @endif value="Classe I">Classe I</option>
                                        <option @if($info_user->section == "Classe II") selected="selected" @endif value="Classe II">Classe II</option>
                                        <option @if($info_user->section == "Classe III-IX") selected="selected" @endif value="Classe III-IX">Classe III-IX</option>
                                        <option @if($info_user->section == "Classe VIII") selected="selected" @endif value="Classe VIII">Classe VIII</option>
                                        <option @if($info_user->section == "COST") selected="selected" @endif value="COST">COST</option>
                                        <option @if($info_user->section == "Classe V") selected="selected" @endif value="Classe V">Classe V</option>
                                        <option @if($info_user->section == "Pelotão de Armamento") selected="selected" @endif value="Pelotão de Armamento">Pelotão de Armamento</option>
                                        <option @if($info_user->section == "Pelotão de Munição") selected="selected" @endif value="Pelotão de Munição">Pelotão de Munição</option>
                                        <option @if($info_user->section == "Escritório de Projetos e Gestão") selected="selected" @endif value="Escritório de Projetos e Gestão">Escritório de Projetos e Gestão </option>
                                        <option @if($info_user->section == "Fiscalização Administrativa") selected="selected" @endif value="Fiscalização Administrativa">Fiscalização Administrativa</option>
                                        <option @if($info_user->section == "LIAB") selected="selected" @endif value="LIAB">LIAB</option>
                                        <option @if($info_user->section == "Patrimônio") selected="selected" @endif value="Patrimônio">Patrimônio</option>
                                        <option @if($info_user->section == "Pelotão de Comunicações") selected="selected" @endif value="Pelotão de Comunicações">Pelotão de Comunicações</option>
                                        <option @if($info_user->section == "Pelotão de Obras") selected="selected" @endif value="Pelotão de Obras">Pelotão de Obras</option>
                                        <option @if($info_user->section == "Pelotão de Segurança") selected="selected" @endif value="Pelotão de Segurança">Pelotão de Segurança</option>
                                        <option @if($info_user->section == "Pelotão de Transporte") selected="selected" @endif value="Pelotão de Transporte">Pelotão de Transporte</option>
                                        <option @if($info_user->section == "Relações Públicas") selected="selected" @endif value="Relações Públicas">Relações Públicas</option>
                                        <option @if($info_user->section == "1ª Seção") selected="selected" @endif value="1ª Seção">1ª Seção</option>
                                        <option @if($info_user->section == "2ª Seção") selected="selected" @endif value="2ª Seção">2ª Seção</option>
                                        <option @if($info_user->section == "3ª Seção") selected="selected" @endif value="3ª Seção">3ª Seção</option>
                                        <option @if($info_user->section == "SALC") selected="selected" @endif value="SALC">SALC</option>
                                        <option @if($info_user->section == "Seção Mobilizadora") selected="selected" @endif value="Seção Mobilizadora">Seção Mobilizadora</option>
                                        <option @if($info_user->section == "Secretaria") selected="selected" @endif value="Secretaria">Secretaria</option>
                                        <option @if($info_user->section == "Setor Financeiro") selected="selected" @endif value="Setor Financeiro">Setor Financeiro</option>
                                        <option @if($info_user->section == "Setor Pagamento") selected="selected" @endif value="Setor Pagamento">Setor Pagamento</option>
                                        <option @if($info_user->section == "SFPC") selected="selected" @endif value="SFPC">SFPC</option>
                                        <option @if($info_user->section == "Subcomandante") selected="selected" @endif value="Subcomandante">Subcomandante</option>
                                        <option @if($info_user->section == "Suporte Documental") selected="selected" @endif value="Suporte Documental">Suporte Documental</option>
                                    </select>
                                    <span class="focus-input" data-placeholder="Seção"></span>
                                </div>

                                <!--email-->
                                <div class="wrap-input">
                                    <input disabled class="input has-val" type="email" @if(isset($info_user->email))value="{{ $info_user->email }}" @else placeholder="Cadastre seu email e receba notificações" @endif name="email" id="email">
                                    <span class="focus-input" data-placeholder="Email"></span>
                                </div>
                                 <!--profile-->
                                <div class="wrap-input">
                                    <select  disabled required class="input has-val" name="profile" id="profile">
                                        <option value=""></option>
                                        <option @if($info_user->profile == "1") selected="selected" @endif value="1" >Administrador</option>
                                        <option @if($info_user->profile == "0") selected="selected" @endif value="0">Convencional</option>
                                    </select>
                                    <span class="focus-input" data-placeholder="Tipo de conta"></span>
                                </div>
                                <div id="btn-submit"></div>
                        </form>

                    </div>
                </div>

@endsection
