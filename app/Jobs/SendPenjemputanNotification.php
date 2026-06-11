<?php

namespace App\Jobs;

use App\Models\MasterSiswa;
use App\Events\TestNotification;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPenjemputanNotification implements ShouldQueue
{
    use Queueable;

    public $siswa;

    public function __construct(MasterSiswa $siswa)
    {
        $this->siswa = $siswa;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new TestNotification([
            'notifikasi' => 'Penjemput atas nama ' . $this->siswa->nama . ' Sudah Datang',
            'kelas' => $this->siswa->kelas
        ]));
    }
}
