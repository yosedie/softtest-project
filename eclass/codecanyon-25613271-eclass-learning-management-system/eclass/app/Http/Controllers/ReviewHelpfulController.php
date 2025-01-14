<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\ReviewHelpful;

class ReviewHelpfulController extends Controller
{
    public function store(Request $request, $id)
    {
    	$help = ReviewHelpful::where('review_id', $request->review_id)->where('user_id', Auth::user()->id)->first();

        if($request->review_like == '1')
        {
            if(isset($help))
            {

                ReviewHelpful::where('id', $help->id)
                    ->update([
                    'review_like' => '1',
                    'review_dislike' => '0',

                ]);
                

            }
            else{

                $created_review = ReviewHelpful::create([
                        'course_id'   => $id,
                        'user_id'     => Auth::User()->id,
                        'review_id'   => $request->review_id,
                        'helpful'     => $request->helpful,
                        'review_like' => '1'

                    ]
                );

                ReviewHelpful::where('id', $created_review->id)
                    ->update([
                    'review_dislike' => '0',

                ]);

            }
            
        }
        elseif($request->review_dislike == '1')
        {

            if(isset($help))
            {

                ReviewHelpful::where('id', $help->id)
                    ->update([
                    'review_dislike' => '1',
                    'review_like' => '0',

                ]);
                

            }else{

                $created_review = ReviewHelpful::create([
                    'course_id'   => $id,
                    'user_id'     => Auth::User()->id,
                    'review_id'   => $request->review_id,
                    'helpful'     => $request->helpful,
                    'review_dislike' => '1'

                    ]
                );

                ReviewHelpful::where('id', $created_review->id)
                    ->update([
                    'review_like' => '0',

                ]);

            }
            

        }
        elseif($help->review_like == '1')
        {
             ReviewHelpful::where('id', $help->id)
                ->update([
                'review_like' => '0',

            ]);

        }
        elseif($help->review_dislike == '1')
        {
             ReviewHelpful::where('id', $help->id)
                ->update([
                'review_dislike' => '0',

            ]);

        }

        return back();
    }



    public function destroy($id)
    {
        DB::table('review_helpfuls')->where('course_id',$id)->delete();
        return back();
    }
}
