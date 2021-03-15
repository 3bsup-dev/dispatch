<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Dispatches extends Migration
{

    public function up()
    {
        Schema::create('dispatch', function (Blueprint $table) {//Esquema para criação da tabela 'dispatches'
            $table->id();//Cria uma coluna id padrão com auto-increment e  bigint caso não seja especificado nada dentro de ()
            $table->integer('user_id');//Posto ou Graduação do usuario
            $table->string('descripition', 255);//Descrição do despacho
            $table->tinyInteger('status');//Status do despacho
            $table->timestamps();//Cria 2 colunas, created_at e updated_at
            $table->softDeletes();//Cria a coluna deleted_at
        });
    }


    public function down()
    {
        Schema::dropIfExists('dispatch');
    }
}
