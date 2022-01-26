<?php

namespace App\Console\Commands\game;

use Illuminate\Console\Command;

class SyncGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync necessary fields for games';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Sync Coingecko
        $games = Game::whereNotNull('governance_token')->get();

        foreach($games as $game){
            $game->syncCoingeckoData();
        }

        // Sync Rank
        Game::syncRank();
    }
}
