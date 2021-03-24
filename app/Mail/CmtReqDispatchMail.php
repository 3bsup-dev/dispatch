<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CmtReqDispatchMail extends Mailable
{
    use Queueable, SerializesModels;

    public $info;

    public function __construct($values)
    {
        $this->info = $values;
    }

    public function build()
    {
        return $this->subject('Mensagem do comandante')
        ->view('mail.cmt_req_dispatch');
    }
}
