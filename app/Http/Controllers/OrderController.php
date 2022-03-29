<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Coin;
use App\Models\PaymentMethod;
use App\Models\SystemSetting;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('order.index'), 'name'=>"order"], ['name'=>"List of Orders"]
        ];
        if (request()->ajax()) {
            if($request->user()->isAdmin()){
                $order = Order::orderBy('updated_at', 'desc');
                if($request->paymentMethod != "all"){
                    $order->where('payment_method_id', $request->paymentMethod);
                }
                if($request->coin != "all"){
                    $order->where('coin_id', $request->coin);
                }
            }else{
                $order = Order::where('user_id', $request->user()->id)->orderBy('updated_at', 'desc');
            }

            if($request->status != "all"){
                $order->where('status', $request->status);
            }


            return Datatables::eloquent($order)
            ->editColumn('transaction', function(order $order) {
                            return $order->getTransactionBadge();
                        })
            ->addColumn('action', function(order $order) {
                            return $order->getDropDown();
                        })
            ->addColumn('createdAtFormatted', function(order $order) {
                            return $order->createdAtFormatted;
                        })
            ->addColumn('name', function(order $order) {
                            return $order->user ? $order->user->name : '';
                        })
            ->addColumn('coin', function(order $order) {
                            return $order->coin ? $order->coin->getNameAndIconDisplay() : '';
                        })
            ->addColumn('status', function(order $order) {
                            $status = $order->statusDisplay;
                            return '<span class="badge rounded-pill badge-light-'. $status['class'] .'" text-capitalized=""> '. $status['text'] .' </span>';
                        })
            ->addColumn('idFormatted', function(order $order) {
                            return '<a class="fw-bold" href="'. route('order.show', $order) .'"> #'. $order->id .'</a>';
                        })
            ->addColumn('totalFormatted', function(order $order) {
                            return '₱' . number_format($order->total, 2);
                        })
            ->addColumn('paymentMethod', function(order $order) {
                            $paymentMethod = $order->paymentMethod;
                            return '<span data-bs-toggle="tooltip" data-bs-placement="top" title="'. $paymentMethod->account_name .'('. $paymentMethod->account_number .')">'. $paymentMethod->getProviderNameDisplay() .'</span>';
                        })
            ->rawColumns(['action', 'transaction', 'idFormatted', 'paymentMethod', 'coin', 'status'])
            ->make(true);
        }
        $coins = Coin::where('isActive', true)->get();
        $paymentMethods = PaymentMethod::where('isActive', true)->get();
        return view('content.order.index', [
            'breadcrumbs' => $breadcrumbs,
            'paymentMethods' => $paymentMethods,
            'coins' => $coins,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coin_id' => ['required','exists:coins,id'],
            'payment_method_id' =>  ['required', 'exists:payment_methods,id'],
            'eth_address' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required', 'unique:users,email,' . $request->user()->id],
            'name'=> ['required'],
            'notes'=> ['required_if:transaction,sell'],
            'transaction'=> ['required', 'in:buy,sell'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $cart = Session::get('cart');
            $cart['coin']= Coin::where('id', $cart['coin_id'])->first();
            $cart['coingecko'] = $cart['coin']->coingecko;
            $cart['exchangeFixPrice'] = SystemSetting::first()->exchange_fix_price;
            $cart['computedPrice'] = $cart['coin']->computedPrice($cart['qty']);
            $cart['transactionFee'] = $cart['coin']->getTransactionFee($cart['qty']);


            if ($cart['transaction'] == "buy") {
                if(isset($cart['total'])){
                    if($cart['total'] != $cart['exchangeFixPrice'] + $cart['computedPrice'] + $cart['transactionFee']){
                        $output = ['success' => 0,
                            'msg' => 'Price has been updated, please check.',
                        ];
                        return response()->json($output);
                    }
                }
                $cart['total'] = $cart['exchangeFixPrice'] + $cart['computedPrice'] + $cart['transactionFee'];
            }
            else if($cart['transaction'] == "sell") {
                if(isset($cart['total'])){
                    if($cart['total'] != $cart['computedPrice'] - ($cart['exchangeFixPrice'] + $cart['transactionFee'])){
                        $output = ['success' => 0,
                            'msg' => 'Price has been updated, please check.',
                        ];
                        return response()->json($output);
                    }
                }
                $cart['total'] = $cart['computedPrice'] - ($cart['exchangeFixPrice'] + $cart['transactionFee']);   
            }

            $data = [
                'coin_id' => $cart['coin_id'],
                'user_id' => $request->user()->id,
                'payment_method_id' => $request->payment_method_id,
                'transaction' => $request->transaction,
                'eth_address' => $request->eth_address,
                'minimum_price' => $cart['coin']->minimum_price,
                'markup_price' => $cart['coin']->markup_price,
                'exchange_transaction_fee' => SystemSetting::first()->exchange_transaction_fee,
                'exchange_fix_price' => $cart['exchangeFixPrice'],
                'price' => $cart['coingecko']['market_data']['current_price']['php'],
                'usePrice' => $cart['coingecko']['market_data']['current_price']['php'] < $cart['coin']->minimum_price ? $cart['coin']->minimum_price : $cart['coingecko']['market_data']['current_price']['php'],
                'sub_total' => $cart['computedPrice'],
                'transaction_fee' => $cart['transactionFee'],
                'service_charge' => SystemSetting::first()->exchange_transaction_fee,
                'total' => $cart['total'],
                'notes' => $request->notes,
                'qty' => $cart['qty'],
            ];
            
            $request->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'eth_address' => $request->eth_address
            ]);
            $order = Order::create($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Order added successfully! Please proceed to the next step.',
                        'redirect' => route('order.show', $order)
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Order $order)
    {
        // dd($request->useR());
        if($request->user()->id != $order->user_id && $request->user()->isAdmin() == false){
            abort(403, 'Unauthorized action.');
        }
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('order.index'), 'name'=>"Order List"], ['name'=>"Order Details"]
        ];
        return view('content.order.show', compact('order', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if($request->user()->id != $order->user_id && $request->user()->isAdmin() == false){
            $output = ['success' => 0,
                        'msg' => '403: Unauthorized',
                    ];
            return response()->json($output);
        }
        $data = $request->all();
        if ($order->transaction == "buy") {
            if($request->updateMethod == 'payment'){
                $validator = Validator::make($data, [
                    'payment_proof' => ['required', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                ]);
                $msg = 'Payment added Successfully';
                $data['status'] = '2';
            }
            if($request->updateMethod == 'txid'){
                $validator = Validator::make($data, [
                    // 'txid' => ['required'],
                ]);
                $msg = 'Order completed Successfully';
                $data['status'] = '4';
            }
        }
        elseif ($order->transaction == "sell") {
            if($request->updateMethod == 'txid'){
                $validator = Validator::make($data, [
                    'txid' => ['required'],
                ]);
                $msg = 'Transaction ID added Successfully';
                $data['status'] = '2';
            }
            if($request->updateMethod == 'payment'){
                $validator = Validator::make($data, [
                    'payment_proof' => ['required', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                ]);
                $msg = 'Payment added Successfully';
                $data['status'] = '4';
            }
        }
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            if($request->hasFile('payment_proof')){
              $photo = $data['payment_proof'];
              $new_name = 'payment_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/orders/payment_proof') , $new_name);
              $data['payment_proof'] = $new_name;
            }
            $order = $order->update($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => $msg,
                        'reload' => true
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();
            $order->delete();
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Order successfully deleted!'
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
    public function delete(Order $order){
        $action = route('order.destroy', $order->id);
        $title = 'order #' . $order->id;
        return view('layouts.delete', compact('action' , 'title'));
    }

    public function getPaymentProof(Order $order){
        // dd($order->paymentUrl());
        return view('content.order.partials.paymentProof', compact('order'));
    }

    public function confirmReceipt(Order $order){
        try {
            DB::beginTransaction();
            if ($order->transaction == "buy") {
                $data['status'] = 3;                
            }
            elseif($order->transaction == "sell"){
                $data['status'] = 6;                
            }
            $order = $order->update($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Receipt confirmed!',
                        'reload' => true
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


    public function cancel(Order $order){
        try {
            DB::beginTransaction();
            $data['status'] = 5;
            $order = $order->update($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Order successfully cancelled!',
                        'reload' => true
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
}
