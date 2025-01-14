<?php

namespace App\Http\Controllers;

use App\Facts;
use Validator;
use Session;
use Image;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class FactsController extends Controller
{
    public function __construct()
    {
		$this->middleware('permission:front-settings.factsetting.view', ['only' => ['index']]);
        $this->middleware('permission:front-settings.factsetting.create', ['only' => ['create','store']]);
		$this->middleware('permission:front-settings.factsetting.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:front-settings.factsetting.delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facts = Facts::get();
        return view("admin.facts.index",compact("facts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.facts.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFactsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
            "title" => "required",
            "image" => "required",
            "image" => "image|mimes:jpg,jpeg,png,webp",
            "description" => "required",
            "number" => "required",

        ]);
        $fact['title'] = strip_tags($request->title);
        $fact['description'] = strip_tags($request->description);
        $fact['number'] = strip_tags($request->number);
        if($file = $request->file('image')) 
        {       
            
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/facts/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);
          $fact['image'] = $image;
          
        }
        $input['status'] = isset($request->status)  ? 1 : 0;
        Facts::create($fact);
        Session::flash('success', __('flash.AddedSuccessfully'));
        return redirect()->route('fact.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Facts  $facts
     * @return \Illuminate\Http\Response
     */
    public function show(Facts $facts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Facts  $facts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data = Facts::findOrFail($id);
        return view('admin.facts.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFactsRequest  $request
     * @param  \App\Facts  $facts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            "title" => "required",
            "description" => "required",
            "number" => "required",

        ]);

        $data = Facts::findOrFail($id);
        $data['title'] = strip_tags($request->title);
        $data['description'] = strip_tags($request->description);
        $data['number'] = strip_tags($request->number);
        $data['status'] = isset($request->status)  ? 1 : 0;

        if($file = $request->file('image')) 
        {       
            
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/facts/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);
          $data['image'] = $image;
          
        }


        $data->save();
        Session::flash('success', __('flash.AddedSuccessfully'));
        return redirect()->route('fact.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facts  $facts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fact = Facts::findorfail($id);
        $fact->delete();
        return back()->with('deleted', 'Facts has been updated !');
    }
    
}
