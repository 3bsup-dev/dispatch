<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarningRequest extends FormRequest
{

//====================================================
public function rules()
{
    return [
        'warning' => ['required','min:5','max:250'],//Defininfo em forma de array que login e 'required'=> Obrigatorio , 'email'=> é um email e max:30 => que sao no maximo 30 caracteres, pode se aplicar tambem o REGEX que
        'status' => ['required'],
    ];
}

//====================================================
public function messages(){
    return[

        'warning.required' => 'Por favor, digite o aviso!',//define a mensagem de erro
        'warning.min' => 'São no minimo :min caracteres!',
        'warning.max' => 'São no maximo :max caracteres!', // Teraro que ser definida uma msg de erro para cada funcao
        'status.required' => 'Por favor, selecione o status!',//define a mensagem de erro

    ];
}
//====================================================
}
