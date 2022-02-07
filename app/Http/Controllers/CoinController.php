<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilities;
use Auth;
use Validator;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use App\Rules\ValidApiId;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('coin.index'), 'name'=>"Coin"], ['name'=>"List of Coin"]
        ];
        if (request()->ajax()) {
            $coin = Coin::orderBy('updated_at', 'desc');
            return Datatables::eloquent($coin)
            ->addColumn('action', function(Coin $coin) {
                            $html = Utilities::actionDropdown([['route' => route('coin.edit', $coin->id), 'name' => 'Edit'], ['route' => route('coin.default', $coin->id), 'name' => 'Default', 'type' => 'confirmation', 'title' => 'Are you sure to default ' . $coin->name . '?'], ['route' => route('coin.delete', $coin->id), 'name' => 'Delete']]);
                            return $html;
                        })
            ->addColumn('nameAndIcon', function(Coin $coin) {
                            $html = $coin->getNameAndIconDisplay();
                            return $html;
                        })
            ->addColumn('minimum_price', function(Coin $coin) {
                            return number_format($coin->minimum_price, 2);
                        })

            ->addColumn('markup_price', function(Coin $coin) {
                            return $coin->markup_price . '%';
                        })
            ->addColumn('isActive', function(Coin $coin) {
                            return $coin->isActive ? 'Yes' : 'No';
                        })
            ->rawColumns(['action', 'nameAndIcon'])
            ->make(true);
        }
        return view('admin.coin.index', [
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
            'name' => ['required', 'unique:coins,name'],
            'short_name' => ['required'],
            'default' => ['required', 'regex:/^\d*(\.\d{1,2})?$/'],
            'step' => ['required', 'regex:/^\d*(\.\d{1,2})?$/'],
            'icon' => ['required', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'minimum_price' => ['required', 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'markup_price' => ['required', 'integer', 'between:1,100'],
            'coingecko_id' => ['required','string', new ValidApiId],
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
              $photo->move(public_path('images/coin/icon') , $new_name);
              $data['icon'] = $new_name;
            }
            Coin::create($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Coin added successfully!',
                        // 'redirect' => action('CategoryController@index')
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
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function show(Coin $coin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function edit(Coin $coin)
    {
        return view('admin.coin.edit', compact('coin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coin $coin)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:coins,name,' . $coin->id],
            'short_name' => ['required'],
            'icon' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'minimum_price' => ['required', 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'markup_price' => ['required', 'integer', 'between:1,100'],
            'coingecko_id' => ['required','string', new ValidApiId],
            'default' => ['required', 'regex:/^\d*(\.\d{1,2})?$/'],
            'step' => ['required', 'regex:/^\d*(\.\d{1,2})?$/'],
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
              $photo->move(public_path('images/coin/icon') , $new_name);
              $data['icon'] = $new_name;
            }
            $coin = $coin->update($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Coin updated successfully!'
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
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coin $coin)
    {
        try {
            DB::beginTransaction();
            $coin->update(['isActive' => false]);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Coin successfully deleted!'
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

    public function default(Coin $coin)
    {
        try {
            DB::beginTransaction();
            Coin::where('id', '!=', $coin->id)->update(['isDefault' => false]);
            $coin->update(['isDefault' => true]);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Coin successfully updated!',
                        'table' => 'coin_table'
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



    public function delete(Coin $coin){
        $action = route('coin.destroy', $coin->id);
        $title = 'coin ' . $coin->name;
        return view('layouts.delete', compact('action' , 'title'));
    }
}
