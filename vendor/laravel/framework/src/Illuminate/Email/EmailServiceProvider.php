<?php

namespace App\Providers;
use App\Classes\Email;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{
    public function register()
    {
      $this->app->bind('email', function(){
            return new Email;
      });
    }

    public function boot()
    {

    }
}
