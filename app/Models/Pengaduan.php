<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'akun_id',
        'judul',
        'isi_pengaduan',
        'lokasi',
        'foto',
        'status',
    ];

    /**
     * Mendapatkan data akun yang membuat pengaduan.
     */
    public function akun()
    {
        return $this->belongsTo(User::class, 'akun_id');
    }
}
