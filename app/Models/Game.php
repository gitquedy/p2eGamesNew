<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\BlockChain;
use App\Models\Utilities;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = ['name', 'user_id', 'description', 'short_description' , 'image', 'status', 'device', 'governance_token', 'rewards_token', 'minimum_investment', 'f2p', 'screenshots', 'is_approved',  'is_sponsored', 'genre_ids', 'blockchain_ids', 'website', 'twitter', 'discord', 'telegram', 'medium' , 'facebook', 'governance_price_change_percentage_24h', 'rank', 'redflag', 'rugpull', 'slug'];

    public static function syncRank(){
        $games = Game::withAvg('reviews', 'rating')->withCount('reviews')->orderBy('reviews_avg_rating', 'desc')->orderBy('reviews_count', 'desc')->get();
        $iteration = 1;
        foreach($games as $game){
            $game->update(['rank' => $iteration]);
            $iteration += 1;
        }
    }
    public function getNameAndImgDisplay(){
        $description = Str::limit($this->short_description, 30, $end='...');
        return '<a href="'. route('game.show', $this) .'"><div class="d-flex justify-content-left align-items-center">
              <div class="bg-light-red me-1"><img src="'. $this->imageUrl() .'" alt="Avatar" width="64" height="64"></div><div class="d-flex flex-column" ><span class="emp_name text-truncate fw-bold">'. $this->name . '</span><small class="emp_post text-truncate text-muted" data-bs-toggle="tooltip" title="'. $this->short_description . '"> '. $description .'</small></div></div></a>';
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'game_id', 'id')->where('status', 1);
    }

    public function allReviews(){
        return $this->hasMany(Review::class, 'game_id', 'id');
    }

    public function imageUrl(){
        return asset('images/game/image/'. $this->image);
    }

    public function screenshotUrl($screenshot){
        return asset('images/game/screenshots/'. $screenshot);
    }

    public function avgRating(){
        return $this->reviews()
          ->where('status', 1)
          ->selectRaw('avg(rating) as aggregate, game_id')
          ->groupBy('game_id');
    }

    public function getAvgRatingAttribute(){
        if ( ! array_key_exists('avgRating', $this->relations)) {
           $this->load('avgRating');
        }

        $relation = $this->getRelation('avgRating')->first();

        return ($relation) ? round($relation->aggregate, 2) : 0;
    }

     public function genres(){
          $ids = explode(',', $this->genre_ids);
          $genres = Genre::whereIn('id', $ids)->get();
          return $genres;
     }

     public function blockchains(){
          $ids = explode(',', $this->blockchain_ids);
          $blockchain = BlockChain::whereIn('id', $ids)->get();
          return $blockchain;
     }

     public function getBlockChainDisplay(){
        $blockchains = $this->blockchains();
        $html = '<div class="d-flex justify-content-left align-items-center">';
        foreach($blockchains as $blockchain){
            $html .= $blockchain->getIconDisplay();
        }
        $html .= '</div>';
        return $html;
     }

     public function getDeviceDisplay(){
        $devices = explode(',', $this->device);
        $html = '<div class="d-flex justify-content-left align-items-center"><div class="d-flex flex-column">';
        foreach($devices as $device){
            $html .= '<small class="emp_name text-truncate fw-bold">'. $device . '</small>';
        }
        $html .= '</div></div>';
        return $html;
     }

     public function getStatusDisplay(){
        $btnClasses = Utilities::getBtnClasses();
        // dd(isset($btnClasses[$this->status]) ? $btnClasses[$this->status] : '2');
        $html = '<div class="d-flex justify-content-left align-items-center"><div class="d-flex flex-column">';
        $html .= '<button class="btn btn-outline-'. $btnClasses[$this->status] .' btn-sm" data-bs-toggle="tooltip" title="'. $this->status . '">'. $this->status . '</button>';
        $html .= '</div></div>';
        return $html;
     }

     public function getF2pDisplay(){
        $btnClasses = Utilities::getBtnClasses();
        $class = $this->f2p == 'Free-To-Play' ? 'success' : 'danger';
        $html = '<button style="font-size:9px;" class="btn btn-'. $class .' btn-sm small" data-bs-toggle="tooltip" title="'. $this->f2p . '">'. $this->f2p . '</button>';
        return $html;
     }

     public function get3rdPartyDisplay(){
        $html = '';
        if($this->facebook){
            $html .= '<a target="_blank" href="'. $this->facebook .'" class="game-links"><img src="'. asset('images/links/facebook.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->facebook .'"></a>';
        }
        if($this->website){
            $html .= '<a target="_blank" href="'. $this->website .'" class="game-links"><img src="'. asset('images/links/website.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->website .'"></a>';
        }
        if($this->twitter){
            $html .= '<a target="_blank" href="'. $this->twitter .'" class="game-links"><img src="'. asset('images/links/twitter.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->twitter .'"></a>';
        }
        if($this->discord){
            $html .= '<a target="_blank" href="'. $this->discord .'" class="game-links"><img src="'. asset('images/links/discord.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->discord .'"></a>';
        }
        if($this->telegram){
            $html .= '<a target="_blank" href="'. $this->telegram .'" class="game-links"><img src="'. asset('images/links/telegram.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->telegram .'"></a>';
        }
        if($this->medium){
            $html .= '<a target="_blank" href="'. $this->medium .'" class="game-links"><img src="'. asset('images/links/medium.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->medium .'"></a>';
        }
        return $html;
     }

     public function getGovernanceMarketChartAttribute(){
        if($this->governance_token){
            $client = new CoinGeckoClient();
            $governance_token = $client->coins()->getMarketChart($this->governance_token, 'php', "30");
        }
        return $this->governance_token ? $governance_token : null;
     }

     public function getRewardsMarketChartAttribute(){
        if($this->rewards_token){
            $client = new CoinGeckoClient();
            $rewards_token = $client->coins()->getMarketChart($this->rewards_token, 'php', "30");
        }
        return $this->rewards_token ? $rewards_token : null;
     }

     public function getRewardsCoinAttribute(){
        if($this->rewards_token){
            $client = new CoinGeckoClient();
            $coin = $client->coins()->getCoin($this->rewards_token, ['tickers' => 'false']);
        }
        return $this->rewards_token ? $coin : null;
     }

     public function getGovernanceCoinAttribute(){
        if($this->governance_token){
            $client = new CoinGeckoClient();
            $coin = $client->coins()->getCoin($this->governance_token, ['tickers' => 'false']);
        }
        return $this->governance_token ? $coin : null;
     }


     public function getGovernanceTokenDisplay() {
        $coin = $this->rewards_coin;
        return $coin ? $this->getCoinDisplay($coin) : '';
    }

    public function getRewardsToklenDisplay() {
         $coin = $this->governance_coin;
         return $coin ? $this->getCoinDisplay($coin) : '';
     }

     public function getCoinDisplay($coin){
        $html = '<img src="'. $coin['image']['small'] .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $coin['name'] . ' ('. strtoupper($coin['symbol']). ')">';
        return $html;
     }

     public function syncCoingeckoData(){
        $client = new CoinGeckoClient();
        $coin = $client->coins()->getCoin($this->governance_token,['tickers' => 'false']);
        $this->update(['governance_price_change_percentage_24h' => $coin['market_data']['price_change_percentage_24h']]);
     }
}
