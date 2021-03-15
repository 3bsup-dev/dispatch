<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    // $pg = $request->input('pg');
    // $name = $request->input('name');
    // $section = $request->input('section');
    // $email = $request->input('email');
    // $profile = $request->input('profile');
//====================================================
public function rules()
{
    return [
        'pg'      => ['required'],
        'name'    => ['required','max:50'],
        'login'   => ['required'],
        'section' => ['required'],
        'profile' => ['required']
    ];
}

//====================================================
public function messages(){
    return[
        'pq.required'      => 'O campo Post\Grad está em branco',
        'name.required'    => 'Digite o nome',
        'name.max'         => 'O nome pde ter no maximo :max caracteres',
        'login.required'   => 'Por favor, insira o login.',
        'section.required' => 'Por favor, escolha uma seção.',
        'profile.required' => 'Por favor, selecione o perfil do usuario!',//define a mensagem de erro

    ];
}
}
