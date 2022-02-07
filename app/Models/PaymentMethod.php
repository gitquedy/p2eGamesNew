<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = ['account_name', 'account_number', 'provider', 'isActive', 'icon', 'isDefault'];

    public function getProviderNameDisplay(){
         return '<div class="d-flex justify-content-left align-items-center">
              <div class="avatar bg-light-red me-1"><img src="'. $this->imageUrl() .'" alt="Avatar" width="32" height="32"></div><div class="d-flex flex-column"><span class="emp_name text-truncate fw-bold">'. $this->provider . '</span></div></div>';
    }

    public function imageUrl(){
        return asset('images/paymentmethod/icon/'. $this->icon);
    }
}
