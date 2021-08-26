<?php

namespace App\Classes;

use App\Mail\CmtReqDispatchMail;
use App\Mail\InfoLoginMail;
use App\Mail\DispatchMail;
use App\Mail\WarningMail;
use App\Models\LoginApplicationModel;
use App\Models\Warning;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class Email
{
//=============================[fila do despacho]====================================
    public function queue_dispatch($info){
        Mail::to( $info->user->email)->send(new DispatchMail($info));
    }
//=============================[Warning]=============================================
    public function warnings($info){
        $users = LoginApplicationModel::with('user')->where('notification', 1)->where('applications_id', 1)->get();

            foreach($users as $user){
                if (!empty($user->user->email)) {
                    $info['name'] = $user->user->professionalName;
                    Mail::to($user->user->email)->send(new WarningMail($info));
                }
            }
    }
//=============================[Cmt Request Dispatch]=================================
    public function cmt_message($info){
           $user = LoginApplicationModel::with('user')->where('login_id', $info['user'])->first();
            if (!empty($user->user->email && $user->notification == 1)) {
                $info['name'] = $user->user->professionalName;
                Mail::to($user->user->email)->send(new CmtReqDispatchMail($info));
            }
    }
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
//=============================[]======================================
}
