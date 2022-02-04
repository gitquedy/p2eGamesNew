<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use App\Models\SystemSetting;

class Coin extends Model
{
    use HasFactory;

    protected $appends = ['coingecko'];

    protected $table = 'coins';

    protected $fillable = ['name', 'short_name','coingecko_id','minimum_price','markup_price','icon', 'isActive'];

    public function getNameAndIconDisplay(){
         return '<div class="d-flex justify-content-left align-items-center">
              <div class="avatar bg-light-red me-1"><img src="'. $this->imageUrl() .'" alt="Avatar" width="32" height="32"></div><div class="d-flex flex-column"><span class="emp_name text-truncate fw-bold">'. $this->name . ' ($'. $this->short_name .')</span></div></div>';
    }

    public function imageUrl(){
        return asset('images/coin/icon/'. $this->icon);
    }

    public function getCoingeckoAttribute(){
        $client = new CoinGeckoClient();
        $coin = $client->coins()->getCoin($this->coingecko_id, ['tickers' => 'false']);
        return $coin;
    }

    public function getFullNameAttribute(){
        return $this->name . ' ($'. $this->short_name .')';
    }

    public function getUsePriceAttribute(){
        $coin = $this->coingecko;
        $price = $coin['market_data']['current_price']['php'];
        $usePrice = $price < $this->minimum_price ? $this->minimum_price : $price;
        $totalAmountValue = ($usePrice * ($this->markup_price / 100) + $usePrice);
        return $totalAmountValue;
    }

    public function computedPrice($qty = 1){
        return $this->usePrice * $qty;
    }

    public function getTransactionFee($qty){
        $transaction_fee = SystemSetting::first()->exchange_transaction_fee;
        return ($this->computedPrice() * $qty) * ($transaction_fee / 100);
    }
}
