<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            JenisAkunSeeder::class,
        ]);
        $this->call([
            AkunSeeder::class,
        ]);
        $this->call([
            CampaignSeeder::class,
        ]);
        $this->call([
            GambarCampaignSeeder::class,
        ]);
        $this->call([
            SeederKomentar::class,
        ]);
        $this->call([
            SeederKomentarDisukai::class,
        ]);
        $this->call([
            SeederPartisipanCampaign::class,
        ]);
        $this->call([
            SeederCampaignDitandai::class,
        ]);
    }
}
