<?php

namespace Tests\Feature\AQR;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tiket;
use App\Models\MasterSiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;

class HomeAQRControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    #[Test]
    public function dapat_membuat_tiket_masyarakat_umum()
    {
        $data = [
            'pengirim' => 'Masyarakat Umum',
            'nama' => 'John Doe',
            'no_hp' => '081234567890',
            'email' => 'john@example.com',
            'judul_kendala' => 'Pertanyaan Umum',
            'detail_kendala' => 'Detail kendala masyarakat umum'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'pengirim' => 'Masyarakat Umum',
            'nama' => 'John Doe',
            'lokasi_kendala' => null,
            'status' => 'New'
        ]);
    }

    #[Test]
    public function dapat_membuat_tiket_warga_sekolah_kb_pamulang()
    {
        $siswa = MasterSiswa::inRandomOrder()->first();
        User::factory()->create(['unit' => 'Pamulang', 'jabatan' => 'Staf Admin TU SMA']);

        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'nama' => 'Jane Doe',
            'no_hp' => '081234567890',
            'email' => 'jane@example.com',
            'judul_kendala' => 'Kendala KB',
            'lokasi_kendala' => 'KB Avicenna Pamulang',
            'detail_kendala' => 'Detail kendala KB Pamulang'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'lokasi_kendala' => 'KB Avicenna Pamulang',
            'status' => 'New'
        ]);
    }

    #[Test]
    public function dapat_membuat_tiket_warga_sekolah_tk_pamulang()
    {
        $siswa = MasterSiswa::inRandomOrder()->first();
        User::factory()->create(['unit' => 'Pamulang', 'jabatan' => 'Staf Admin TU SMA']);

        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'nama' => 'Student TK',
            'no_hp' => '081234567891',
            'email' => 'tk@example.com',
            'judul_kendala' => 'Kendala TK',
            'lokasi_kendala' => 'TK Avicenna Pamulang',
            'detail_kendala' => 'Detail kendala TK Pamulang'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'lokasi_kendala' => 'TK Avicenna Pamulang'
        ]);
    }

    #[Test]
    public function dapat_membuat_tiket_warga_sekolah_tk_jagakarsa()
    {
        $siswa = MasterSiswa::inRandomOrder()->first();
        User::factory()->create(['unit' => 'Jagakarsa', 'jabatan' => 'Staf Admin TU SMA']);

        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'nama' => 'Student TK Jagakarsa',
            'no_hp' => '081234567892',
            'email' => 'tkjkt@example.com',
            'judul_kendala' => 'Kendala TK Jagakarsa',
            'lokasi_kendala' => 'TK Avicenna Jagakarsa',
            'detail_kendala' => 'Detail kendala TK Jagakarsa'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'lokasi_kendala' => 'TK Avicenna Jagakarsa'
        ]);
    }

    #[Test]
    public function dapat_membuat_tiket_warga_sekolah_sd_jagakarsa()
    {
        $siswa = MasterSiswa::inRandomOrder()->first();
        User::factory()->create(['unit' => 'Jagakarsa', 'jabatan' => 'Staf Admin TU SMA']);

        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'nama' => 'Student SD Jagakarsa',
            'no_hp' => '081234567893',
            'email' => 'sdjkt@example.com',
            'judul_kendala' => 'Kendala SD Jagakarsa',
            'lokasi_kendala' => 'SD Avicenna Jagakarsa',
            'detail_kendala' => 'Detail kendala SD Jagakarsa'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'lokasi_kendala' => 'SD Avicenna Jagakarsa'
        ]);
    }

    #[Test]
    public function dapat_membuat_tiket_warga_sekolah_smp_jagakarsa()
    {
        $siswa = MasterSiswa::inRandomOrder()->first();
        User::factory()->create(['unit' => 'Jagakarsa', 'jabatan' => 'Staf Admin TU SMA']);

        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'nama' => 'Student SMP Jagakarsa',
            'no_hp' => '081234567894',
            'email' => 'smpjkt@example.com',
            'judul_kendala' => 'Kendala SMP Jagakarsa',
            'lokasi_kendala' => 'SMP Avicenna Jagakarsa',
            'detail_kendala' => 'Detail kendala SMP Jagakarsa'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'lokasi_kendala' => 'SMP Avicenna Jagakarsa'
        ]);
    }

    #[Test]
    public function dapat_membuat_tiket_warga_sekolah_sma_jagakarsa()
    {
        $siswa = MasterSiswa::inRandomOrder()->first();
        User::factory()->create(['unit' => 'Jagakarsa', 'jabatan' => 'Staf Admin TU SMA']);

        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'nama' => 'Student SMA Jagakarsa',
            'no_hp' => '081234567895',
            'email' => 'smajkt@example.com',
            'judul_kendala' => 'Kendala SMA Jagakarsa',
            'lokasi_kendala' => 'SMA Avicenna Jagakarsa',
            'detail_kendala' => 'Detail kendala SMA Jagakarsa'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'lokasi_kendala' => 'SMA Avicenna Jagakarsa'
        ]);
    }

    #[Test]
    public function dapat_membuat_tiket_warga_sekolah_sd_cinere()
    {
        $siswa = MasterSiswa::inRandomOrder()->first();
        User::factory()->create(['unit' => 'Cinere', 'jabatan' => 'Staf Admin TU SMA']);

        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'nama' => 'Student SD Cinere',
            'no_hp' => '081234567896',
            'email' => 'sdcnr@example.com',
            'judul_kendala' => 'Kendala SD Cinere',
            'lokasi_kendala' => 'SD Avicenna Cinere',
            'detail_kendala' => 'Detail kendala SD Cinere'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'lokasi_kendala' => 'SD Avicenna Cinere'
        ]);
    }

    #[Test]
    public function dapat_membuat_tiket_warga_sekolah_smp_cinere()
    {
        $siswa = MasterSiswa::inRandomOrder()->first();
        User::factory()->create(['unit' => 'Cinere', 'jabatan' => 'Staf Admin TU SMA']);

        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'nama' => 'Student SMP Cinere',
            'no_hp' => '081234567897',
            'email' => 'smpcnr@example.com',
            'judul_kendala' => 'Kendala SMP Cinere',
            'lokasi_kendala' => 'SMP Avicenna Cinere',
            'detail_kendala' => 'Detail kendala SMP Cinere'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'lokasi_kendala' => 'SMP Avicenna Cinere'
        ]);
    }

    #[Test]
    public function dapat_membuat_tiket_warga_sekolah_sma_cinere()
    {
        $siswa = MasterSiswa::inRandomOrder()->first();
        User::factory()->create(['unit' => 'Cinere', 'jabatan' => 'Staf Admin TU SMA']);

        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => $siswa->nisn,
            'nama' => 'Student SMA Cinere',
            'no_hp' => '081234567898',
            'email' => 'smacnr@example.com',
            'judul_kendala' => 'Kendala SMA Cinere',
            'lokasi_kendala' => 'SMA Avicenna Cinere',
            'detail_kendala' => 'Detail kendala SMA Cinere'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $this->assertDatabaseHas('tikets', [
            'lokasi_kendala' => 'SMA Avicenna Cinere'
        ]);
    }

    #[Test]
    public function gagal_membuat_tiket_warga_sekolah_nisn_tidak_ditemukan()
    {
        $data = [
            'pengirim' => 'Warga Sekolah',
            'nisn' => '9999999999',
            'nama' => 'Student Invalid',
            'no_hp' => '081234567899',
            'email' => 'invalid@example.com',
            'judul_kendala' => 'Kendala Invalid',
            'lokasi_kendala' => 'SD Avicenna Cinere',
            'detail_kendala' => 'Detail kendala invalid'
        ];

        $response = $this->post(route('helpdesk.home.store-tiket'), $data);

        $response->assertSessionHasErrors(['nisn']);
        $this->assertDatabaseMissing('tikets', [
            'nisn' => '9999999999'
        ]);
    }
}