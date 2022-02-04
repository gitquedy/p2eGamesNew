<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilities;
use Auth;
use Validator;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('banner.index'), 'name'=>"Banner"], ['name'=>"list of Banner"]
        ];
        if (request()->ajax()) {
            $banner = Banner::orderBy('updated_at', 'desc');
            return Datatables::eloquent($banner)
            ->addColumn('isActive', function(Banner $banner) {
                            return $banner->isActive == 1 ? 'Yes' : 'No';
                        })
            ->addColumn('delegation', function(Banner $banner) {
                            return $banner->delegation == 1 ? 'Banner 1' : 'Banner 2';
                        })
            ->addColumn('link', function(Banner $banner) {
                            return '<a href="'. $banner->link . '" target="_blank"> '. $banner->link .' <a/>';
                        })
            ->addColumn('action', function(Banner $banner) {
                            $html = Utilities::actionDropdown([
                                ['route' => route('banner.edit', $banner->id), 'name' => 'Edit'],
                                ['route' => route('banner.delete', $banner->id), 'name' => 'Delete'],
                            ]);
                            return $html;
                        })
            ->rawColumns(['action', 'nameAndIcon', 'link'])
            ->make(true);
        }
        return view('admin.banner.index', [
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
        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'link' => ['url'],
            'delegation' => ['required'],
            'full' => ['required', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'mobile' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'tablet' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'isActive' => ['required']
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $data = $request->all();
            if($request->hasFile('full')){
              $photo = $data['full'];
              $new_name = 'full_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/home/banner/') , $new_name);
              $data['full'] = $new_name;
            }
            if($request->hasFile('mobile')){
              $photo = $data['mobile'];
              $new_name = 'mobile_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/home/banner/') , $new_name);
              $data['mobile'] = $new_name;
            }
            if($request->hasFile('tablet')){
              $photo = $data['tablet'];
              $new_name = 'tablet_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/home/banner/') , $new_name);
              $data['tablet'] = $new_name;
            }
            Banner::create($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Banner added successfully!',
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
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'link' => ['url'],
            'delegation' => ['required'],
            'full' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'mobile' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'tablet' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'isActive' => ['required']
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            if($request->hasFile('full')){
              $photo = $data['full'];
              $new_name = 'full_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/home/banner/full') , $new_name);
              $data['full'] = $new_name;
            }
            if($request->hasFile('mobile')){
              $photo = $data['mobile'];
              $new_name = 'mobile_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/home/banner/mobile') , $new_name);
              $data['mobile'] = $new_name;
            }
            if($request->hasFile('tablet')){
              $photo = $data['tablet'];
              $new_name = 'tablet_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/home/banner/tablet') , $new_name);
              $data['tablet'] = $new_name;
            }
            $data = $request->all();
            $banner->update($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Banner added successfully!',
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        try {
            DB::beginTransaction();
            $banner->delete();
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Banner successfully deleted!'
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

    public function delete(Banner $banner){
        $action = route('banner.destroy', $banner->id);
        $title = 'banner ' . $banner->name;
        return view('layouts.delete', compact('action' , 'title'));
    }
}
