<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Warning extends Migration
{

    public function up()
    {
        Schema::create('warning', function (Blueprint $table) {
            $table->id();
            $table->string('warning', 255)->nullable();
            $table->tinyInteger('status_dispatch');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('warning');
    }
}
