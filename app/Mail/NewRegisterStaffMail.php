<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRegisterStaffMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $userName;

    public $password;

    public $email;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $userName, $password, $email)
    {
        $this->subject = $subject;
        $this->userName = $userName;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('common.mail.new_staff_register_mail',
            ['user_name' => $this->userName,'password' => $this->password ,'email' => $this->email]);
    }
}
