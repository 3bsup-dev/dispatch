<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Dispatch extends Mailable
{
    use Queueable, SerializesModels;

    public $info;

    public function __construct($values)
    {
        $this->info = $values;
    }

    public function build()
    {
        return $this->subject('Fila de despacho')
        ->view('mail.dispatch');
    }
}
