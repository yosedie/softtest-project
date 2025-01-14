<?php

namespace App\Http\Controllers;

use Auth;
use App\Involvement;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class InvolvementController extends Controller
{
    
    public function __construct()
    {
    
        $this->middleware('permission:involvement.view', ['only' => ['index','show']]);
        $this->middleware('permission:involvement.create', ['only' => ['store']]);
        $this->middleware('permission:involvement.edit', ['only' => ['update']]);
        $this->middleware('permission:involvement.delete', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $involve_requests = Involvement::all();

        return view('instructor.involverequest.index', compact('involve_requests'));
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
    public function store(Request $request,$id)
    {
         $request->validate([
          'reason' => 'required',
        
        ]);

          $input = $request->all();
          $input['user_id']= $request->instructor_id;
          $input['status'] = 0;
          $data = Involvement::create($input); 
        return back()->with('success','Involvement request successfully submited!');
           
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Involvement  $involvement
     * @return \Illuminate\Http\Response
     */
    public function show(Involvement $involvement)
    {
        $involve_requests = Involvement::where('status',1)->where('user_id',Auth::user()->id)->get();
        return view('instructor.involverequest.applycourse',compact('involve_requests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Involvement  $involvement
     * @return \Illuminate\Http\Response
     */
    public function edit(Involvement $involvement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Involvement  $involvement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Involvement $id)
    {
        $id->update(['status'=> 1 ]);

        return back()->with('success',trans('flash.RequestAccepted'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Involvement  $involvement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Involvement $id)
    {
        $id->delete();

        return back()->with('delete', trans('flash.DeletedSuccessfully'));
    }
}
