<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WarningMail extends Mailable
{

    use Queueable, SerializesModels;

    public $info;

    public function __construct($values)
    {
        $this->info = $values;
    }

    public function build()
    {
        return $this->subject('Aviso do comandante')
                    ->view('mail.warning');
    }
}
