<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateSale extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'email', 'join_private_sale_round', 'contribute', 'bsc_wallet', 'telegram'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
