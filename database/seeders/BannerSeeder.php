<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::create([
            'name' => 'TCG',
            'isActive' => true,
            'full' => 'tcg90.gif',
            'mobile' => 'tcg_mobile.gif',
            'tablet' => 'tcg_tablet.gif',
            'link' => 'https://tcg.world/',
        ]);

        Banner::create([
            'name' => 'Samurai Doge',
            'isActive' => true,
            'full' => 'samuraidoge290.gif',
            'mobile' => 'samuraidoge2_mobile.gif',
            'tablet' => 'samuraidoge2tablet.gif',
            'link' => 'https://samuraidoge.net/?utm_source=playtoearn&utm_medium=banner&utm_campaign=Ads',
        ]);

        Banner::create([
            'name' => 'Crusaders of Crypto',
            'isActive' => true,
            'full' => 'coc590.gif',
            'mobile' => 'coc5_mobile.gif',
            'tablet' => 'coc5_tablet.gif',
            'link' => 'https://site.crusadersofcrypto.com/',
        ]);

         Banner::create([
            'name' => 'Crusaders of Crypto',
            'isActive' => true,
            'full' => 'p2e.jpg',
            'link' => 'https://playtoearn.net/',
            'delegation' => '2'
        ]);





    }
}
