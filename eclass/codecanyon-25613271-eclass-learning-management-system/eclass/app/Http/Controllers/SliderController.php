<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Image;
use Auth;
use Session;
use Spatie\Permission\Models\Role;


class SliderController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        abort_if(!auth()->user()->can('front-settings.sliders.view'),403,'User does not have the right permissions.');
        $sliders = Slider::orderBy('position','ASC')->get();
        return view("admin.slider.index",compact("sliders"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('front-settings.sliders.create'),403,'User does not have the right permissions.');
        return view('admin.slider.insert');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('front-settings.sliders.create'),403,'User does not have the right permissions.');
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        
        $data = $this->validate($request,[
            'heading' => 'required',
            'sub_heading' => 'required',
            'search_text' => 'required',
            'detail' => 'required',
            'image'=>'required',
        ]);


        $input = $request->all();


        if(Auth::user()->role == 'admin')
        {
            if ($request->image != null) {

                $input['image'] = $request->image;

            }
        }


        if(Auth::user()->role == 'instructor')
        {

            if($file = $request->file('image')) 
            {        
              $optimizeImage = Image::make($file);
              $optimizePath = public_path().'/images/slider/';
              $image = time().$file->getClientOriginalName();
              $optimizeImage->save($optimizePath.$image, 72);

              $input['image'] = $image;
              
            }
        }


        $input['position'] = (Slider::count()+1);

        $input['status'] = isset($request->status)  ? 1 : 0;
        $input['left'] = isset($request->left)  ? 1 : 0;
        $input['search_enable'] = isset($request->search_enable)  ? 1 : 0;
       

        $data = Slider::create($input);


        
        $data->save();

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('slider');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!auth()->user()->can('front-settings.sliders.view'),403,'User does not have the right permissions.');
        $cate = Slider::find($id);
        return view('admin.slider.update',compact('cate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\slider  $slider
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id)
    {
        abort_if(!auth()->user()->can('front-settings.sliders.edit'),403,'User does not have the right permissions.');
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }

        $slider = Slider::findorfail($id);

        $input = $request->all();


        if(Auth::user()->role == 'admin')
        {
            if ($request->image != null) {

                $input['image'] = $request->image;

            }
            else{
                $input['image'] = $slider->image;
            }
        }

        if(Auth::user()->role == 'instructor')
        {

            if($file = $request->file('image'))
            {
                if($slider->image != null) {
                    $content = @file_get_contents(public_path().'/images/slider/'.$slider->image);
                    if ($content) {
                      unlink(public_path().'/images/slider/'.$slider->image);
                    }
                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path().'/images/slider/';
                $image = time().$file->getClientOriginalName();
                $optimizeImage->save($optimizePath.$image, 72);

                $input['image'] = $image;
            }
        }

        $input['status'] = isset($request->status)  ? 1 : 0;
        $input['left'] = isset($request->left)  ? 1 : 0;
        $input['search_enable'] = isset($request->search_enable)  ? 1 : 0;

       

        $slider->update($input);

        Session::flash('success',trans('flash.UpdatedSuccessfully'));
        return redirect('slider'); 
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\slider  $slider
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        abort_if(!auth()->user()->can('front-settings.sliders.delete'),403,'User does not have the right permissions.');
        $cate = Slider::find($id);

        if ($cate->image != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/slider/'.$cate->image);

            if($image_file)
            {
                unlink(public_path().'/images/slider/'.$cate->image);
            }
        }
        
        $value = $cate->delete();

        if($value)
        {
            session()->flash('delete',trans('flash.DeletedSuccessfully'));
            return redirect('slider');
        }

    }

    public function reposition(Request $request)
    {

        $data= $request->all();
        
        $posts = Slider::all();
        $pos = $data['id'];
       
        $position =json_encode($data);
     
        foreach($posts as $key => $item) {
            
            Slider::where('id', $item->id)->update(array('position' => $pos[$key]));
        }

        return response()->json(['msg'=>'Updated Successfully', 'success'=>true]);


    }
}
