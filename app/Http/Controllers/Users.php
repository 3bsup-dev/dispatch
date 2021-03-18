<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AltPwdRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRequest;
use App\Models\Dispatch;
use App\Models\User;
use App\Models\Warning;
use App\Classes\Email;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Users extends Controller
{
//=======================[Email]===================
    private $Email;
    public function __construct()
    {
        $this->Email = new Email();
    }
//==============================[users]=====================================
    public function user(){

        //Verifica se o usuário esta logado
        if(!session()->has('user')){
            return redirect()->route('login');
        }
        if(!session('profile') == 1){
            return redirect()->route('index');
        }

        $list_users = User::withTrashed()->get();

        $info_new_user = [];
        if(!empty(session('new_user')['login'])){
            $info_new_user = [
                'login' =>session('new_user')['login'] ,
                'password' => session('new_user')['password']
            ];
        }
        $status = Warning::all()->first();
        $dados = [
            'status' => $status,
            'erro' => session('erro'),
            'info_user' => $info_new_user,
            'list_users' => $list_users,
            'title'    => 'Despacho - Usuários',
        ];

        return view('users' ,$dados);
    }
//==============================[create_user]===============================
    public function create_user(UserRequest $request){
        //Verifica se o usuário esta logado
        if(!session()->has('user')){
            return redirect()->route('login');
        }
        if(!session('profile') == 1){
            return redirect()->route('index');
        }

        $request->validated();
        //Buscando valores dos inputs
        $pg = $request->input('pg');
        $name = $request->input('name');
        $section = $request->input('section');
        $email = $request->input('email');
        $profile = $request->input('profile');
        $login = '3bsup-'.str_replace(' ', '',strtolower($request->input('login')));
        $password = rand(10000000,99999999);
        $send_info = $request->input('send_info');

        $user = User::where('login', $login)->first();//Procurando se na coluna usuario existe tal user e pegando o primeiro da lista
        if($user){//Se não existe $x
           session()->flash('erro','Este usuário já existe.');
           return redirect()->route('user');
        }

        //Especificando tabela a inserir dados
        $user = new User;

        //Inserindo dados
        $user->pg = $pg;
        $user->name = $name;
        $user->section = $section;
        $user->email = $email;
        $user->profile = $profile;
        $user->login = $login;
        $user->password = Hash::make($password);
        $user->save();

        session()->flash('new_user',[
            'login' => $login,
            'password' => $password,
        ]);

        if(!empty($email) && $send_info == 'yes' ){
            $info = [
                'email' => $email,
                'login' => $login,
                'password' => $password,
                'name' => $name,
            ];
            $this->Email->info_login($info);
        }


        return redirect()->route('user');
    }

//==============================[actions_user]==============================
    public function action_user($id_user ,$action){

    //Verifica se o usuário esta logado
    if(!session()->has('user')){
       return redirect()->route('login');
   }
   if(!session('profile') == 1){
      return redirect()->route('index');
   }

    if($action == 1){
        $user = User::find($id_user);
        $user->delete();
    }elseif($action == 2){
       $restore = User::withTrashed()->find($id_user);
       $restore->deleted_at = null;
       $restore->save();
    }elseif($action == 3){
        $user = User::withTrashed()->find($id_user); // PEGA O ID DO USUÁRIO
        $user->forceDelete(); // DELETA O USUÁRIO COM SOFT DELETE
        $del_dispatch = Dispatch::where('user_id',$id_user)->withTrashed()->get(); // PESQUISA TODAS OS DESPACHOS EXISTENTES E APAGA

        foreach ($del_dispatch as $dispatch){
            $dispatch->forceDelete();
        }
    }elseif($action == 4){
        $password = rand(10000000,99999999);
        $user = User::withTrashed()->find($id_user);
        $user->password = Hash::make($password);
        $user->save();
        session()->flash('new_user',[
            'login' => $user->login,
            'password' => $password,
        ]);
    }


      return redirect()->route('user');
 }
//==============================[alt_user_pwd]==============================
    public function alt_user_pwd(AltPwdRequest $request){

        if(!session()->has('user')){
            return redirect()->route('login');
        }

        $user_id = session('user_id');
        $old_pwd = trim($request->input('old_pwd'));
        $new_pwd = trim($request->input('new_pwd'));
        $rep_new_pwd = trim($request->input('rep_new_pwd'));

        $user = User::where('id', $user_id)->first();


        //Verifica se a senha antiga ta correta
        if(!Hash::check($old_pwd, $user->password)){
            session()->flash('erro','Senha atual incorreta.');

            if(session('profile') == 1){
                return redirect()->route('admin');
            }else{
                return redirect()->route('panel');
            }
        }

        if ($new_pwd == $rep_new_pwd) {

            $user = User::find($user_id);
            $user->password = Hash::make($new_pwd);
            $user->save();
            session()->flash('erro','Sua senha foi alterada com sucesso.');
            if(session('profile') == 1){
                return redirect()->route('admin');
            }else{
                return redirect()->route('panel');
            }


        } else {
            session()->flash('erro','Os campos "Nova senha" e "Confirmar senha" devem ser iguais.');
            if(session('profile') == 1){
                return redirect()->route('admin');
            }else{
                return redirect()->route('panel');
            }
        }





    }
//==============================[admin_profile]=============================
    public function admin_profile(){
        if(!session()->has('user')){
            return redirect()->route('login');
        }

        $user_id = session('user_id');
        $info_user = User::find($user_id);

        $dados = [
            'erro' => session('erro'),
            'info_user' => $info_user,
            'title'    => "Despacho - $info_user->pg $info_user->name ",
        ];

        return view('admin_profile' ,$dados);


    }

//==============================[user_profile]==============================
    public function user_profile($user = ''){
        if(!session()->has('user')){
            return redirect()->route('login');
        }


        $user_id = session('user_id');

        if (!empty($user)){
          $user_id = $user;
        }


        $info_user = User::find($user_id);

        $dados = [
            'erro' => session('erro'),
            'info_user' => $info_user,
            'title'    => "Despacho - $info_user->pg $info_user->name ",
        ];

        if(session('profile') == 1){
            return view('admin_profile' ,$dados);
        }else{
            return view('user_profile' ,$dados);
        }


    }
//==============================[edit_profile]=========================
    public function edit_user_profile(UserEditRequest $request){
        //Verifica se o usuário esta logado
        if(!session()->has('user')){
            return redirect()->route('login');
        }

        $request->validated();

        $user_id = session('user_id');

        if (!empty($request->input('user_id'))){
            $user_id = $request->input('user_id');
        }


        //Buscando valores dos inputs
        $pg = $request->input('pg');
        $name = $request->input('name');
        $section = $request->input('section');
        $email = $request->input('email');
        $profile = $request->input('profile');
        if(session('profile') == 0 ) {
            $profile = session('profile');
        }
        $login = '3bsup-'.str_replace(' ', '',strtolower($request->input('login')));
        $notification = $request->input('notification');


    $info_user = User::find($user_id);

    if($login != $info_user->login){
        $user = User::where('login', $login)->first();//Procurando se na coluna usuario existe tal user e pegando o primeiro da lista

        if($user){//Se não existe $x
            session()->flash('erro','Este usuário já existe.');

            if(session('profile') == 1){
                return redirect()->route('user_profile', ['user' => $user_id ]);
            }else{
                return redirect()->route('user_profile');
            }
        }
    }


        //Inserindo dados
        $info_user->pg = $pg;
        $info_user->name = $name;
        $info_user->section = $section;
        $info_user->email = $email;
        $info_user->profile = $profile;
        $info_user->login = $login;
        $info_user->notification = $notification;
        $info_user->save();
        if (empty($request->input('user_id'))){
            session()->put([
                'user' => $login,
                'pg' => $pg,
                'name' => $name,
                'email' => $email,
                ]);
        }


    if(session('profile') == 1){
        return redirect()->route('user_profile', ['user' => $user_id ]);
    }else{
        return redirect()->route('user_profile');
    }



    }


//==========================================================================
//==========================================================================
//==========================================================================
//==========================================================================
//==========================================================================
}
