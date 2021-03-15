<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReqDispatchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'descripition'      => ['required'],
        ];
    }

    //====================================================
    public function messages(){
        return[
            'descripition.required'      => 'O campo assunto está em branco'
        ];
    }
}
