<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coin;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::create([
            'name' => 'Binance Coin',
            'short_name' => 'BNB',
            'coingecko_id' => 'binancecoin',
            'minimum_price' => '19748.48',
            'markup_price' => '5',
            'icon' => 'bnb.png',
            'isActive' => true,
            'step' => 0.1,
            'default' => 0.1
        ]);

        Coin::create([
            'name' => 'Etheruem',
            'short_name' => 'ETH',
            'coingecko_id' => 'ethereum',
            'minimum_price' => '122663',
            'markup_price' => '5',
            'icon' => 'eth.png',
            'isActive' => true,
            'step' => 0.01,
            'default' => 0.1
        ]);

        Coin::create([
            'name' => 'Polygon',
            'short_name' => 'MATIC',
            'coingecko_id' => 'matic-network',
            'minimum_price' => '82.93',
            'markup_price' => '5',
            'icon' => 'matic.png',
            'isActive' => true,
            'step' => 1,
            'default' => 1
        ]);
    }
}
