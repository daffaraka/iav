<?php

namespace App\Mail;

use App\Models\Tiket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TiketDisposisiMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Tiket $tiket) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: '[Disposisi] Tiket Ditugaskan ke Anda - ' . $this->tiket->no_tiket);
    }

    public function content(): Content
    {
        return new Content(view: 'mail.tiket-disposisi');
    }
}
