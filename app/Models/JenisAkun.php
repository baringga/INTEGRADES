<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisAkun extends Model
{
    use HasFactory;

    protected $table = 'jenis_akun'; // Pastikan nama tabel benar

    public $timestamps = false; // Nonaktifkan jika tabel tidak memiliki created_at dan updated_at

    protected $fillable = [
        'jenisAkun',
    ];
}
