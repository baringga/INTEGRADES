<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederCampaignDitandai extends Seeder
{
    public function run(): void
    {
        DB::table('campaign_ditandai')->insert([
            [
                'akun_id' => 2,
                'campaign_id' => 1,
            ],
            [
                'akun_id' => 2,
                'campaign_id' => 3,
            ],
        ]);
    }
}
