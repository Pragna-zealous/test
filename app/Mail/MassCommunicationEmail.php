<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MassCommunicationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $description;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->user->file_name){
            return $this->view('emails.payment_success')->attach(public_path().'/uploads/PDF/' .$this->user->file_name);
        }else{  
            return $this->view('emails.payment_success');
        }
    }
}
