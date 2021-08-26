<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{


    public function user()
    {
        return $this->hasOne('App\Models\Dispatches');
    }

    public function login()
    {
        return $this->hasOne('App\Models\LoginModel', 'users_id', 'id');
    }

    public function rank()
    {
        return $this->hasOne('App\Models\RanksModel', 'id', 'rank_id');
    }

    public function departament()
    {
        return $this->hasOne('App\Models\DepartamentModel', 'id', 'departament_id');
    }

    public function company()
    {
        return $this->hasOne('App\Models\CompanyModel', 'id', 'company_id');
    }

    public function city()
    {
        return $this->hasOne('App\Models\CitiesModel', 'id', 'city_id');
    }


    use SoftDeletes; // Para ser usado é necessario adicionar a coluna DELETET_AT na tabela

    //Nome da tabela vinculada, caso nao seja especificado sera usado o nome da clase model para saber a tabela
    protected $table = 'users';
    //Chave primaria da tabela, caso não seja definido por default e 'ID'
    protected $primaryKey = 'id';
    //Conexão DB a ser usada
    protected $connection = 'sistao';
}
