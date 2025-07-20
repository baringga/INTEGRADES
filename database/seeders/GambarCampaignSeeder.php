<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GambarCampaign;

class GambarCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GambarCampaign::insert([
            [
                'campaign_id' => 1,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1663089500161-42a457d95a89?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,
            ],
            [
                'campaign_id' => 2,
                'gambar' => 'https://images.unsplash.com/photo-1610093366806-b2907e880fb7?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,
            ],
            [
                'campaign_id' => 3,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1681064887697-627cb9d93827?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,
            ],
            [
                'campaign_id' => 4,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1679689588222-ced8253344fd?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,


            ],
            [
                'campaign_id' => 5,
                'gambar' => 'https://images.unsplash.com/photo-1661405001746-264a95ad6fea?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,
            ],
            [
                'campaign_id' => 6,
                'gambar' => 'https://images.unsplash.com/photo-1625314563148-572c6af9e9d5?q=80&w=2046&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,
            ],
            [
                'campaign_id' => 7,
                'gambar' => 'https://images.unsplash.com/photo-1643213379811-17f8c9ec7b66?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,
            ],
            [
                'campaign_id' => 8,
                'gambar' => 'https://images.unsplash.com/photo-1650234856233-63058d00ba52?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,
            ],
            [
                'campaign_id' => 9,
                'gambar' => 'https://images.unsplash.com/photo-1607536143324-9ea8ceaecdbf?q=80&w=1965&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,
            ],
            [
                'campaign_id' => 10,
                'gambar' => 'https://images.unsplash.com/photo-1587585113851-269ef0e07d9c?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => true,
            ],
            // Tambahan gambar untuk campaign id 1-10
            [
                'campaign_id' => 1,
                'gambar' => 'https://images.unsplash.com/flagged/photo-1574380555089-06f915e8c074?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
            [
                'campaign_id' => 2,
                'gambar' => 'https://images.unsplash.com/photo-1631039083528-c05cdf3329a6?q=80&w=1032&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
            [
                'campaign_id' => 3,
                'gambar' => 'https://images.unsplash.com/photo-1543346919-fe6aa4a539d8?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
            [
                'campaign_id' => 4,
                'gambar' => 'https://images.unsplash.com/photo-1744343932892-d08c6df3f7b5?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
            [
                'campaign_id' => 5,
                'gambar' => 'https://images.unsplash.com/photo-1672839792786-88b2dddd57d9?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
            [
                'campaign_id' => 6,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1679689588513-fc60037a27ab?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
            [
                'campaign_id' => 7,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1681064887739-0fdf15ef86d4?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
            [
                'campaign_id' => 8,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1679731618408-a843851f6b05?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
            [
                'campaign_id' => 9,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1679689587217-248ba24f582f?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
            [
                'campaign_id' => 10,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1679689587770-8d588aa84b7e?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,

                'campaign_id' => 1,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1679689587770-8d588aa84b7e?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,

                'campaign_id' => 3,
                'gambar' => 'https://plus.unsplash.com/premium_photo-1681152783638-5857e676a916?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'isCover' => false,
            ],
        ]);
    }
}
