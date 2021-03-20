<?php

namespace App\Http\Controllers;

use App\Classes\Email;
use App\Http\Controllers\Controller;
use App\Http\Requests\WarningRequest;
use App\Models\Dispatch;
use App\Models\Warning;
use Illuminate\Http\Request;

class Warnings extends Controller
{
//=======================[Email]===================
    private $Email;
    public function __construct()
    {
        $this->Email = new Email();
    }

//=======================[status_dispatch]===========================================
    public function status_dispatch($status_dispatch){

        //Verifica se o usuário esta logado
        if(!session()->has('user')){
            return redirect()->route('login');
        }
        if(!session('profile') == 1){
        return redirect()->route('index');
        }

        $check_warning = Warning::all()->first();

        if(isset($check_warning)){
            $warning = Warning::all()->first();
            $warning->status_dispatch = $status_dispatch;
            $warning->save();

            return redirect()->route('admin');

        }else{

            $warning = new Warning;
            $warning->status_dispatch = $status_dispatch;
            $warning->save();

            return redirect()->route('admin');
        }



    }
//=======================[warning]===========================================
    public function warning(WarningRequest $request){

        $request->validated();

       $warning = $request->input('warning');
       $status = $request->input('status');
       $clean = $request->input('clean');
       $notification = $request->input('notification');

        //Verifica se o usuário esta logado
        if(!session()->has('user')){
            return redirect()->route('login');
        }
        if(!session('profile') == 1){
        return redirect()->route('index');
        }

        if($clean == 1){
            $dispatchs = Dispatch::where('status','<=',1)->get();
            foreach($dispatchs as $dispatch){
                $dispatch->delete();
            }
        }

        $warning_cmt = Warning::all()->first();
        if($notification == 1){
            $info = [
                'warning' => $warning,
                'status' => $status,
                'clean' => $clean,
            ];
            $this->Email->warnings($info);
        }
        if(isset($warning_cmt)){
            $warning_cmt->status_dispatch = $status;
            $warning_cmt->warning =  $warning;
            $warning_cmt->save();


        }else{

            $warning_cmt = new Warning;
            $warning_cmt->status_dispatch = $status;
            $warning_cmt->warning =  $warning;
            $warning_cmt->save();

        }
        return redirect()->route('admin');
    }
}
