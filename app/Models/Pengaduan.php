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
        'kategori_laporan',
        'kategori_laporan_custom',
        'kelebihan_desa',
        'kekurangan_desa',
        'waktu',
        'saran_aksi',
        'latitude',
        'longitude',
    ];

    /**
     * Mendapatkan data akun yang membuat pengaduan.
     */
    public function akun()
    {
        return $this->belongsTo(User::class, 'akun_id');
    }
}
