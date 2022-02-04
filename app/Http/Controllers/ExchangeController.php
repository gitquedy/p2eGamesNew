<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coin;
use App\Models\PaymentMethod;
use App\Models\Order;
use App\Models\SystemSetting;
use Validator;
use Illuminate\Support\Facades\Session;

class ExchangeController extends Controller
{
    public function index(){
        $coins = Coin::where('isActive', true)->get();
        $exchangeFixPrice = SystemSetting::first()->exchange_fix_price;
        $paymentMethods = PaymentMethod::where('isActive', true)->get();
        return view('content.exchange.index', compact('coins', 'paymentMethods', 'exchangeFixPrice'));
    }

    public function saveCart(Request $request){
        $validator = Validator::make($request->all(), [
            'coin_id' => ['required', 'exists:coins,id'],
            'paymentmethod_id' => ['required', 'exists:payment_methods,id'],
            'qty' => 'required'
          ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        try {
            $cart = [
                'coin_id' => $request->coin_id,
                'qty' => $request->qty,
                'paymentmethod' => PaymentMethod::where('id', $request->paymentmethod_id)->first(),
            ];
            Session::put('cart', $cart);

            $output = ['success' => 1,
                        // 'msg' => 'Success',
                        'redirect' => route('exchange.checkOut'),
                    ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). " Line:" . $e->getLine(). " Message:" . $e->getMessage());
            $output = ['success' => 0,
                        'msg' => env('APP_DEBUG') ? $e->getMessage() : 'Sorry something went wrong, please try again later.'
                    ];
             DB::rollBack();
        }
        return response()->json($output);
    }

    public function checkOut(Request $request){
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('exchange.index'), 'name'=>"Exchange"], ['name'=>"Checkout"]
        ];
        if($request->ajax()){
            $cart = Session::get('cart');
            $cart['coin']= Coin::where('id', $cart['coin_id'])->first();
            $cart['exchangeFixPrice'] = SystemSetting::first()->exchange_fix_price;
            $cart['computedPrice'] = $cart['coin']->computedPrice($cart['qty']);
            $cart['transactionFee'] = $cart['coin']->getTransactionFee($cart['qty']);

            if(isset($cart['total'])){
                if($cart['total'] != $cart['exchangeFixPrice'] + $cart['computedPrice'] + $cart['transactionFee']){
                    $request->session()->flash('message','Price has been updated, please check.');
                }
            }
            $cart['total'] = $cart['exchangeFixPrice'] + $cart['computedPrice'] + $cart['transactionFee'];

            Session::put('cart', $cart);
            return view('content.exchange.partials.totals', compact('cart'));
        }
        $cart = Session::get('cart');
        if(! isset($cart)){
            return redirect(route('exchange.index'));
        }
        $paymentMethods = PaymentMethod::where('isActive', true)->get();
        return view('content.exchange.checkout', compact('breadcrumbs', 'cart', 'paymentMethods'));
    }
}
