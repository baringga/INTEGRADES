<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeederKomentar extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('komentar')->insert([
            [
                'akun_id' => 1,
                'campaign_id' => 1,
                'komentar' => 'Senang banget bisa ikut campaign kebersihan sungai!',
                'waktu' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2),
            ],
            [
                'akun_id' => 2,
                'campaign_id' => 2,
                'komentar' => 'Aksi bersih pantai sangat bermanfaat untuk lingkungan.',
                'waktu' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subDays(1),
            ],
            [
                'akun_id' => 3,
                'campaign_id' => 3,
                'komentar' => 'Semoga semakin banyak yang peduli kebersihan!',
                'waktu' => $now,
                'updated_at' => $now,
            ],
            [
                'akun_id' => 1,
                'campaign_id' => 2,
                'komentar' => 'Terima kasih sudah mengadakan event ini.',
                'waktu' => $now->copy()->subHours(5),
                'updated_at' => $now->copy()->subHours(5),
            ],
            [
                'akun_id' => 2,
                'campaign_id' => 1,
                'komentar' => 'Saya akan ajak teman-teman untuk ikut berikutnya.',
                'waktu' => $now->copy()->subHours(2),
                'updated_at' => $now->copy()->subHours(2),
            ],
            [
                'akun_id' => 3,
                'campaign_id' => 1,
                'komentar' => 'Kebersihan lingkungan adalah tanggung jawab bersama.',
                'waktu' => $now->copy()->subMinutes(30),
                'updated_at' => $now->copy()->subMinutes(30),
            ],
        ]);
    }
}
