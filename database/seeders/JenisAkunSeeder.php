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
        DB::table('jenis_akun')->insert([
            ['jenisAkun' => 'Volunteer Desa'],
            ['jenisAkun' => 'Masyarakat Desa'],
        ]);
    }
}
