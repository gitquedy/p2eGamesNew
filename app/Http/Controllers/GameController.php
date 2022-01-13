<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use App\Models\BlockChain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilities;
use Auth;
use Validator;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use App\Rules\ValidApiId;

class GameController extends Controller
{

    public function __construct() {
        $this->middleware('auth', ['only' => ['create', 'store']]);
        $this->middleware('admin', ['only' => ['destroy', 'delete', 'approve', 'approveGame', 'edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('game.index'), 'name'=>"Games"], ['name'=>"list of Games"]
        ];
        if (request()->ajax()) {
            $game = Game::orderBy('updated_at', 'desc');
            if($request->genre != "all"){
                $game->whereRaw('find_in_set("'. $request->genre .'",genre_ids)');
            }
            if($request->blockchain != "all"){
                $game->whereRaw('find_in_set("'. $request->blockchain .'",blockchain_ids)');
            }
            if($request->device != "all"){
                $game->whereRaw('find_in_set("'. $request->device .'",device)');
            }
            if($request->status != "all"){
                $game->where('status', $request->status);
            }
            if($request->f2p != "all"){
                $game->where('f2p', $request->f2p);
            }
            if($request->has('is_approved')){
                if($request->is_approved != "all"){
                    $game->where('is_approved', $request->is_approved);
                }
            }else{
                $game->where('is_approved', 1);
            }

            return Datatables::eloquent($game)
            ->addColumn('action', function(Game $game) {
                            if($game->is_approved){
                                $actions = [
                                    ['route' => route('game.edit', $game->id), 'name' => 'Edit'],
                                    ['route' => route('game.delete', $game->id), 'name' => 'Delete'],
                                ];
                            }else{
                                $actions = [
                                    ['route' => route('game.edit', $game->id), 'name' => 'Edit'],
                                    ['route' => route('game.delete', $game->id), 'name' => 'Delete'],
                                    ['route' => route('game.approve', $game->id), 'name' => 'Approve'],
                                ];
                            }
                            $html = Utilities::actionDropdown($actions);
                            return $html;
                        })
            ->addColumn('nameAndImgDisplay', function(Game $game) {
                return $game->getNameAndImgDisplay();
            })
            ->addColumn('genres', function(Game $game) {
                $genres = $game->genres();
                $html = '<div class="d-flex justify-content-left align-items-center"><div class="d-flex flex-column">';
                foreach($genres as $genre){
                    $html .= '<span class="emp_name text-truncate fw-bold">'. $genre->name . '</span>';
                }
                $html .= '</div></div>';
                return $html;
            })
            ->addColumn('blockchains', function(Game $game) {
                $html = $game->getBlockChainDisplay();
                return $html;
            })
            ->addColumn('devices', function(Game $game) {
                $html = $game->getDeviceDisplay();
                return $html;
            })
            ->addColumn('status', function(Game $game) {
                $html = $game->getStatusDisplay();
                return $html;
            })
            ->addColumn('f2p', function(Game $game) {
                $html = '<div class="d-flex justify-content-left align-items-center"><div class="d-flex flex-column">';
                $html .= $game->getF2pDisplay();
                $html .= '</div></div>';

                return $html;
            })
            ->addColumn('ratings', function(Game $game) {
                $html = '<div class="d-flex justify-content-left align-items-center">';
                $html = '<div class="read-only-ratings rating" data-rateyo-rating="'. $game->avgRating .'" data-rateyo-read-only="true"></div><small> &nbsp; '. $game->avgRating .'/5 out of '. $game->reviews()->count() .' reviews</small>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('minimum_investment_formatted', function(Game $game) {
                return number_format($game->minimum_investment, 2);
            })

            ->rawColumns(['action', 'nameAndImgDisplay', 'genres', 'blockchains', 'devices', 'status', 'f2p', 'ratings'])
            ->make(true);
        }
        $genres = Genre::all();
        $blockchains = BlockChain::all();
        return view('content.game.index', compact('breadcrumbs', 'genres', 'blockchains'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('game.index'), 'name'=>"Games"], ['name'=>"Create Game"]
        ];

        $blockchains = BlockChain::all();
        $genres = Genre::all();
        return view('content.game.create', compact('breadcrumbs', 'genres', 'blockchains'));
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
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genre_ids' => ['required', 'array'],
            'blockchain_ids' => ['required', 'array'],
            'device' => ['required', 'array'],
            'status' => 'required|string',
            'governance_token' => ['nullable','string', new ValidApiId],
            'rewards_token' => ['nullable','string', new ValidApiId],
            'minimum_investment' => ['nullable', 'integer'],
            'f2p' => 'required|string',
            'screenshots.*' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'short_description' => 'required',
            'website' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
            'discord' => ['nullable', 'url'],
            'telegram' => ['nullable', 'url'],
            'github' => ['nullable', 'url'],
            'facebook' => ['nullable', 'url'],
          ],[
            'genre_ids.required' => 'The genre field is Required',
            'blockchain_ids.required' => 'The blockChain field is Required',
          ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['genre_ids'] = implode(',', $request->genre_ids);
            $data['blockchain_ids'] = implode(',', $request->blockchain_ids);
            $data['device'] = implode(',', $request->device);
            if($request->hasFile('image')){
              $photo = $data['image'];
              $new_name = 'image_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/game/image') , $new_name);
              $data['image'] = $new_name;
            }
            if($request->hasFile('screenshots')){
                $i = 1;
                foreach($request->screenshots as $screenshot){
                    $new_name = 'screenshots_'. $i . sha1(time()) . '.' . $screenshot->getClientOriginalExtension();
                    $screenshot->move(public_path('images/game/screenshots') , $new_name);
                    $screenshots[] = $new_name;
                    $i++;
                }
                $data['screenshots'] = implode(',', $screenshots);
            }
            Game::create($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Game added successfully! Please wait for admin approval before being listed',
                        'redirect' => route('game.index'),
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
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('game.index'), 'name'=>"Games"], ['name'=> $game->name]
        ];
        return view('content.game.show', compact('game', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        $blockchains = BlockChain::all();
        $genres = Genre::all();
        $game_genres = explode(',', $game->genre_ids);
        $game_blockchains = explode(',', $game->blockchain_ids);
        $device = explode(',', $game->device);
        return view('content.game.edit', compact('blockchains', 'genres', 'game', 'game_genres', 'game_blockchains', 'device'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => ['mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'genre_ids' => ['required', 'array'],
            'blockchain_ids' => ['required', 'array'],
            'device' => ['required', 'array'],
            'status' => 'required|string',
            'governance_token' => ['nullable','string', new ValidApiId],
            'rewards_token' => ['nullable','string', new ValidApiId],
            'minimum_investment' => ['nullable', 'integer'],
            'f2p' => 'required|string',
            'screenshots.*' => ['mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'short_description' => 'required',
          ],[
            'genre_ids.required' => 'The genre field is Required',
            'blockchain_ids.required' => 'The blockChain field is Required',
          ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['genre_ids'] = implode(',', $request->genre_ids);
            $data['blockchain_ids'] = implode(',', $request->blockchain_ids);
            $data['device'] = implode(',', $request->device);
            if($request->hasFile('image')){
              $photo = $data['image'];
              $new_name = 'image_'  . sha1(time()) . '.' . $photo->getClientOriginalExtension();
              $photo->move(public_path('images/game/image') , $new_name);
              $data['image'] = $new_name;
            }
            if($request->hasFile('screenshots')){
                $i = 1;
                foreach($request->screenshots as $screenshot){
                    $new_name = 'screenshots_'. $i . sha1(time()) . '.' . $screenshot->getClientOriginalExtension();
                    $screenshot->move(public_path('images/game/screenshots') , $new_name);
                    $screenshots[] = $new_name;
                    $i++;
                }
                $data['screenshots'] = implode(',', $screenshots);
            }
            $game->update($data);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Game updated successfully!',
                        'redirect' => route('game.index'),
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
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        try {
            DB::beginTransaction();
            $game->delete();
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Game successfully deleted!'
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

    public function delete(Game $game){
        $action = route('game.destroy', $game->id);
        $title = 'game ' . $game->name;
        return view('layouts.delete', compact('action' , 'title'));
    }

    public function approve(Game $game){
        $action = route('game.approveGame', $game->id);
        $title = 'game ' . $game->name;
        return view('layouts.approve', compact('action' , 'title'));
    }

    public function approveGame(Game $game){
        try {
            DB::beginTransaction();
            $game->update(['is_approved' => 1]);
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Game successfully approved!'
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
