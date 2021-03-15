<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AltPwdRequest extends FormRequest
{

//====================================================
public function rules()
{
    return [
        'old_pwd'      => ['required','min:6'],
        'new_pwd'      => ['required','min:6'],
        'rep_new_pwd'  => ['required'],
    ];
}

//====================================================
public function messages(){
    return[
        'old_pwd.required'          => 'Digite sua senha antiga.',
        'new_pwd.required'          => 'Digite a nova senha.',
        'rep_new_pwd.required'      => 'Confirme a nova senha.',
        'old_pwd.min'          => 'Senha antiga incorreta.',
        'new_pwd.min'          => 'A senha deve conter no mínimo :min caracteres',
    ];
}
}
