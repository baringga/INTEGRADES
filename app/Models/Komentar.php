<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';
    public $timestamps = false;

    protected $fillable = [
        'akun_id',
        'campaign_id',
        'komentar',
        'waktu',
        'updated_at',
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function akun()
    {
        return $this->belongsTo(\App\Models\User::class, 'akun_id');
    }

    public function up()
    {
        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('akun_id')->constrained('akun');
            $table->foreignId('campaign_id')->constrained('campaign');
            $table->string('komentar', 280);
            $table->dateTime('waktu');
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function likes()
    {
        return $this->belongsToMany(\App\Models\User::class, 'komentar_disukai', 'komentar_id', 'akun_id');
    }
}
