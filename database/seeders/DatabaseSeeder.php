<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(BlockChainSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(GameSeeder::class);
        $this->call(BannerSeeder::class);
    }
}
