<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilities;
use Auth;
use Validator;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $review = Review::with(['game'])->orderBy('updated_at', 'desc');

            if($request->status != "all"){
                $review->where('status', $request->status);
            }

            if($request->game != "all"){
                $review->where('game_id', $request->game);
            }

            if($request->rating != "all"){
                $review->where('rating', $request->rating);
            }
            return Datatables::eloquent($review)
            ->addColumn('game', function(Review $review) {
                            return $review->game->name;
                        })
            ->addColumn('action', function(Review $review) {
                            return $review->getDropdown();
                        })
            ->addColumn('ratingFormatted', function(Review $review) {
                            return '<p class="card-text"><small><div class="read-only-ratings review-detail-rating" data-rateyo-rating="'. $review->rating .'" data-rateyo-read-only="true"></div></small></p>';
                        })


            ->rawColumns(['action', 'ratingFormatted'])
            ->make(true);
        }
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"],['link'=> route('review.index'), 'name'=>"Reviews"], ['name'=>"List of Reviews"]
        ];
        $games = Game::all();
        return view('admin.review.index', compact('games', 'breadcrumbs'));
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
            'subject' => 'required|string',
            'description' => 'required|string',
            'rating' => 'required|numeric|between:1,5',
            'screenshots.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'game_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        try {
            DB::beginTransaction();
            $data = $request->all();
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
            $data['user_id'] = $request->user()->id;
            Review::create($data);
            Game::syncRank();
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Review submitted successfully! Please wait for admin approval.',
                        'redirect' => route('game.show', $data['game_slug'])
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
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
       return view('admin.review.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    public function destroy(Review $review)
    {
        try {
            DB::beginTransaction();
            $review->delete();
            Game::syncRank();
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Review successfully deleted!',
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
    public function delete(Review $review){
        $action = route('review.destroy', $review->id);
        $title = 'review #' . $review->id;
        return view('layouts.delete', compact('action' , 'title'));
    }

    public function approve(Review $review){
        try {
            DB::beginTransaction();
            $review->update(['status' => true]);
            Game::syncRank();
            DB::commit();
            $output = ['success' => 1,
                        'msg' => 'Review successfully updated!',
                        'table' => 'review_table'
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
