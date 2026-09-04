<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $resetUrl = url('/password-reset/' . $this->token . '?email=' . urlencode($this->email));

        return $this->subject('Đặt lại mật khẩu - BADMINTON PRO SHOP')
                    ->view('emails.reset-password')
                    ->with([
                        'resetUrl' => $resetUrl,
                        'email' => $this->email,
                    ]);
    }
}
