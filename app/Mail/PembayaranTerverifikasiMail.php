<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PembayaranTerverifikasiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nama;
    public $riwayatUrl;

    public function __construct($nama, $riwayatUrl)
    {
        $this->nama = $nama;
        $this->riwayatUrl = $riwayatUrl;
    }

    public function build()
    {
        return $this->subject('Pembayaran SPMB Anda Sudah Diverifikasi 🎉')
            ->view('emails.pembayaran_terverifikasi');
    }
}
