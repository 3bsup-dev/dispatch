<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReqDispatchCmtRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user' => ['required'],
            'message'      => ['required','max:250'],
        ];
    }

    //====================================================
    public function messages(){
        return[
            'user'                      => 'É necessário selecionar um usuário',
            'message.required'      => 'O campo mensagem está em branco',
            'message.max'           => 'Deve haver no maximo 250 caracteres'
        ];
    }
}
