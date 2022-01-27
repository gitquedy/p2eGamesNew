<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::create([
            'user_id' => 1,
            'name' => 'Axie Infinity',
            'description' => 'Axie Infinity is an NFT-based online video game developed by Vietnamese studio Sky Mavis, which uses Ethereum-based cryptocurrencies, Axie Infinity Shards and Smooth Love Potion. As of October 2021, Axie Infinity has 2 million daily active users.',
            'image' => 'image_441a86c36d75ec36858814aebb91150a72021b47.jpg',
            'short_description' => 'Battle and Collect fantasy creatures called axie',
            'status' => 'Live',
            'device' => 'Web,Android,IOS',
            'governance_token' => 'axie-infinity',
            'rewards_token' => 'smooth-love-potion',
            'f2p' => 'NFT Required',
            'screenshots' => 'screenshots_1441a86c36d75ec36858814aebb91150a72021b47.jpg,screenshots_2441a86c36d75ec36858814aebb91150a72021b47.jpg',
            'is_approved' => '0',
            'genre_ids' => '1,3,5',
            'blockchain_ids' => '1,4',
            'is_approved' => true,
            'slug' => 'axie-invinity'
        ]);


        Game::create([
            'user_id' => 1,
            'name' => 'Crypto Cars',
            'short_description' => 'Build your own cryptro cars and enjoy races',
            'description' => 'CryptoCars is the first NFT Racing game developed by the team that used to work for Gameloft & Genshin Impact project.
Gameplay
Each car has 4 stats points: Speed, power, drift, fuel.
As a player in CryptoCars your mission is to win races (PvP, PvC racing) to get experience points and materials. To participate in a race, cars need fuel. Daily, fuel will be automatically refilled.
When you gain enough experience points, you can use materials to upgrade your car level. Materials & cars can be sold on Marketplace.

Play to Earn Model
New players need to buy a car on Marketplace to start playing game.',
            'image' => 'image_72b73cdcb36e09758990c7045445f94a66cd36c1.png',
            'status' => 'Live',
            'device' => 'Web,Android,IOS',
            'governance_token' => 'cryptocars',
            'f2p' => 'NFT Required',
            'screenshots' => 'screenshots_1441a86c36d75ec36858814aebb91150a72021b47.jpg,screenshots_2441a86c36d75ec36858814aebb91150a72021b47.jpg',
            'is_approved' => '0',
            'genre_ids' => '2',
            'blockchain_ids' => '2',
            'is_approved' => true,
            'slug' => 'crypto-cars'
        ]);
    }
}
