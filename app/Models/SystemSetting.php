<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $table = "system_settings";

    protected $fillable = ['exchange_transaction_fee', 'exchange_fix_price'];
}
