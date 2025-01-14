<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InstructorPlan;
use Session;
use App\PlanSubscribe;
use Auth;
use File;
use Image;
use App\Setting;
use Illuminate\Support\Facades\Http;
use DotenvEditor;
use Spatie\Permission\Models\Role;


class InstructorPlanController extends Controller
{
    
    public function __construct()
    {
    
        $this->middleware('permission:instructor-plan-subscription.view', ['only' => ['index']]);
        $this->middleware('permission:instructor-plan-subscription.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:instructor-plan-subscription.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:instructor-plan-subscription.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = InstructorPlan::get();
        return view('admin.instructor.plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.instructor.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'detail' => 'required',
            'preview_image' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        $input = $request->all();


        $input['type'] = isset($request->type)  ? 1 : 0;
        $input['duration_type'] = isset($request->duration_type)  ? "m" : "d";
        $input['status'] = isset($request->status)  ? 1 : 0;


        $data = InstructorPlan::create($input);

        


        if($file = $request->file('preview_image')) {

            $path = 'images/plan/';

            if(!file_exists(public_path().'/'.$path)) {
                
                $path = 'images/plan/';
                File::makeDirectory(public_path().'/'.$path,0777,true);
            }  


            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/plan/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $image, 72);

            $data->preview_image = $image;
        }

        

        $data->save();

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('subscription/plan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plans = InstructorPlan::find($id);
        return view('admin.instructor.plan.edit',compact('plans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $course = InstructorPlan::findOrFail($id);
        $input = $request->all();

        if (isset($request->type)) {
            $input['type'] = "1";
        } else {
            $input['type'] = "0";
        }

        if (isset($request->duration_type)) {
            $input['duration_type'] = "m";
        } else {
            $input['duration_type'] = "d";
        }

        if (isset($request->status)) {
            $input['status'] = "1";
        } else {
            $input['status'] = "0";
        }


        if ($file = $request->file('image')) {

            $path = 'images/plan/';

            if(!file_exists(public_path().'/'.$path)) {
                
                $path = 'images/plan/';
                File::makeDirectory(public_path().'/'.$path,0777,true);
            }  

            if ($course->preview_image != null) {
                $content = @file_get_contents(public_path() . '/images/plan/' . $course->preview_image);
                if ($content) {
                    unlink(public_path() . '/images/plan/' . $course->preview_image);
                }
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/plan/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $image, 72);

            $input['preview_image'] = $image;
        }

        
        $course->update($input);

        return redirect('subscription/plan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plans = InstructorPlan::find($id);

        if($plans->image != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/plan/'.$plans->image);

            if($image_file)
            {
                unlink(public_path().'/images/plan/'.$plans->image);
            }
        }
        
        $value = $plans->delete();

        if($value)
        {
            session()->flash('delete',trans('flash.DeletedSuccessfully'));
            return redirect('plan/instructor');
        }
    }

    public function planpage()
    {

        $plans = InstructorPlan::get();
        $subscribed = PlanSubscribe::where('user_id', Auth::user()->id)->get();
        $setting = setting::first();
        if($setting->theme == '1'){
        return view('front.plan.view', compact('plans', 'subscribed'));
        }
        return view('theme_2.front.plan.view', compact('plans', 'subscribed'));


    }

    public function checkout(Request $request)
    {
        $plans = InstructorPlan::where('id', $request->plan_id)->first();
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.plan.plan_checkout', compact('plans'));
        }
        return view('theme_2.front.plan.plan_checkout', compact('plans'));

    }



}
