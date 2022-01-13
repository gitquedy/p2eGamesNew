<?php

namespace App\Http\Controllers;

use App\Models\BlockChain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilities;
use Auth;
use Validator;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class BlockChainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('blockchain.index'), 'name'=>"BlockChain"], ['name'=>"list of BlockChain"]
        ];
        if (request()->ajax()) {
            $blockchain = BlockChain::where('is_deleted', 0)->orderBy('updated_at', 'desc');
            return Datatables::eloquent($blockchain)
            ->addColumn('action', function(BlockChain $blockchain) {
                            $html = Utilities::actionDropdown([['route' => route('blockchain.edit', $blockchain->id), 'name' => 'Edit'], ['route' => route('blockchain.delete', $blockchain->id), 'name' => 'Delete']]);
                            return $html;
                        })
            ->addColumn('nameAndIcon', function(BlockChain $blockchain) {
                            $html = $blockchain->getNameAndIconDisplay();
                            return $html;
                        })
            ->rawColumns(['action', 'nameAndIcon'])
            ->make(true);
        }
        return view('content.blockchain.index', [
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
            'name' => ['required', 'unique:blockchains,name'],
            'short_name' => ['required'],
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
              $photo->move(public_path('images/blockchain/icon') , $new_name);
              $data['icon'] = $new_name;
            }
            BlockChain::create($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'BlockChain added successfully!',
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
     * @param  \App\Models\BlockChain  $blockChain
     * @return \Illuminate\Http\Response
     */
    public function show(BlockChain $blockChain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlockChain  $blockChain
     * @return \Illuminate\Http\Response
     */
    public function edit(BlockChain $blockchain)
    {
        return view('content.blockChain.edit', compact('blockchain'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlockChain  $blockChain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlockChain $blockchain)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:blockchains,name,' . $blockchain->id],
            'short_name' => ['required'],
            'icon' => ['mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
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
              $photo->move(public_path('images/blockchain/icon') , $new_name);
              $data['icon'] = $new_name;
            }
            $blockchain = $blockchain->update($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'BlockChain updated successfully!'
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
     * @param  \App\Models\BlockChain  $blockChain
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlockChain $blockchain)
    {
        try {
            DB::beginTransaction();
            $blockchain->update(['is_deleted' => true]);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'BlockChain successfully deleted!'
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

    public function delete(BlockChain $blockchain){
        $action = route('blockchain.destroy', $blockchain->id);
        $title = 'blockchain ' . $blockchain->name;
        return view('layouts.delete', compact('action' , 'title'));
    }


}
