<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Session;

class UserActivityController extends Controller
{
    public function index()
    {
    	$lastActivity = Activity::orderBy('id', 'DESC')->get();

    	return view('admin.user_activity.index', compact('lastActivity'));

    }

    public function delete($id)
    {
    	Activity::where('id',$id)->delete(); 
        return back();
    }
    public function bulk_delete(Request $request)
    {
        
     
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with('warning', 'Atleast one item is required to be checked');
           
        }
        else{
            Activity::whereIn('id',$request->checked)->delete();
            
            Session::flash('success',trans('Deleted Successfully'));
            return redirect()->back();
            
        }

          
   }
}
