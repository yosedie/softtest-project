<?php

namespace App\Http\Controllers;

use Session;
use App\FaqStudent;
use App\FaqInstructor;
use Illuminate\Http\Request;
use DB;
use App\Setting;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class FaqController extends Controller
{
    public function __construct()
    {
      
    
        $this->middleware('permission:faq.faq-student.view', ['only' => ['index']]);
        $this->middleware('permission:faq.faq-student.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:faq.faq-student.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:faq.faq-student.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq = FaqStudent::orderBy('position','DESC')->get();
        return view('admin.faq.index',compact('faq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq.faq_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'title'=>'required',
            'details'=>'required',
            
        ]);
        
        $input = $request->all();
        $data = FaqStudent::create($input);

        if(isset($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }

        $data->save();
        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect('faq');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $find= FaqStudent::find($id);
        return view('admin.faq.faq_edit', compact('find'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $data = FaqStudent::findorfail($id);
        $input = $request->all();

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }
        
        $data->update($input);
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect('faq'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('faq_students')->where('id',$id)->delete();
        Session::flash('delete', trans('flash.DeletedSuccessfully'));
        return redirect('faq');
    }

     // This function performs bulk delete action
   public function bulk_delete(Request $request)
   {
    
       $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                return back()->with('warning', 'Atleast one item is required to be checked');
               
            }
            else{
                FaqStudent::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }  
    }
    // This function performs status change action
     public function status(Request $request)
     {
         $faq = FaqStudent::find($request->id);
         $faq->status = $request->status;
         $faq->save();
         Session::flash('success', trans('Status has been changed successfully !'));
         return redirect('faq');
     }
     public function reposition(Request $request)
    {

        $data= $request->all();
     
        $posts = FaqStudent::all();
       
        $pos = $data['id'];
        
        $position =json_encode($data);
     
        foreach ($posts as $key => $item) {
        
            FaqStudent::where('id', $item->id)->update(array('position' => $pos[$key]));
        }

        return response()->json(['msg'=>'Updated Successfully', 'success'=>true]);
    }
    public function front()
    {
        $data = FaqStudent::first();
        $item = FaqInstructor::first();
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.help.faq',compact('data', 'item'));
        }
        return view('theme_2.front.help.faq', compact('blogs'));
        }
    
}
