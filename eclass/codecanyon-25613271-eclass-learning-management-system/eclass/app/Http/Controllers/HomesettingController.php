<?php

namespace App\Http\Controllers;

use App\Homesetting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class HomesettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function __construct()
    {
        $this->middleware('permission:homepage-setting.manage', ['only' => ['index','update']]);
    }
    public function index()
    {
        $hsetting = Homesetting::first();
        return view('admin.homepage.setting',compact('hsetting'));
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHomesettingRequest  $request
     * @param  \App\Homesetting  $homesetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        try {

            $hsetting = Homesetting::first();
            if ($hsetting) {
                $hsetting->fact_enable = isset($request->fact_enable) ? 1 : 0;
                $hsetting->discount_enable = isset($request->discount_enable) ? 1 : 0;
                $hsetting->purchase_enable = isset($request->purchase_enable) ? 1 : 0;
                $hsetting->recentcourse_enable = isset($request->recentcourse_enable) ? 1 : 0;
                $hsetting->featured_enable = isset($request->featured_enable) ? 1 : 0;
                $hsetting->bundle_enable = isset($request->bundle_enable) ? 1 : 0;
                $hsetting->bestselling_enable = isset($request->bestselling_enable) ? 1 : 0;
                $hsetting->batch_enable = isset($request->batch_enable) ? 1 : 0;
                $hsetting->livemeetings_enable = isset($request->livemeetings_enable) ? 1 : 0;
                $hsetting->blog_enable = isset($request->blog_enable) ? 1 : 0;
                $hsetting->became_enable = isset($request->became_enable) ? 1 : 0;
                $hsetting->featuredcategories_enable = isset($request->featuredcategories_enable) ? 1 : 0;
                $hsetting->discount_badget_enable = isset($request->discount_badget_enable) ? 1 : 0;
                $hsetting->testimonial_enable = isset($request->testimonial_enable) ? 1 : 0;
                $hsetting->video_enable = isset($request->video_enable) ? 1 : 0;
                $hsetting->instructor_enable = isset($request->instructor_enable) ? 1 : 0;
                $hsetting->trusted_enable = isset($request->trusted_enable) ? 1 : 0;
                $hsetting->newsletter_enable = isset($request->newsletter_enable) ? 1 : 0;
                $hsetting->institute_enable = isset($request->institute_enable) ? 1 : 0;
                $hsetting->get_enable = isset($request->get_enable) ? 1 : 0;
                $hsetting->service_enable = isset($request->service_enable) ? 1 : 0;
                $hsetting->feature_enable = isset($request->feature_enable) ? 1 : 0;
                $hsetting->save();

            } else {

                $hsetting = new Homesetting;
                $hsetting->fact_enable = isset($request->fact_enable) ? 1 : 0;
                $hsetting->discount_enable = isset($request->discount_enable) ? 1 : 0;
                $hsetting->purchase_enable = isset($request->purchase_enable) ? 1 : 0;
                $hsetting->recentcourse_enable = isset($request->recentcourse_enable) ? 1 : 0;
                $hsetting->featured_enable = isset($request->featured_enable) ? 1 : 0;
                $hsetting->bundle_enable = isset($request->bundle_enable) ? 1 : 0;
                $hsetting->bestselling_enable = isset($request->bestselling_enable) ? 1 : 0;
                $hsetting->batch_enable = isset($request->batch_enable) ? 1 : 0;
                $hsetting->livemeetings_enable = isset($request->livemeetings_enable) ? 1 : 0;
                $hsetting->blog_enable = isset($request->blog_enable) ? 1 : 0;
                $hsetting->became_enable = isset($request->became_enable) ? 1 : 0;
                $hsetting->featuredcategories_enable = isset($request->featuredcategories_enable) ? 1 : 0;
                $hsetting->discount_badget_enable = isset($request->discount_badget_enable) ? 1 : 0;
                $hsetting->testimonial_enable = isset($request->testimonial_enable) ? 1 : 0;
                $hsetting->video_enable = isset($request->video_enable) ? 1 : 0;
                $hsetting->instructor_enable = isset($request->instructor_enable) ? 1 : 0;
                $hsetting->trusted_enable = isset($request->trusted_enable) ? 1 : 0;
                $hsetting->newsletter_enable = isset($request->newsletter_enable) ? 1 : 0;
                $hsetting->institute_enable = isset($request->institute_enable) ? 1 : 0;
                $hsetting->get_enable = isset($request->get_enable) ? 1 : 0;
                $hsetting->service_enable = isset($request->service_enable) ? 1 : 0;
                $hsetting->feature_enable = isset($request->feature_enable) ? 1 : 0;
                $hsetting->save();
            }
            return redirect()->route('homepage.setting')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

  
}
