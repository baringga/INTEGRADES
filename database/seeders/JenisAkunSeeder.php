<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menghapus data lama untuk memastikan kebersihan data
        DB::table('jenis_akun')->delete();

        // Menambahkan peran baru
        DB::table('jenis_akun')->insert([
            ['id' => 1, 'jenisAkun' => 'Volunteer Desa'],
            ['id' => 2, 'jenisAkun' => 'Masyarakat Desa'],
        ]);
    }
}
