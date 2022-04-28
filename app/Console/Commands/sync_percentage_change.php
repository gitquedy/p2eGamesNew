<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;

class sync_percentage_change extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:syncpercentage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Percentage Change for Games';

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
        $games = Game::whereNotNull('governance_token')->get();

        foreach($games as $game){
            $game->syncCoingeckoData();
        }
    }
}
