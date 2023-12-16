<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TraLoiYeuCau extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $tieu_de;
    private $noi_dung;
    public function __construct($tieu_de, $noi_dung){
        $this->tieu_de = $tieu_de;
        $this->noi_dung = $noi_dung;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->tieu_de)->html($this->noi_dung);
    }
}
