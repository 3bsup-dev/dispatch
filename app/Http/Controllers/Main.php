<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Warning;
use Illuminate\Support\Facades\Hash;
use App\Models\Request;

class Main extends Controller
{
   //===================================INDEX==================================
   public function index(){

    //Verifica se o usuário esta logado
    if(session()->has('user')){
        if (session('profile') == 1) {
            return redirect()->route('admin');
        } else {
            $warning = Warning::all()->first();
            session()->flash('warning' ,$warning->warning);
            return redirect()->route('panel');
        }
    }else{
        return redirect()->route('login');
    }
}
//===========================================================================




//============================================================================
public function login(){

    //Verifica se o usuário esta logado
    if(session()->has('user')){
        return redirect()->route('index');
    }

    $erro = session('erro');
    $data = [];
    if(!empty($erro)){
        $data = [
            'erro' => $erro,
        ];
    }

     //Apresenta o formulario de login
     return view('login', $data);

   }

//======================================================================
   public function login_submit(LoginRequest $request){

     //Validação
    $request->validated();// Caso exista um erro no formulario ele vezifica e retorna uma mensagem de erro


    //Verificar dados de login
    $login = trim($request->input('login'));//O trim() remove espaços das laterais que podem ter sidos colocados por acidente
    $password = trim($request->input('password'));//Buscando dados do input

    $user = User::where('login', $login)->first();//Procurando se na coluna usuario existe tal user e pegando o primeiro da lista

    if(!$user){//Se não existe $x
       session()->flash('erro','Este usuário não existe.');
       return redirect()->route('login');
    }

     //Verifica se a senha ta correta
    if(!Hash::check($password, $user->password)){

        session()->flash('erro','Senha incorreta.');
        return redirect()->route('login');
    }

      //Inicia uma sessao

      session()->put([
          'profile' => $user->profile,
          'user'    => $user->login,
          'name'    => $user->name,
          'pg'      => $user->pg,
          'user_id' => $user->id,
          'email'   => $user->email
      ]);


     return redirect()->route('index');


  }
//==========================================================================
public function logout(){

    session()->flush();
    return redirect()->route('index');

}
}
