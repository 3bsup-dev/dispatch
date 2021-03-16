<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReqDispatchRequest;
use App\Models\Dispatch;
use App\Models\Warning;
use App\Classes\Email;
use Illuminate\Http\Request;


class Dispatches extends Controller
{
//=======================[Email]===================
    private $Email;
    public function __construct()
    {
        $this->Email = new Email();
    }

//=============================[admin]======================================
    public function admin(){

        //Verifica se o usuário esta logado
         if(!session()->has('user')){
             return redirect()->route('login');
         }
         if(!session('profile') == 1){
            return redirect()->route('index');
         }

        $dispatch = Dispatch::where('status','<=', 1)->with('user')->orderBy('created_at','asc')->get();
        $status = Warning::all()->first();

         $dados = [
            'erro' => session('erro'),
            'status'   => $status,
            'dispatch' => $dispatch,
            'title'    => 'Despacho - Administrador',


        ];

        $i=0;
        foreach($dispatch as $dispatch){
            $i= $i; $i++;
            if(!empty($dispatch->user->email) && $dispatch->notification == 1 && $i <= 2){
                    // if($i != session($dispatch->user->login.'queue') || $dispatch->status == 1 ){
                    //      if($dispatch->status == 1){
                    //          $dispatch->notification = 2;
                    //          $dispatch->save();
                    //      }
                    $this->Email->queue_dispatch($dispatch);
                  //  }
            }
            session([$dispatch->user->login.'queue' => $i]);
        }
         return view('mail.dispatch',$dados);
      }


//=============================[panel_user]=================================
public function panel(){
    //Verifica se o usuário esta logado
    if(!session()->has('user')){
        return redirect()->route('login');
    }
    if(!session('profile') == 0){
       return redirect()->route('index');
    }

    $status = Warning::all()->first();
    $user_id = session('user_id');
    $dispatch = Dispatch::where('user_id', $user_id)->where('status', '<=', 1)->get();
    $fila = 0;
    if(isset($dispatch[0])){
    $fila = Dispatch::where('id', '<=', $dispatch[0]->id)->where('status', 0)->count();
    }

    $dados = [
        'warning' => session('warning'),
        'status' => $status,
        'dispatch' => $dispatch,
        'fila' => $fila,
        'erro' => session('erro'),
        'title'    => 'Despacho - Home',
    ];

    return view('user_panel',$dados);
}
//=============================[action_dispatch]============================
      public function action_dispatch($id_dispatch,$action){

         //Verifica se o usuário esta logado
         if(!session()->has('user')){
            return redirect()->route('login');
        }
        if(!session('profile') == 1){
           return redirect()->route('index');
        }

        if($action == 1){
            $check_status = Dispatch::where('status', 1)->first();

            if($check_status){
            session()->flash('erro','Não pode haver dois militares despachando finalize o despacho antes de chamar o proximo.');
            return redirect()->route('admin');
            }
        }


        $dispatch = Dispatch::find($id_dispatch);

        if($action == 1 || $action == 2){
            $dispatch->status = $action;
            $dispatch->save();
        }elseif($action == 3){
            $dispatch->delete();
        }elseif($action == 4){
            $dispatch->delete();
        }elseif($action == 6){
            $restore = Dispatch::withTrashed()->find($id_dispatch);
            $restore->deleted_at = null;
            $restore->save();
        }

        if ($action == 4) {
           return redirect()->route('history_dispatch');
        }elseif ($action == 6) {
            return redirect()->route('trash_dispatch');
        }else {
           return redirect()->route('admin');
        }



      }
//=============================[Historico]==================================
    public function history_dispatch(){

    //Verifica se o usuário esta logado
     if(!session()->has('user')){
         return redirect()->route('login');
     }
     if(!session('profile') == 1){
        return redirect()->route('index');
     }

    $dispatch = Dispatch::where('status', 2)->with('user')->orderBy('updated_at','desc')->get();
    //$dispatch = Dispatch::withTrashed()->with('user')->orderBy('updated_at','desc')->get();
    $status = Warning::all()->first();
     $dados = [
        'status' => $status,
        'dispatch' => $dispatch,
        'title'    => 'Despacho - Histórico',
    ];

     return view('history',$dados);
  }
//=============================[trash_dispatch]=============================
    public function trash_dispatch(){

    //Verifica se o usuário esta logado
     if(!session()->has('user')){
         return redirect()->route('login');
     }
     if(!session('profile') == 1){
        return redirect()->route('index');
     }

    $dispatch = Dispatch::onlyTrashed()->orderBy('deleted_at','desc')->get();
    $status = Warning::all()->first();
    $dados = [
        'status' => $status,
        'dispatch' => $dispatch,
        'title'    => 'Despacho - Lixeira',
    ];

     return view('trash',$dados);
  }
//=============================[clean_trash]================================
    public function clean_trash(){

    //Verifica se o usuário esta logado
     if(!session()->has('user')){
         return redirect()->route('login');
     }
     if(!session('profile') == 1){
        return redirect()->route('index');
     }

    $trash = Dispatch::onlyTrashed()->get();

    foreach ($trash as $dispatch){

        $dispatch->forceDelete();

    }

     return redirect()->route('trash_dispatch');
  }

//=============================[request_dispatch]===========================
    public function request_dispatch(ReqDispatchRequest $request){
         //Verifica se o usuário esta logado
         if(!session()->has('user')){
            return redirect()->route('login');
        }
        if(!session('profile') == 0){
           return redirect()->route('index');
        }

        $check_sts_cmt = Warning::all()->first();
        if($check_sts_cmt->status_dispatch == 1){
            session()->flash('erro','O comandante não está recebendo despacho no momento.');
            return redirect()->route('panel');
        }
        $request->validated();
        $descripition = $request->input('descripition');

        $dispatch = new Dispatch;
        $dispatch->user_id = session('user_id');
        $dispatch->descripition = $descripition;
        $dispatch->status = 0;
        $dispatch->save();

        return redirect()->route('panel');
    }
//=============================[cancel_dispatch]============================
    public function cancel_dispatch(){
         //Verifica se o usuário esta logado
        if(!session()->has('user')){
            return redirect()->route('login');
        }
        if(!session('profile') == 0){
           return redirect()->route('index');
        }

        $user_id = session('user_id');

        $dispatch = Dispatch::where('user_id', $user_id)->where('status','<=',1)->get();

        if (isset($dispatch[0])) {
            $dispatch[0]->delete();
        }


        return redirect()->route('panel');
    }
//=============================[user_history]=============================
    public function user_history(){

        //Verifica se o usuário esta logado
        if(!session()->has('user')){
            return redirect()->route('login');
        }
        if(!session('profile') == 0){
            return redirect()->route('index');
        }

        $user_id = session('user_id');
        $dispatch = Dispatch::where('status', 2)->where('user_id', $user_id)->with('user')->orderBy('updated_at','desc')->get();

        $dados = [
            'dispatch' => $dispatch,
            'title'    => 'Despacho - Histórico',
        ];

        return view('user_history',$dados);
    }
}
