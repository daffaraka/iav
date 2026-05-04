<?php

namespace App\Notifications;

use App\Models\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TiketNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Tiket $tiket,
        public string $pesan,
        public string $tipe // 'new', 'disposisi', 'respon'
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'tiket_id'  => $this->tiket->id,
            'no_tiket'  => $this->tiket->no_tiket,
            'judul'     => $this->tiket->judul_kendala,
            'pesan'     => $this->pesan,
            'tipe'      => $this->tipe,
            'url'       => url('/dashboard/aqr/tiket/' . $this->tiket->id . '/edit'),
        ];
    }
}
