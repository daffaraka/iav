<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_siswas', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('nisn')->unique()->nullable();
            $table->string('nis')->unique()->nullable();
            $table->string('nama_orang_tua');
            $table->string('nik')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('email')->unique();
            $table->string('tahun_ajaran')->nullable();
            $table->string('nisn')->unique()->nullable();
            $table->string('nis')->unique()->nullable();

            // Identitas Di Sekolah
            $table->string('jenjang');
            $table->string('kelas')->nullable();
            $table->string('sub_kelas')->nullable();
            $table->string('angkatan')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('status')->nullable();

            // Tambahan
            $table->string('foto')->nullable();
            $table->string('asal_sekolah')->nullable();


            $table->foreignId('sekolah_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_siswa');
    }
};
