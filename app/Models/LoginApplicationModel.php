<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginApplicationModel extends Model
{
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'login_id');
    }

    use HasFactory;
    protected $table = 'login_application';
    protected $primarykey = 'login_id';
      //Conexão DB a ser usada
    protected $connection = 'sistao';
}
