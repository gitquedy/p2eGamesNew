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

    protected $fillable = ['name', 'user_id', 'description', 'short_description' , 'image', 'status', 'device', 'governance_token', 'rewards_token', 'minimum_investment', 'f2p', 'screenshots', 'is_approved', 'genre_ids', 'blockchain_ids', 'website', 'twitter', 'discord', 'telegram', 'github', 'facebook'];


    public function getNameAndImgDisplay(){
        $description = Str::limit($this->short_description, 30, $end='...');
        return '<a href="'. route('game.show', $this) .'"><div class="d-flex justify-content-left align-items-center">
              <div class="bg-light-red me-1"><img src="'. $this->imageUrl() .'" alt="Avatar" width="64" height="64"></div><div class="d-flex flex-column" ><span class="emp_name text-truncate fw-bold">'. $this->name . '</span><small class="emp_post text-truncate text-muted" data-bs-toggle="tooltip" title="'. $this->short_description . '"> '. $description .'</small></div></div></a>';
    }

    public function reviews() {
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


    public function getGovernanceTokenDisplay() {
        if($this->governance_token){
            $client = new CoinGeckoClient();
            $coin = $client->coins()->getCoin($this->governance_token, ['tickers' => 'true']);
            return $this->getCoinDisplay($coin);
        }
    }

    public function getRewardsToklenDisplay() {
        if($this->rewards_token){
            $client = new CoinGeckoClient();
            $coin = $client->coins()->getCoin($this->rewards_token, ['tickers' => 'false']);
            return $this->getCoinDisplay($coin);
        }
     }

     public function getCoinDisplay($coin){
        $html = '<img src="'. $coin['image']['small'] .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $coin['name'] . ' ('. strtoupper($coin['symbol']). ')">';
        return $html;
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
            $html .= '<span class="emp_name text-truncate fw-bold">'. $device . '</span>';
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
        $html = '<button class="btn btn-'. $class .' btn-sm" data-bs-toggle="tooltip" title="'. $this->f2p . '">'. $this->f2p . '</button>';
        return $html;
     }

     public function get3rdPartyDisplay(){
        $html = '';
        if($this->facebook){
            $html .= '<a href="'. $this->facebook .'" class="game-links"><img src="'. asset('images/links/facebook.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->facebook .'"></a>';
        }
        if($this->website){
            $html .= '<a href="'. $this->website .'" class="game-links"><img src="'. asset('images/links/website.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->website .'"></a>';
        }
        if($this->twitter){
            $html .= '<a href="'. $this->twitter .'" class="game-links"><img src="'. asset('images/links/twitter.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->twitter .'"></a>';
        }
        if($this->discord){
            $html .= '<a href="'. $this->discord .'" class="game-links"><img src="'. asset('images/links/discord.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->discord .'"></a>';
        }
        if($this->telegram){
            $html .= '<a href="'. $this->telegram .'" class="game-links"><img src="'. asset('images/links/telegram.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->telegram .'"></a>';
        }
        if($this->github){
            $html .= '<a href="'. $this->github .'" class="game-links"><img src="'. asset('images/links/github.png') .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->github .'"></a>';
        }
        return $html;





     }
}
