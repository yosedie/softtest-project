<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class PageController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:pages.view', ['only' => ['index']]);
        $this->middleware('permission:pages.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pages.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:pages.delete', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::all();
        return view('admin.pages.index',compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.page_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this -> validate($request,[
            'title'=>'required',
            'details'=>'required',
        ]);

        $input = $request->all();
        $input['details'] = clean($request->details);
         $input['slug'] = $request->slug ?? str_slug($input['title'],'-');
        $data = Page::create($input);
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
        return redirect('page');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $find= Page::find($id);
        return view('admin.pages.page_edit', compact('find'));
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
            $this -> validate($request,[
            'title'=>'required',
            'details'=>'required',
            
        ]);

        $data = Page::findorfail($id);
        $input = $request->all();
        $input['slug'] = $request->slug ?? str_slug($input['title'],'-');

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        // $slug = str_slug($input['title'],'-');
        $input['slug'] = $request->slug;
        $data->update($input);
        
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect('page'); 
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        
        DB::table('pages')->where('id',$id)->delete();
        Session::flash('delete', trans('flash.DeletedSuccessfully'));
        return redirect('page');
    }


    public function showpage($slug)
    {
        $page = Page::where('slug', '=', $slug)->first();
        
        return view('page',compact('page'));
    }

   public function status(Request $request)
    {
       $pages = Page::find($request->id);
       $pages->status = $request->status;
       $pages->save();
        return response()->json($request->all());
    
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
                Page::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }
        }
}
