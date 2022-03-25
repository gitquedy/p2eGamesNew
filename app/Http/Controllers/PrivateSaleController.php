<?php

namespace App\Http\Controllers;

use App\Models\PrivateSale;
use App\Models\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class PrivateSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('privateSale.index'), 'name'=>"PTE Private Sale"], ['name'=>"List of PTE Private Sale"]
        ];
        if (request()->ajax()) {
            $privateSale = PrivateSale::orderBy('created_at', 'desc');
            return Datatables::eloquent($privateSale)
            ->addColumn('user', function(PrivateSale $privatesale) {
                return $privatesale->user->name;
            })
            ->editColumn('join_private_sale_round', function(PrivateSale $privateSale) {
                            
                            return ($privateSale->join_private_sale_round)?"Yes":"No";
                        })
            ->addColumn('action', function(PrivateSale $privateSale) {
                            $html = Utilities::actionDropdown([
                                // ['route' => route('privateSale.edit', $privateSale->id), 'name' => 'Edit'],  
                                ['route' => route('privateSale.delete', $privateSale->id), 'name' => 'Delete']
                            ]);
                            return $html;
                        })
            ->rawColumns(['action','join_private_sale_round'])
            ->make(true);
        }
        return view('admin.privatesale.index', [
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
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"], ['name'=>"PTE Private Sale"]
        ];
        return view('content.privatesale.index');
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
            'name' => ['required'],
            'email' => ['required', 'email'],
            'join_private_sale_round' => ['required'],
            'contribute' => ['required', 'numeric', 'min:1', 'max:20'],
            'bsc_wallet' => ['required'],
            'telegram' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $user->name = $request->name;
            $user->eth_address = $request->bsc_wallet;
            $user->save();

            PrivateSale::create([
                'user_id' => $user->id,
                'email' => $request->email,
                'join_private_sale_round' => $request->join_private_sale_round,
                'contribute' => $request->contribute,
                'bsc_wallet' => $request->bsc_wallet,
                'telegram' => $request->telegram,
            ]);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'PTE Private Sale submitted successfully!',
                        'redirect' => route('home')
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
     * @param  \App\Models\PrivateSale  $privateSale
     * @return \Illuminate\Http\Response
     */
    public function show(PrivateSale $privateSale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrivateSale  $privateSale
     * @return \Illuminate\Http\Response
     */
    public function edit(PrivateSale $privateSale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrivateSale  $privateSale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrivateSale $privateSale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrivateSale  $privateSale
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrivateSale $privateSale)
    {
        try {
            DB::beginTransaction();
            $privateSale->delete();
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Payment Sale successfully deleted!'
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


    public function delete(PrivateSale $privateSale){
        $action = route('privateSale.destroy', $privateSale->id);
        $title = 'privateSale ' . $privateSale->name;
        return view('layouts.delete', compact('action' , 'title'));
    }

    public function default(PrivateSale $privateSale)
    {
        try {
            DB::beginTransaction();
            PrivateSale::where('id', '!=', $privateSale->id)->update(['isDefault' => false]);
            $privateSale->update(['isDefault' => true]);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'PrivateSale successfully updated!',
                        'table' => 'paymentmethod_table'
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
