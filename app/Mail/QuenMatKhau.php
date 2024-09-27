<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuenMatKhau extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $noi_dung;
    public function __construct($token)
    {
        $this->noi_dung = "Vui lòng truy cập link này để thay đổi mật khẩu: " . url('/reset-password') . '/'. $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Yêu cầu lấy lại mật khẩu")->html($this->noi_dung);
    }
}
