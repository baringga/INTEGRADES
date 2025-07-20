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
            $table->text('fotoProfil');
            $table->string('nomorTelepon', 100);
            $table->foreignId('jenis_akun_id')->constrained('jenis_akun');
            $table->timestamps();
        });

        Schema::create('akun_komunitas', function (Blueprint $table) {
            $table->foreignId('akun_id')->constrained('akun');
            $table->text('portofolio');
        });

        Schema::create('campaign', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')
                ->nullable() // Boleh null
                ->constrained('akun')
                ->nullOnDelete(); // Jika akun dihapus, akun_id jadi null
            $table->string('nama', 100)->nullable();
            $table->dateTime('waktu')->nullable();
            $table->dateTime('waktu_diperbarui')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('lokasi')->nullable();
            $table->string('kontak', 100)->nullable();
            $table->integer('kuota_partisipan')->nullable();
        });
        
        Schema::create('campaign_ditandai', function (Blueprint $table) {
            $table->foreignId('akun_id')->constrained('akun');
            $table->foreignId('campaign_id')->constrained('campaign');
        });

        Schema::create('gambar_campaign', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaign');
            $table->text('gambar');
            $table->boolean('isCover')->default(false);
        });

        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun');
            $table->foreignId('campaign_id')->constrained('campaign');
            $table->string('komentar', 280);
            $table->datetime('waktu');
            $table->datetime('updated_at')->nullable();
        });

        Schema::create('komentar_disukai', function (Blueprint $table) {
            $table->foreignId('komentar_id')->constrained('komentar');
            $table->foreignId('akun_id')->constrained('akun');
            $table->unique(['komentar_id', 'akun_id']);
        });

        Schema::create('partisipan_campaign', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun');
            $table->foreignId('campaign_id')->constrained('campaign');
            $table->string('nama', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nomorTelepon', 100)->nullable();
            $table->text('motivasi')->nullable();
        });

        Schema::create('session', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun');
            $table->dateTime('waktu');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session');
        Schema::dropIfExists('partisipan_campaign');
        Schema::dropIfExists('komentar_disukai');
        Schema::dropIfExists('komentar');
        Schema::dropIfExists('gambar_campaign');
        Schema::dropIfExists('campaign_ditandai');
        Schema::dropIfExists('campaign');
        Schema::dropIfExists('akun_komunitas');
        Schema::dropIfExists('akun');
        Schema::dropIfExists('jenis_akun');
    }
};
