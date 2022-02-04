<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilities;
use Auth;
use Validator;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('paymentMethod.index'), 'name'=>"PaymentMethod"], ['name'=>"list of PaymentMethod"]
        ];
        if (request()->ajax()) {
            $paymentMethod = PaymentMethod::orderBy('updated_at', 'desc');
            return Datatables::eloquent($paymentMethod)
            ->addColumn('action', function(PaymentMethod $paymentMethod) {
                            $html = Utilities::actionDropdown([['route' => route('paymentMethod.edit', $paymentMethod->id), 'name' => 'Edit'], ['route' => route('paymentMethod.delete', $paymentMethod->id), 'name' => 'Delete']]);
                            return $html;
                        })
            ->addColumn('providerAndIcon', function(PaymentMethod $paymentMethod) {
                            $html = $paymentMethod->getProviderNameDisplay();
                            return $html;
                        })
            ->addColumn('isActive', function(PaymentMethod $paymentMethod) {
                            return $paymentMethod->isActive ? 'Yes' : 'No';
                        })
            ->rawColumns(['action', 'providerAndIcon'])
            ->make(true);
        }
        return view('admin.paymentmethod.index', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'account_name' => ['required'],
            'account_number' => ['required'],
            'provider' => ['required'],
            'icon' => ['required', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $data = $request->all();
            if($request->hasFile('icon')){
              $photo = $data['icon'];
              $new_name = 'icon_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/paymentmethod/icon') , $new_name);
              $data['icon'] = $new_name;
            }
            PaymentMethod::create($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'PaymentMethod added successfully!',
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
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.paymentmethod.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validator = Validator::make($request->all(), [
            'account_name' => ['required'],
            'account_number' => ['required'],
            'provider' => ['required'],
            'icon' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $data = $request->all();
            if($request->hasFile('icon')){
              $photo = $data['icon'];
              $new_name = 'icon_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/paymentmethod/icon') , $new_name);
              $data['icon'] = $new_name;
            }
            $paymentMethod = $paymentMethod->update($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Payment Method updated successfully!'
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
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        try {
            DB::beginTransaction();
            $paymentMethod->update(['isActive' => false]);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Payment Method successfully deleted!'
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

    public function delete(PaymentMethod $paymentMethod){
        $action = route('paymentMethod.destroy', $paymentMethod->id);
        $title = 'paymentMethod ' . $paymentMethod->name;
        return view('layouts.delete', compact('action' , 'title'));
    }
}
