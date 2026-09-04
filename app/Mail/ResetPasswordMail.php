<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $email;

    public function __construct($otp, $email)
    {
        $this->otp = $otp;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Đặt lại mật khẩu - BADMINTON PRO SHOP')
                    ->view('emails.reset-password')
                    ->with([
                        'otp' => $this->otp,
                        'email' => $this->email,
                    ]);
    }
}
