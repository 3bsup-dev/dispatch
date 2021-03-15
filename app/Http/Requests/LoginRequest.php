<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

//====================================================
public function rules()
{
    return [
        'login' => ['required','min:6','max:50'],//Defininfo em forma de array que login e 'required'=> Obrigatorio , 'email'=> é um email e max:30 => que sao no maximo 30 caracteres, pode se aplicar tambem o REGEX que
        'password' => ['required','min:6'],
    ];
}

//====================================================
public function messages(){
    return[

        'login.required' => 'Por favor, digite seu usuário!',//define a mensagem de erro
        'login.min' => 'São no minimo :min caracteres!',
        'login.max' => 'São no maximo 50 caracteres!', // Teraro que ser definida uma msg de erro para cada funcao
        'password.required' => 'Por favor, digite a senha!',//define a mensagem de erro
        'password.min' => 'A senha deve conter no minimo :min caracteres!',

    ];
}
//====================================================

}
