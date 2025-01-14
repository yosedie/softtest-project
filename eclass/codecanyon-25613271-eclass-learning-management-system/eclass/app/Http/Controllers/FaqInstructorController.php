<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FaqInstructor;
use DB;
use Illuminate\Support\Facades\Validator;
use Session;
use Spatie\Permission\Models\Role;

class FaqInstructorController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:faq.faq-instructor.view', ['only' => ['index']]);
        $this->middleware('permission:faq.faq-instructor.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:faq.faq-instructor.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:faq.faq-instructor.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    public function index()
    {
        $faq = FaqInstructor::orderBy('position')->get();
        return view('admin.faq_instructor.index',compact('faq'));
    }

    public function create()
    {
    	return view('admin.faq_instructor.create');
    }

    public function store(Request $request)
    {
    	$data = $this->validate($request,[
            'title'=>'required',
            'details'=>'required',
        ]);

        
        $input = $request->all();
        $data = FaqInstructor::create($input);

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
        return redirect('faqinstructor');

    }

    public function show()
    {

    }

    public function edit($id)
    {
    	$find= FaqInstructor::find($id);
        return view('admin.faq_instructor.update', compact('find'));
    }

    public function update(Request $request, $id)
    {
    	$data = FaqInstructor::findorfail($id);
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
        return redirect('faqinstructor');
    }

    public function destroy($id)
    {
    	DB::table('faq_instructors')->where('id',$id)->delete();
    	Session::flash('delete', trans('flash.DeletedSuccessfully'));
        return redirect('faqinstructor');
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
                FaqInstructor::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }  
  }

     // this method is used to change status
    public function status(Request $request)
    {
        $faqinstructor = FaqInstructor::find($request->id);
        $faqinstructor->status = $request->status;
        $faqinstructor->save();
        Session::flash('success', trans('Status has been changed successfully !'));
        return redirect('faqinstructor');
    }

    public function reposition(Request $request)
    {

        $data= $request->all();
        
        $posts = FaqInstructor::all();
        $pos = $data['id'];
       
        $position =json_encode($data);
     
        foreach ($posts as $key => $item) {
            
            FaqInstructor::where('id', $item->id)->update(array('position' => $pos[$key]));
        }

        return response()->json(['msg'=>'Updated Successfully', 'success'=>true]);


    }
}
