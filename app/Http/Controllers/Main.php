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
    public function index()
    {
        //Verifica se o usuário esta logado
        if (session()->has('Despacho')) {
            if (session('Despacho')['profileType'] == 1) {
                return redirect()->route('admin');
            } elseif (session('Despacho')['profileType'] == 0) {
                $warning = Warning::all()->first();
                session()->flash('warning', $warning->warning);
                return redirect()->route('panel');
            }
        } else {
            return redirect('http://sistao.3bsup.eb.mil.br');
        }
    }
//=========================================================================
    public function logout()
    {
        if (session('profile') == 0) {
            $req = Request::where('user_id', session('user_id'))->where('status', 1)->where('created_at', '<', date('Y-m-d'))->get();
            foreach ($req as $req) {
                $req->delete();
            }
        }
        session()->forget('Despacho');

        return redirect('http://sistao.3bsup.eb.mil.br');
    }
}
