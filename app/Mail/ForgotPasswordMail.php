<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $link;

    public $subject;

    public $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $subject, $userName)
    {
        $this->link = $link;
        $this->subject = $subject;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('common.mail.send_mail', ['link' => $this->link, 'user_name' => $this->userName]);
    }
}