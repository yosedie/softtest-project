<?php

namespace App\Http\Controllers;

use App\Followers;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use Alert;
use Spatie\Permission\Models\Role;


class FollowersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    
        $this->middleware('permission:followers.manage', ['only' => ['follow','index']]);
 
    }
    public function follow(Request $request)
    {

        $auth = Auth::user();

        if(Auth::check())
        {
            if($auth->id != $request->follower_id)
            {
                
                $follower = Followers::create([
                    'user_id' => $auth->id,
                    'follower_id' => $request->follower_id,
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]);

                Session::flash('success',trans('flash.UpdatedSuccessfully'));
                return back();
            }
            else
            {
               
                Session::flash('delete',trans('flash.UnauthorizedAction'));
                return back();
            }
        }
        else
        {
           
            return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
        }
        
    }

    public function unfollow(Request $request)
    {
        if(Auth::check())
        {
            $follower = Followers::where('user_id', Auth::user()->id )->where('follower_id', $request->instructor_id)->delete();
            return redirect()->back();
        }
        else
        {
            return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
        }
    }


    public function index(Request $request)
    {
        $followers = Followers::where('user_id', '!=', auth::user()->id)->where('follower_id', auth::user()->id)->get();

        $followings = Followers::where('user_id', auth::user()->id)->where('follower_id','!=', auth::user()->id)->get();

        return view('admin.follower.show', compact('followers', 'followings'));
    }

    
}
