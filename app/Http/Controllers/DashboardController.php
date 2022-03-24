<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Blockchain;
use App\Models\Banner;

class DashboardController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	$gainers = Game::orderBy('governance_price_change_percentage_24h', 'desc')->where('governance_price_change_percentage_24h' ,'>', '0')->limit(3)->get();
        $losers = Game::orderBy('governance_price_change_percentage_24h', 'asc')->where('governance_price_change_percentage_24h' ,'<', '0')->limit(3)->get();
        $banner1 = Banner::where('delegation', '1')->where('isActive', true)->inRandomOrder()->limit(1)->get()->first();
        $banner2 = Banner::where('delegation', '2')->where('isActive', true)->inRandomOrder()->limit(1)->get()->first();
        return view('content.dashboard.index', compact('gainers', 'losers', 'banner1', 'banner2'));
    }
}
