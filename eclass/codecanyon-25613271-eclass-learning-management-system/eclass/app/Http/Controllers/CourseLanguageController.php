<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseLanguage;
use DB;
use Session;
use Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class CourseLanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:course-languages.view', ['only' => ['index']]);
        $this->middleware('permission:course-languages.create', ['only' => [ 'store']]);
        $this->middleware('permission:course-languages.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:course-languages.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    public function index()
    {
        $language = CourseLanguage::all();
        return view('admin.course_language.index',compact("language"));
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $data = $this->validate($request,[
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['status'] = isset($request->status)  ? 1 : 0;

        $language = CourseLanguage::where('name','LIKE','%'.$request->name.'%')->first();

        if($language){
            Session::flash('success',trans('flash.Already Exist'));
        } else {
            $data = CourseLanguage::create($input);
            $data->save();

            Session::flash('success',trans('flash.AddedSuccessfully'));
        }

        
        return redirect('courselang');
    }
    
    public function show(language $language)
    {
        
    }

   
    public function edit($id)
    {
        $language = CourseLanguage::where('id',$id)->first();
        return view('admin.course_language.edit',compact("language"));
    }

   
    public function update(Request $request, $id)
    {
        $data = $this->validate($request,[
            'name' => 'required',
           
        ]);
        
        $data = CourseLanguage::findorfail($id);
        $input = $request->all();
        $input['status'] = isset($request->status)  ? 1 : 0;
        $data->update($input);
        Session::flash('success',trans('Update Successfully'));
        return redirect('courselang');
    }

   
    public function destroy( $id)
    {
        
        DB::table('course_languages')->where('id',$id)->delete();
        Session::flash('success',trans('Delete Successfully')); 
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
            CourseLanguage::whereIn('id',$request->checked)->delete();
            
            Session::flash('success',trans('Deleted Successfully'));
            return redirect()->back();
            
        }

          
   }

    public function status(Request $request)
    {

        $courselanguage = CourseLanguage::find($request->id);
        $courselanguage->status = $request->status;
        $courselanguage->save();
        return back()->with('success',trans('flash.UpdatedSuccessfully'));
        
        
    }

}
