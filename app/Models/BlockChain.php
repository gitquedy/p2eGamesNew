<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockChain extends Model
{
    use HasFactory;

    protected $table = 'blockchains';

    protected $fillable = ['name', 'short_name', 'is_deleted'];
}
