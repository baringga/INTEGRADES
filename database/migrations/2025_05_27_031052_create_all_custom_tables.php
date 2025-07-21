<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_akun', function (Blueprint $table) {
            $table->id();
            $table->string('jenisAkun', 100);
        });

        Schema::create('akun', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100);
            $table->string('password', 100);
            $table->string('namaPengguna', 100);
            $table->text('fotoProfil')->nullable();
            $table->string('nomorTelepon', 100)->nullable();
            $table->foreignId('jenis_akun_id')->constrained('jenis_akun');
            $table->timestamps();
        });

        // Tabel ini sekarang akan kita sebut sebagai "profil_volunteer" dalam logika kita
        Schema::create('akun_komunitas', function (Blueprint $table) {
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->text('portofolio')->nullable(); // Dibuat boleh kosong (nullable)
        });

        Schema::create('campaign', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')
                ->nullable()
                ->constrained('akun')
                ->nullOnDelete();
            $table->string('nama', 100)->nullable();
            $table->dateTime('waktu')->nullable();
            $table->dateTime('waktu_diperbarui')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('lokasi')->nullable();
            $table->string('kontak', 100)->nullable();
            $table->integer('kuota_partisipan')->nullable();
        });

        Schema::create('campaign_ditandai', function (Blueprint $table) {
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained('campaign')->onDelete('cascade');
        });

        Schema::create('gambar_campaign', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaign')->onDelete('cascade');
            $table->text('gambar');
            $table->boolean('isCover')->default(false);
        });

        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained('campaign')->onDelete('cascade');
            $table->string('komentar', 280);
            $table->datetime('waktu');
            $table->datetime('updated_at')->nullable();
        });

        Schema::create('komentar_disukai', function (Blueprint $table) {
            $table->foreignId('komentar_id')->constrained('komentar')->onDelete('cascade');
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->unique(['komentar_id', 'akun_id']);
        });

        Schema::create('partisipan_campaign', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->foreignId('campaign_id')->constrained('campaign')->onDelete('cascade');
            $table->string('nama', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nomorTelepon', 100)->nullable();
            $table->text('motivasi')->nullable();
            // KOLOM BARU UNTUK PERSETUJUAN
            $table->string('status', 20)->default('pending'); // pending, approved, rejected
        });

        // TABEL BARU UNTUK PENGADUAN
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun')->onDelete('cascade');
            $table->string('judul', 255);
            $table->text('isi_pengaduan');
            $table->string('lokasi', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('status', 20)->default('dilaporkan'); // dilaporkan, diproses, selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Urutan drop disesuaikan untuk keamanan relasi
        Schema::dropIfExists('komentar_disukai');
        Schema::dropIfExists('komentar');
        Schema::dropIfExists('gambar_campaign');
        Schema::dropIfExists('campaign_ditandai');
        Schema::dropIfExists('partisipan_campaign');
        Schema::dropIfExists('pengaduan');
        Schema::dropIfExists('campaign');
        Schema::dropIfExists('akun_komunitas');
        Schema::dropIfExists('akun');
        Schema::dropIfExists('jenis_akun');
    }
};
