<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('profile');
            $table->string('pg', 4);
            $table->string('name', 50);
            $table->string('email', 80)->nullable();
            $table->string('section',50);
            $table->string('login', 50);
            $table->string('password', 200);
            $table->timestamps();
            $table->softDeletes();

        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
