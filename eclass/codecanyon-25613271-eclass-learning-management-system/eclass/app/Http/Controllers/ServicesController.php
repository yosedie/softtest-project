<?php

namespace App\Http\Controllers;

use App\Services;
use App\setting;
use App\Servicesetting;
use Illuminate\Http\Request;
use Image;
use Session;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Services::all();
        return view('admin.service.index',compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServicesRequest  $request
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
          $optimizePath = public_path().'/images/services/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);
          $input['image'] = $image;
          
        }

        $input['created_at']  = \Carbon\Carbon::now()->toDateTimeString();
        $input['updated_at']  = \Carbon\Carbon::now()->toDateTimeString();
        

        $input['status'] = isset($request->status)  ? 1 : 0;

        $data = Services::create($input);
        
        $data->save();

        return redirect('service');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
         $datas = Services::findOrFail($id);
        return view('admin.service.edit',compact('datas'));
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
            "detail" => "required",
         ]);

        $data = Services::findOrFail($id);
        $data['title'] = strip_tags($request->title);
        $data['detail'] = strip_tags($request->detail);
        $data['status'] = isset($request->status)  ? 1 : 0;

        if($file = $request->file('image')) 
        {       
            
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/service/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);
          $data['image'] = $image;
          
        }
        $data->save();
        Session::flash('success', __('flash.AddedSuccessfully'));
        return redirect()->route('service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facts  $facts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Services::findorfail($id);
        $data->delete();
        return back()->with('deleted', 'Service has been deleted !');
    }

    public function front(){
        $serv = Servicesetting::first();
        $services = Services::where('status','1')->get();
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.service',compact('services','serv'));
        }
        return view('theme_2.front.service',compact('services','serv'));

    }
}