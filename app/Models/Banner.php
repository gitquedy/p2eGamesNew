<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banner';

    protected $fillable = ['name', 'isActive', 'full', 'mobile', 'tablet', 'delegation', 'link'];

    public function imageUrl($file){
        return asset('images/home//banner/'. $file);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('M d, Y H:i');
    }

}
