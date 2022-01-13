<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockChain extends Model
{
    use HasFactory;

    protected $table = 'blockchains';

    protected $fillable = ['name', 'short_name', 'icon' ,'is_deleted'];

    public function getNameAndIconDisplay(){
         return '<div class="d-flex justify-content-left align-items-center">
              <div class="avatar bg-light-red me-1"><img src="'. $this->imageUrl() .'" alt="Avatar" width="32" height="32"></div><div class="d-flex flex-column"><span class="emp_name text-truncate fw-bold">'. $this->name . '</span></div></div>';
    }

    public function imageUrl(){
        return asset('images/blockchain/icon/'. $this->icon);
    }

    public function getIconDisplay(){
        return '<img src="'. $this->imageUrl() .'" alt="Avatar" width="32" height="32" data-bs-toggle="tooltip" title="'. $this->name . ' ('. $this->short_name. ')">';
    }
}
