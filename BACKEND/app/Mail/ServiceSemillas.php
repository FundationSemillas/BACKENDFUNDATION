<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceSemillas extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "verify Mail";
    public $idUse ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idUse)
    {
        $this ->idUse = $idUse;
       // $array=array("15");
        //return $this->view('verifyMail',$array);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $variable = $this ->idUse;
        return $this->view('verifyMail')->with('variable' ,$variable);
    }
}
