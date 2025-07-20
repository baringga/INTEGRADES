<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeederKomentarDisukai extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();


        DB::table('komentar_disukai')->insert([
            [
                'komentar_id' => 1,
                'akun_id' => 2,
            ],
            [
                'komentar_id' => 3,
                'akun_id' => 2,
            ],
            [
                'komentar_id' => 4,
                'akun_id' => 2,
            ],
            [
                'komentar_id' => 6,
                'akun_id' => 2,
            ],
        ]);
    }
}
