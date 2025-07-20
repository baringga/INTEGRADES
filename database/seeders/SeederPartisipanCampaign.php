<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederPartisipanCampaign extends Seeder
{
    public function run(): void
    {
        DB::table('partisipan_campaign')->insert([
            [
                'akun_id' => 2,
                'campaign_id' => 1,
                'nama' => 'Kai Wave',
                'email' => 'kai.wave@gmail.com',
                'nomorTelepon' => '08110054321',
                'motivasi' => null,
            ],
            [
                'akun_id' => 2,
                'campaign_id' => 2,
                'nama' => 'Kai Wave',
                'email' => 'kai.wave@gmail.com',
                'nomorTelepon' => '08110054321',
                'motivasi' => null,
            ],
            [
                'akun_id' => 2,
                'campaign_id' => 3,
                'nama' => 'Kai Wave',
                'email' => 'kai.wave@gmail.com',
                'nomorTelepon' => '08110054321',
                'motivasi' => null,
            ],
        ]);
    }
}
