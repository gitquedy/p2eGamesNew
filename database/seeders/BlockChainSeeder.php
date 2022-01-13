<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlockChain;

class BlockChainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlockChain::create([
            'name' => 'Etheruem',
            'short_name' => 'ETH',
            'icon' => 'eth.png'
        ]);

        BlockChain::create([
            'name' => 'Binance Smart Chain',
            'short_name' => 'BSC',
            'icon' => 'bsc.png'
        ]);

        BlockChain::create([
            'name' => 'Polygon Network',
            'short_name' => 'MATIC',
            'icon' => 'matic.png'
        ]);

        BlockChain::create([
            'name' => 'Ronin Network',
            'short_name' => 'RON',
            'icon' => 'ron.png'
        ]);
    }
}
