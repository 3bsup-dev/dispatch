<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReqDispatchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description'      => ['required','max:250'],
        ];
    }

    //====================================================
    public function messages(){
        return[
            'description.required'      => 'O campo assunto está em branco',
            'description.max'           => 'Deve haver no maximo 250 caracteres'
        ];
    }
}
