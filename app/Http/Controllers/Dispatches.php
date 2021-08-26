<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReqDispatchRequest;
use App\Models\Dispatch;
use App\Models\Warning;
use App\Classes\Email;
use App\Http\Requests\ReqDispatchCmtRequest;
use App\Models\LoginApplicationModel;
use App\Models\Request;
use App\Models\User;

class Dispatches extends Controller
{
    //=======================[Email]===================
    private $Email;
    public function __construct()
    {
        $this->Email = new Email();
    }

    //=============================[admin]======================================
    public function admin()
    {

        $dispatch = Dispatch::where('status', '<=', 1)->with('user')->orderBy('created_at', 'asc')->get();
        $status = Warning::all()->first();
        $users = LoginApplicationModel::with('user')->where('applications_id', 1)->get();


        $dados = [
            'erro' => session('erro'),
            'status'   => $status,
            'dispatch' => $dispatch,
            'title'    => 'Despacho - Administrador',
            'users' => $users,
        ];

        $i = 0;
        foreach ($dispatch as $dispatch) {
            $i = $i;
            $i++;
            if ($dispatch->notification == 0 && $dispatch->status == 0) {
                session()->put('queue', 1);
            }
            if ($i <= 2 && !empty($dispatch->user->email) && $dispatch->notification == 1 && $dispatch->status == 0 &&  session('queue') != 1) {
                $dispatch->notification = 2;
                $dispatch->save();
                $this->Email->queue_dispatch($dispatch);
            }
            if (!empty($dispatch->user->email) && $dispatch->status == 1 && $dispatch->notification >= 1 && $dispatch->notification < 3) {
                $dispatch->notification = 3;
                $dispatch->save();
                $this->Email->queue_dispatch($dispatch);
                session()->put('queue', 0);
            }
        }
        return view('admin', $dados);
    }



    //=============================[panel_user]=================================
    public function panel()
    {

        $status = Warning::all()->first();
        $user_id = session('user')['id'];
        $dispatch = Dispatch::where('user_id', $user_id)->where('status', '<=', 1)->get();
        $fila = 0;
        if (isset($dispatch[0])) {
            $fila = Dispatch::where('id', '<=', $dispatch[0]->id)->where('status', 0)->count();
        }

        $req_dispatch = Request::where('user_id', session('user')['id'])->orderBy('created_at', 'desc')->first();

        if (isset($req_dispatch->status) && $req_dispatch->status == 0) {
            $altsts_req = Request::where('user_id', session('user')['id'])->where('status', 0)->first();
            $altsts_req->status = 1;
            $altsts_req->save();
        }

        $dados = [
            'warning' => session('warning'),
            'status' => $status,
            'dispatch' => $dispatch,
            'fila' => $fila,
            'req' => $req_dispatch,
            'erro' => session('erro'),
            'title'    => 'Despacho - Home',
        ];


        return view('user_panel', $dados);
    }
    //=============================[action_dispatch]============================
    public function action_dispatch($id_dispatch, $action)
    {
        if ($action == 1) {
            $check_status = Dispatch::where('status', 1)->first();

            if ($check_status) {
                session()->flash('erro', 'Não pode haver dois militares despachando finalize o despacho antes de chamar o proximo.');
                return redirect()->route('admin');
            }
        }

        $dispatch = Dispatch::find($id_dispatch);

        if ($action == 1 || $action == 2) {
            session()->forget('queue');
            $dispatch->status = $action;
            $dispatch->save();
        } elseif ($action == 3) {
            $dispatch->delete();
            if ($dispatch->status == 0) {
                session()->forget('queue');
            }
        } elseif ($action == 4) {
            $dispatch->delete();
        } elseif ($action == 6) {
            $restore = Dispatch::withTrashed()->find($id_dispatch);
            $restore->deleted_at = null;
            $restore->save();
        }

        return back();
    }
    //=============================[Historico]==================================
    public function history_dispatch()
    {
        $dispatch = Dispatch::where('status', 2)->with('user')->orderBy('updated_at', 'desc')->get();
        //$dispatch = Dispatch::withTrashed()->with('user')->orderBy('updated_at','desc')->get();
        $status = Warning::all()->first();
        $dados = [
            'status' => $status,
            'dispatch' => $dispatch,
            'title'    => 'Despacho - Histórico',
        ];

        return view('history', $dados);
    }
    //=============================[trash_dispatch]=============================
    public function trash_dispatch()
    {
        $dispatch = Dispatch::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $status = Warning::all()->first();
        $dados = [
            'status' => $status,
            'dispatch' => $dispatch,
            'title'    => 'Despacho - Lixeira',
        ];

        return view('trash', $dados);
    }
    //=============================[clean_trash]================================
    public function clean_trash()
    {
        $trash = Dispatch::onlyTrashed()->get();

        foreach ($trash as $dispatch) {

            $dispatch->forceDelete();
        }

        return back();
    }

    //=============================[require_dispatch]===========================
    public function require_dispatch(ReqDispatchCmtRequest $request)
    {
        $request->validated();
        $user    = $request->input('user');
        $message = $request->input('message');
        $email   = $request->input('email');
        if (empty($email)) {
            $email = 0;
        }

        $check_req = Request::where('user_id', $user)->where('status', 0)->first();
        if ($check_req) {
            session()->flash('erro', 'Este usuário tem uma solicitação não visualizada.');
            return back();
        }


        $require = new Request;
        $require->user_id = $user;
        $require->message = $message;
        $require->status = 0;
        $require->save();

        if ($email == 1) {
            $info = [
                'message' => $message,
                'user' => $user,
            ];
            $this->Email->cmt_message($info);
        }
        session()->flash('erro', 'Requerimento enviado com sucesso.');

        return back();
    }
    //=============================[request_dispatch]===========================
    public function request_dispatch(ReqDispatchRequest $request)
    {
        $check_sts_cmt = Warning::all()->first();
        if ($check_sts_cmt->status_dispatch == 1) {
            session()->flash('erro', 'O comandante não está recebendo despacho no momento.');
            return redirect()->route('panel');
        }
        $request->validated();
        $descripition = $request->input('descripition');
        $notification = $request->input('notification');
        if (empty($notification)) {
            $notification = 0;
        }

        $dispatch = new Dispatch;
        $dispatch->user_id = session('user')['id'];
        $dispatch->descripition = $descripition;
        $dispatch->notification = $notification;
        $dispatch->status = 0;
        $dispatch->save();

        return redirect()->route('panel');
    }
    //=============================[cancel_dispatch]============================
    public function cancel_dispatch()
    {
        $user_id = session('user')['id'];

        $dispatch = Dispatch::where('user_id', $user_id)->where('status', '<=', 1)->get();

        if (isset($dispatch[0])) {
            $dispatch[0]->delete();
        }


        return redirect()->route('panel');
    }
    //=============================[user_history]=============================
    public function user_history()
    {
        $user_id = session('user')['id'];
        $dispatch = Dispatch::where('status', 2)->where('user_id', $user_id)->with('user')->orderBy('updated_at', 'desc')->get();

        $req_dispatch = Request::where('user_id', session('user')['id'])->orderBy('created_at', 'desc')->first();
        if (isset($req_dispatch->status) && $req_dispatch->status == 0) {
            $altsts_req = Request::where('user_id', session('user')['id'])->where('status', 0)->first();
            $altsts_req->status = 1;
            $altsts_req->save();
        }

        $dados = [
            'req' => $req_dispatch,
            'dispatch' => $dispatch,
            'title'    => 'Despacho - Histórico',

        ];

        return view('user_history', $dados);
    }
}
