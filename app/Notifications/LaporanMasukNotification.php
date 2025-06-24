<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LaporanMasukNotification extends Notification
{
    public $laporan;

    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    public function via($notifiable)
    {
        return ['mail']; // Bisa tambahin 'database', 'slack', 'broadcast', dll
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Laporan Baru Masuk')
            ->line('Ada laporan baru masuk dari ' . $this->laporan['nama'])
            ->line('Masalah: ' . $this->laporan['masalah'])
            ->line('Deskripsi: ' . $this->laporan['deskripsi'])
            ->line('Kontak: ' . $this->laporan['kontak']);
    }
}
