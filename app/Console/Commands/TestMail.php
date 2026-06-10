<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    protected $signature = 'mail:test {email}';
    protected $description = 'Test kirim email via SMTP';

    public function handle()
    {
        $to = $this->argument('email');

        try {
            Mail::raw('Test email dari Laravel - SMTP Mailtrap berhasil!', function ($message) use ($to) {
                $message->to($to)->subject('Test SMTP Mailtrap');
            });
            $this->info("Email berhasil dikirim ke: $to");
        } catch (\Exception $e) {
            $this->error("Gagal: " . $e->getMessage());
        }
    }
}
