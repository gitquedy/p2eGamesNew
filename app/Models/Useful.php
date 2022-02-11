<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Useful extends Model
{
    use HasFactory;

    protected $table = 'useful';

    protected $fillable = ['user_id', 'review_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function review(){
        return $this->belongsTo(Review::class, 'review_id');
    }
}
