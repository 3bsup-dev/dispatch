<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InfoLoginMail extends Mailable
{

    use Queueable, SerializesModels;

    public $info;

    public function __construct($values)
    {
        $this->info = $values;
    }

    public function build()
    {
        return $this->subject('Informações de login')
                    ->view('mail.info_login');
    }
}
