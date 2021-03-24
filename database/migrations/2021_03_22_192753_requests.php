<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Requests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();//Cria uma coluna id padrão com auto-increment e  bigint caso não seja especificado nada dentro de ()
            $table->integer('user_id');//ID do usuario a ser vinculado
            $table->string('message', 255);//Texto da mensagem
            $table->tinyInteger('status');//Status da mensagem
            $table->timestamps();//Cria 2 colunas, created_at e updated_at
            $table->softDeletes();//Cria a coluna deleted_at

        });
    }

    public function down()
    {
       Schema::dropIfExists('requests');
    }
}
