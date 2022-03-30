<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['coin_id', 'user_id', 'payment_method_id', 'transaction', 'eth_address', 'minimum_price', 'markup_price', 'exchange_transaction_fee', 'exchange_fix_price', 'price', 'usePrice', 'sub_total', 'transaction_fee', 'service_charge', 'total', 'status', 'notes', 'qty', 'payment_proof', 'txid'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coin(){
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function getCreatedAtFormattedAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('M d, Y H:i:s');
    }

    public function getExpiredAtAttribute(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->addHour()->format('M d, Y H:i:s');
    }

    public function getStatusDisplayAttribute(){
        $status = ['class' => '', 'text' => ''];
        if($this->status == 1){
            $status['class'] = 'info';
            $status['text'] = 'Pending Payment';
        }else if ($this->status == 2){
            $status['class'] = 'primary';
            $status['text'] = 'Waiting for Admin Confirmation Receipt';
        }else if ($this->status == 3){
            $status['class'] = 'primary';
            $status['text'] = 'Waiting for Admin Transfer of Tokens';
        }else if ($this->status == 4){
            $status['class'] = 'primary';
            $status['text'] = 'Order Completed';
        }
        else if ($this->status == 5){
            $status['class'] = 'danger';
            $status['text'] = 'Cancelled';
        }

        else if ($this->status == 6) {
            $status['class'] = 'primary';
            $status['text'] = 'Waiting for Admin Transfer of Payment';
        }

        return $status;
    }

    public function getPriceWithMarkupAttribute(){
        return ($this->usePrice * ($this->markup_price / 100)) + $this->usePrice;
    }

    public function getTransactionBadge() {
        if ($this->transaction == "buy") {
            return '<span class="badge bg-success">BUY</span>';
        }
        elseif($this->transaction == "sell") {
            return '<span class="badge bg-danger">SELL</span>';
        }
    }

    public function paymentUrl(){
        return asset('images/orders/payment_proof/' .  $this->payment_proof);
    }

    public function getDropDown(){
        $html = '<div class="d-flex align-items-center col-actions">';
        $html .= '<a target="_blank" class="me-1" href="'. route('order.show', $this) .'" data-bs-toggle="tooltip" data-bs-placement="top" title="View"><i data-feather="eye"></i></a>';
        if (Auth::user()->isAdmin()) {
            $html .=' <a class="me-1 modal_button" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-action="'. route('order.delete', $this) . '">
                          <i data-feather="trash" class="me-50"></i>
                       </a>';
        }
        $html .= '</div>';
        return $html;
    }


}
