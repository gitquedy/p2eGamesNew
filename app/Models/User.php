<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'eth_address',
        'phone_number',
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'has_password',
    ];

    public function isAdmin(){
        return in_array($this->id, config('app.admins'));
    }

    public function displayName() {
        if ($this->name != null) {
            return $this->name;
        }
        else if($this->eth_address != null){
            return Str::limit($this->eth_address, 6, $end='...');
        }
    }

    public function profileUrl(){
        return asset('images/user/profile/' . $this->profile_photo_path);
    }

    public function useful(){
        return $this->hasMany(Useful::class, 'user_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'user_id')->where('status', 1);
    }


    public function getHasPasswordAttribute()
    {
        return ! empty($this->attributes['password']);
    }
}
