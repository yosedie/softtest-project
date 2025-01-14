<?php

namespace App\Http\Controllers;

use App\Features;
use App\setting;
use App\Featuresetting;
use Illuminate\Http\Request;
use Image;
use Session;

class FeaturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.features.view', ['only' => ['index']]);
        $this->middleware('permission:admin.features.create', ['only' => ['create','store']]);
        $this->middleware('permission:admin.features.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin.features.delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feature = Features::all();
        return view('admin.feature.index',compact('feature'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.feature.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFeaturesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'title'=>'required',
            'detail'=>'required',
            'image'=>'required',
            'image'=>'image|mimes:jpg,jpeg,png,webp',
        ]);


        $input = $request->all();
        if ($file = $request->file('image')) 
        {       
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/feature/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);
          $input['image'] = $image;
          
        }

        $input['created_at']  = \Carbon\Carbon::now()->toDateTimeString();
        $input['updated_at']  = \Carbon\Carbon::now()->toDateTimeString();
        

        $input['status'] = isset($request->status)  ? 1 : 0;

        $data = Features::create($input);
        
        $data->save();

        return redirect('feature');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data = Features::findOrFail($id);
        return view('admin.feature.edit',compact('data'));
    }
    public function show(Features $features)
    {
        //
    }

    
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFeaturesRequest  $request
     * @param  \App\Features  $features
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $data = Features::findOrFail($id);
        $request->validate([
            "title" => "required",
            "detail" => "required",
            

        ]);

        $data['title'] = strip_tags($request->title);
        $data['detail'] = strip_tags($request->detail);
        $data['status'] = isset($request->status)  ? 1 : 0;

        if($file = $request->file('image')) 
        {       
            
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/feature/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);
          $data['image'] = $image;
          
        }


        $data->save();
        Session::flash('success', __('flash.AddedSuccessfully'));
        return redirect()->route('feature.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facts  $facts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Features::findorfail($id);
        $data->delete();
        return back()->with('deleted', 'Feature has been deleted !');
    }
    public function front(){
        $featuresetting = Featuresetting::first();
        $feature = Features::where('status','1')->get();
        $setting = setting::first();
        if($setting->theme == '1'){
        return view('front.feature',compact('feature','featuresetting'));
        }
        return view('theme_2.front.feature',compact('feature','featuresetting'));
    }
}
