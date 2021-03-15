<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{


    public function user(){
        return $this->hasOne('App\Models\Dispatches');
    }


    use SoftDeletes; // Para ser usado é necessario adicionar a coluna DELETET_AT na tabela

    //Nome da tabela vinculada, caso nao seja especificado sera usado o nome da clase model para saber a tabela
    protected $table = 'users';
    //Chave primaria da tabela, caso não seja definido por default e 'ID'
    protected $primaryKey = 'id';
}
