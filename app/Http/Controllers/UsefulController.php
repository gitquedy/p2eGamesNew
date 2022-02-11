<?php

namespace App\Http\Controllers;

use App\Models\Useful;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsefulController extends Controller
{
    public function useful(Request $request, Review $review){
        try {
            DB::beginTransaction();
            $user = $request->user();
            $useful = $review->useful->where('user_id', $user->id);

            if($useful->count() == 0){
                // like
                Useful::create([
                    'review_id' => $review->id,
                    'user_id' => $user->id
                ]);
                $addClass = true;
            }else{
                // dislike
                Useful::where([
                    'review_id' => $review->id,
                    'user_id' => $user->id
                ])->delete();
                $addClass = false;
            }

            DB::commit();
            $output = ['success' => 1,
                        'btn' => '#usefulBtn_' . $review->id,
                        'usefulCount' => '#usefulCount_' . $review->id,
                        'addClass' => $addClass,
                        'class' => 'btn-outline-success',
                        'count' => Useful::where('review_id', $review->id)->count(),
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
