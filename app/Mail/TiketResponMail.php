<?php

namespace App\Mail;

use App\Models\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TiketResponMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Tiket $tiket, public string $penanganan) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: '[Update] Tiket Anda Mendapat Respon - ' . $this->tiket->no_tiket);
    }

    public function content(): Content
    {
        return new Content(view: 'mail.tiket-respon');
    }
}
