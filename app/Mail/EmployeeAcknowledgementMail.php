<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeAcknowledgementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lastuser;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lastuser)
    {
        $this->lastuser = $lastuser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->lastuser;
        return $this->view('emails.employeeinfo', compact('user'));
    }
}
