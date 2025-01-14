<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CourseLanguage;
use App\Course;
use App\Order;
use App\Question;
use App\Answer;
use App\Meeting;
use App\BBL;
use App\Blog;
use Auth;
use App\CompletedPayout;
use Validator;
use App\Categories;
use App\SubCategory;
use App\ChildCategory;
use Image;
use DB;
use File;
use App\Cart;
use App\RefundPolicy;
use App\CourseInclude;
use App\WhatLearn;
use App\CourseChapter;
use App\Subtitle;
use App\CourseClass;
use Illuminate\Support\Facades\Hash;
use App\RefundCourse;
use App\Assignment;
use App\Involvement;
use App\Announcement;
use App\ReportReview;
use App\QuizTopic;
use App\RelatedCourse;
use App\Appointment;
use App\PreviousPaper;
use App\ReviewRating;
use App\Institute;
use App\User;
use App\Instructor;
use Mail;
use App\JitsiMeeting;
use App\Mail\UserAppointment;
use App\QuizAnswer;
use App\FeatureCourse;
use App\FeaturePayment;
use App\Setting;
use App\Currency;
use App\BundleCourse;
use App\CourseProgress;
use App\InstructorSetting;

class InstructorApiController extends Controller
{

    public function getAlllanguage(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }


        $language = CourseLanguage::get();

        $result = array();

        foreach ($language as $data) {

            $result[] = array(
                'id' => $data->id,
                'name' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('name')),
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('language'=>$result));

    }

    public function getlanguage(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (CourseLanguage::where('id', $id)->exists()) {

            $language = CourseLanguage::first();

            $result = array();

            $result[] = array(
                'id' => $language->id,
                'name' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $language->getTranslations('name')),
                'status' => $language->status,
                'created_at' => $language->created_at,
                'updated_at' => $language->updated_at,
            );


            return response()->json(array('language'=>$result));

        } else {
            return response()->json([
              "message" => "language not found"
            ], 404);
        }

    }

    public function createlanguage(Request $request) {


        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $language = new CourseLanguage;
        $language->name = $request->name;
        $language->status = isset($request->status)  ? 1 : 0;
        $language->save();

        return response()->json([
            "message" => "language created",
            'language'=>$language
        ]);
    }

    public function updatelanguage(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (CourseLanguage::where('id', $id)->exists()) {
            $language = CourseLanguage::find($id);

            $language->name = isset($request->name) ? $request->name : $language->name;
            $language->status = isset($request->status) ? $request->status : $language->status;
            $language->save();

            return response()->json([
              "message" => "records updated successfully",
              'language'=>$language
            ]);
        } else {
            return response()->json([
              "message" => "language not found"
            ], 404);
        }
    }


    public function deletelanguage(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(CourseLanguage::where('id', $id)->exists()) {
            $language = CourseLanguage::find($id);
            $language->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "language not found"
            ], 404);
        }
    }


    public function dashboard(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        $auth = Auth::user();
        $course_count = Course::where('user_id', $auth->id)->where('status', '1')->count();
        $featured_course_count = Course::where('user_id', $auth->id)->where('status', '1')->where('featured', '1')->count();
        $enrolled_user = Order::where('instructor_id', $auth->id)->where('status', '1')->count();
        $question = Question::where('instructor_id',  $auth->id)->where('status', '1')->count();
        $answer = Answer::where('instructor_id',  $auth->id)->where('status', '1')->count();
        $blog = Blog::where('user_id', $auth->id)->where('status', '1')->count();
        $zoom_meeting = Meeting::where('owner_id', $auth->id)->count();
        $bigblue_meeting = BBL::where('instructor_id', $auth->id)->count();
        $jitsi_meet = JitsiMeeting::where('owner_id', $auth->id)->count();


        $userenroll_chart = array(
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '01')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //January
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '02')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //Feb
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '03')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //March
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '04')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //April
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '05')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //May
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '06')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //June
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '07')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //July
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '08')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //August
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '09')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //September
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '10')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //October
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '11')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //November
            Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '12')->where('status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //December
        );


        $payout_chart = array(
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '01')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //January
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '02')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //Feb
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '03')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //March
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '04')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //April
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '05')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //May
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '06')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //June
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '07')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //July
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '08')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //August
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '09')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //September
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '10')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //October
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '11')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //November
            CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '12')->where('pay_status', '1')
                ->whereYear('created_at', date('Y'))
                ->count(), //December
        );


        return response()->json(array(

            'course_count'=>$course_count, 
            'featured_course_count' => $featured_course_count,
            'enrolled_user_count'=>$enrolled_user, 
            'questions_count'=>$question, 
            'answer_count'=>$answer, 
            'blog_count'=>$blog, 
            'zoomm_meeting_count'=>$zoom_meeting, 
            'bigblue_meeting_count'=>$bigblue_meeting, 
            'userenroll_chart'=>$userenroll_chart,
            'payout_chart'=>$payout_chart, 

            ), 
        200);
    }


    public function getAllcategory(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $categories = Categories::get();

        $result = array();

        foreach ($categories as $category) {

            $result[] = array(
                'id' => $category->id,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $category->getTranslations('title')),
                'icon' => $category->icon,
                'slug' => $category->slug,
                'status' => $category->status,
                'featured' => $category->featured,
                'image' => $category->cat_image,
                'imagepath' =>  url('images/category/'.$category->cat_image),
                'position' => $category->position,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            );
        }

        return response()->json(array('category'=>$result), 200); 
    }

    public function getcategory(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Categories::where('id', $id)->exists()) {
            $category = Categories::where('id', $id)->first();

            $result = array();

            $result[] = array(
                'id' => $category->id,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $category->getTranslations('title')),
                'icon' => $category->icon,
                'slug' => $category->slug,
                'status' => $category->status,
                'featured' => $category->featured,
                'image' => $category->cat_image,
                'imagepath' =>  url('images/category/'.$category->cat_image),
                'position' => $category->position,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            );


            return response()->json(array('category'=>$result), 200);
        } else {
            return response()->json([
              "message" => "category not found"
            ], 404);
        }

    }

    public function createcategory(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $this->validate($request,[
            "title" => "required|unique:categories,title",
            "title.required" => "Please enter category title !",
            "title.unique" => "This Category name is already exist !",
            "image" => "required",
            "slug" => "required",
            "icon" => "required",
            "status" => "required",
            "featured" => "required",
        ]);

        $category = new Categories;

        $category['position'] = (Categories::count()+1);

        if($file = $request->file('image')) 
        { 
          
          $path = 'images/category/';

          if(!file_exists(public_path().'/'.$path)) {
            
            $path = 'images/category/';
            File::makeDirectory(public_path().'/'.$path,0777,true);
          }    
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/category/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);

          $category['cat_image'] = $image;
          
        }


        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->icon = $request->icon;
        $category->status = isset($request->status)  ? 1 : 0;
        $category->featured = isset($request->featured)  ? 1 : 0;
        $category->save();

        return response()->json([
            "message" => "category created"
        ], 201);
    }

    public function updatecategory(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Categories::where('id', $id)->exists()) {
            $category = Categories::find($id);


            if($file = $request->file('image'))
            {

                $path = 'images/category/';

                if(!file_exists(public_path().'/'.$path)) {
                  
                  $path = 'images/category/';
                  File::makeDirectory(public_path().'/'.$path,0777,true);
                }   

                if($category->cat_image != null) {
                    $content = @file_get_contents(public_path().'/images/category/'.$category->cat_image);
                    if ($content) {
                      unlink(public_path().'/images/category/'.$category->cat_image);
                    }
                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path().'/images/category/';
                $image = time().$file->getClientOriginalName();
                $optimizeImage->save($optimizePath.$image, 72);

                $category['cat_image'] = $image;
            }

            $category->title = isset($request->title) ? $request->title : $category->title;
            $category->slug = isset($request->slug) ? $request->slug : $category->slug;
            $category->icon = isset($request->icon) ? $request->icon : $category->icon;
            $category->status = isset($request->status) ? $request->status : $category->status;
            $category->featured = isset($request->featured) ? $request->featured : $category->featured;
            $category->save();

       

            return response()->json([
              "message" => "records updated successfully", 'category'=>$category
            ], 200);

            return response()->json(array('category'=>$result), 200);
        } else {
            return response()->json([
              "message" => "category not found"
            ], 404);
        }
    }


    public function deletecategory(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(Categories::where('id', $id)->exists()) {
            $category = Categories::find($id);

            if ($category->image != null)
            {
                    
                $image_file = @file_get_contents(public_path().'/images/category/'.$category->image);

                if($image_file)
                {
                    unlink(public_path().'/images/category/'.$category->image);
                }
            }

            $category->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "Category not found"
            ], 404);
        }
    }

    public function getAllsubcategory(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $categories = SubCategory::get();

        $result = array();

        foreach ($categories as $category) {

            $result[] = array(
                'id' => $category->id,
                'category_id' => $category->category_id,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $category->getTranslations('title')),
                'icon' => $category->icon,
                'slug' => $category->slug,
                'status' => $category->status,
                'featured' => $category->featured,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            );
        }

        return response()->json(array('category'=>$result), 200); 
    }

    public function getsubcategory(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Categories::where('id', $id)->exists()) {
            $category = SubCategory::where('id', $id)->first();

            $result = array();

            $result[] = array(
                'id' => $category->id,
                'category_id' => $category->category_id,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $category->getTranslations('title')),
                'icon' => $category->icon,
                'slug' => $category->slug,
                'status' => $category->status,
                'featured' => $category->featured,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            );


            return response()->json(array('category'=>$result), 200);
        } else {
            return response()->json([
              "message" => "category not found"
            ], 404);
        }

    }

    public function createsubcategory(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $this->validate($request,[
            "title" => "required|unique:categories,title",
            "title.required" => "Please enter category title !",
            "title.unique" => "This Category name is already exist !",
            "slug" => "required",
            "icon" => "required",
            "status" => "required",
        ]);

        $category = new SubCategory;

        $category->category_id = $request->category_id;
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->icon = $request->icon;
        $category->status = isset($request->status)  ? 1 : 0;
        $category->save();

        return response()->json([
          "message" => "category created", 'subcategory'=>$category
        ], 200);
    }

    public function updatesubcategory(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        if (SubCategory::where('id', $id)->exists()) {
            $category = SubCategory::find($id);


          
            $category->category_id = isset($request->category_id) ? $request->category_id : $category->category_id;
            $category->title = isset($request->title) ? $request->title : $category->title;
            $category->slug = isset($request->slug) ? $request->slug : $category->slug;
            $category->icon = isset($request->icon) ? $request->icon : $category->icon;
            $category->status = isset($request->status) ? $request->status : $category->status;
            $category->save();

       

            return response()->json([
              "message" => "records updated successfully", 'subcategory'=>$category
            ], 200);

        } else {
            return response()->json([
              "message" => "category not found"
            ], 404);
        }
    }


    public function deletesubcategory(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        if(SubCategory::where('id', $id)->exists()) {
            $category = SubCategory::find($id);

            $category->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "Category not found"
            ], 404);
        }
    }


    public function getAllchildcategory(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $categories = ChildCategory::get();

        $result = array();

        foreach ($categories as $category) {

            $result[] = array(
                'id' => $category->id,
                'category_id' => $category->category_id,
                'subcategory_id' => $category->subcategory_id,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $category->getTranslations('title')),
                'icon' => $category->icon,
                'slug' => $category->slug,
                'status' => $category->status,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            );
        }

        return response()->json(array('childcategory'=>$result), 200); 
    }

    public function getchildcategory(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (ChildCategory::where('id', $id)->exists()) {
            $category = ChildCategory::where('id', $id)->first();

            $result = array();

            $result[] = array(
                'id' => $category->id,
                'category_id' => $category->category_id,
                'subcategory_id' => $category->subcategory_id,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $category->getTranslations('title')),
                'icon' => $category->icon,
                'slug' => $category->slug,
                'status' => $category->status,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            );


            return response()->json(array('childcategory'=>$result), 200);
        } else {
            return response()->json([
              "message" => "category not found"
            ], 404);
        }

    }

    public function createchildcategory(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $this->validate($request,[
            "title" => "required|unique:categories,title",
            "title.required" => "Please enter category title !",
            "title.unique" => "This Category name is already exist !",
            "slug" => "required",
            "icon" => "required",
            "status" => "required",
        ]);

        $category = new ChildCategory;

        $category->category_id = $request->category_id;
        $category->subcategory_id = $request->subcategory_id;
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->icon = $request->icon;
        $category->status = $request->status;
        $category->save();

       

        return response()->json([
              "message" => "category created", 'childcategory'=>$category
            ], 200);


        return response()->json(array('category'=>$result), 200);
    }

    public function updatechildcategory(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (ChildCategory::where('id', $id)->exists()) {
            $category = ChildCategory::find($id);


          
            $category->category_id = isset($request->category_id) ? $request->category_id : $category->category_id;
            $category->subcategory_id = isset($request->subcategory_id) ? $request->subcategory_id : $category->subcategory_id;
            $category->title = isset($request->title) ? $request->title : $category->title;
            $category->slug = isset($request->slug) ? $request->slug : $category->slug;
            $category->icon = isset($request->icon) ? $request->icon : $category->icon;
            $category->status = isset($request->status) ? $request->status : $category->status;
            $category->save();

       

            return response()->json([
              "message" => "records updated successfully", 'childcategory'=>$category
            ], 200);

        } else {
            return response()->json([
              "message" => "category not found"
            ], 404);
        }
    }

    public function deletechildcategory(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        if(ChildCategory::where('id', $id)->exists()) {
            $category = ChildCategory::find($id);

            $category->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "Category not found"
            ], 404);
        }
    }



    public function getAllcourse(Request $request) {

        // return $request;

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }


        $user = Auth::user();

        $courses = course::where('user_id', $user->id)->get();

        $result = array();

        foreach ($courses as $course) {

            $result[] = array(
                'id' => $course->id,
                'subcategory_id' => $course->subcategory_id,
                'category_id' => $course->category_id,
                'childcategory_id' => $course->childcategory_id,
                'language_id' => $course->language_id,
                'user_id' => $course->user_id,
                'user' => optional($course->user)['fname'] . ' ' . optional($course->user)['lname'],
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $course->getTranslations('title')),
                'short_detail' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $course->getTranslations('short_detail')),
                'requirement' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $course->getTranslations('requirement')),
                'detail' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $course->getTranslations('detail')),
                'price' => $course->price,
                'discount_price' => $course->discount_price,
                'day' => $course->day,
                'video' => $course->video,
                'video_path' => url('video/preview/'.$course->video),
                'video_url' => $course->video_url,
                'url' => $course->url,
                'featured' => $course->featured,
                'status' => $course->status,
                'slug' => $course->slug,
                'duration' => $course->duration,
                'duration_type' => $course->duration_type,
                'instructor_revenue' => $course->instructor_revenue,
                'involvement_request' => $course->involvement_request,
                'refund_policy_id' => $course->refund_policy_id,
                'assignment_enable' => $course->assignment_enable,
                'appointment_enable' => $course->appointment_enable,
                'certificate_enable' => $course->certificate_enable,
                'course_tags' => $course->course_tags,
                'level_tags' => $course->level_tags,
                'preview_image' => $course->preview_image,
                'imagepath' =>  url('images/course/'.$course->preview_image),
                'course_tags' => $course->course_tags,
                'level_tags' => $course->level_tags,
                'reject_txt' => preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode( $course->reject_txt))),
                'drip_enable' => $course->drip_enable,
                'preview_type' => $course->preview_type,
                'updated_at' => $course->created_at,
            );
        }

        return response()->json(array('course'=>$result), 200); 
    }

    public function getcourse(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $user = Auth::user();

        if (Course::where('id', $id)->where('user_id', $user->id)->first()) {

            if (Course::where('id', $id)->exists()) {
                $course = Course::where('id', $id)->first();

                $result = array();

                $result[] = array(
                    'id' => $course->id,
                    'subcategory_id' => $course->subcategory_id,
                    'category_id' => $course->category_id,
                    'childcategory_id' => $course->childcategory_id,
                    'language_id' => $course->language_id,
                    'user_id' => $course->user_id,
                    'user' => optional($course->user)['fname'] . ' ' . optional($course->user)['lname'],
                    'title' => array_map(function ($lang) {
                                    return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                                }, $course->getTranslations('title')),
                    'short_detail' => array_map(function ($lang) {
                                    return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                                }, $course->getTranslations('short_detail')),
                    'requirement' => array_map(function ($lang) {
                                    return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                                }, $course->getTranslations('requirement')),
                    'detail' => array_map(function ($lang) {
                                    return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                                }, $course->getTranslations('detail')),
                    'price' => $course->price,
                    'discount_price' => $course->discount_price,
                    'day' => $course->day,
                    'video' => $course->video,
                    'video_path' => url('video/preview/'.$course->video),
                    'video_url' => $course->video_url,
                    'url' => $course->url,
                    'featured' => $course->featured,
                    'status' => $course->status,
                    'slug' => $course->slug,
                    'duration' => $course->duration,
                    'duration_type' => $course->duration_type,
                    'instructor_revenue' => $course->instructor_revenue,
                    'involvement_request' => $course->involvement_request,
                    'refund_policy_id' => $course->refund_policy_id,
                    'assignment_enable' => $course->assignment_enable,
                    'appointment_enable' => $course->appointment_enable,
                    'certificate_enable' => $course->certificate_enable,
                    'course_tags' => $course->course_tags,
                    'level_tags' => $course->level_tags,
                    'preview_image' => $course->preview_image,
                    'imagepath' =>  url('images/course/'.$course->preview_image),
                    'course_tags' => $course->course_tags,
                    'level_tags' => $course->level_tags,
                    'reject_txt' => preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode( $course->reject_txt))),
                    'drip_enable' => $course->drip_enable,
                    'preview_type' => $course->preview_type,
                    'updated_at' => $course->created_at,
                );


                return response()->json(array('course'=>$result), 200);
            } else {
                return response()->json([
                  "message" => "course not found"
                ], 404);
            }
        }

        else {
            return response()->json([
              "message" => "Invalid Access"
            ], 404);
        }

    }

    public function createcourse(Request $request) {


        // return $request;

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }



         $validator = Validator::make($request->all(), [
            "title" => "required",
            "title.required" => "Please enter course title !",
            "category_id" => "required",
            "subcategory_id" => "required",
            "language_id" => "required",
            "user_id" => "required",
            'video' => 'mimes:mp4,avi,wmv',
            'slug' => 'required|unique:courses,slug',
        ]);




        // return $request;

        $input = $request->all();

        $data = Course::create($input); 

        if(isset($request->type))
        {
          $data->type = "1";
        }
        else
        {
          $data->type = "0";
        }


        if($file = $request->file('preview_image')) 
        {        
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/course/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);

          $data->preview_image = $image;
          
        }

        $data->drip_enable = isset($request->drip_enable)  ? 1 : 0;


        if(isset($request->preview_type))
        {
          $data->preview_type = "video";
        }
        else
        {
          $data->preview_type = "url";
        }

        if(isset($request->duration_type))
        {
          $data->duration_type = "m";
        }
        else
        {
          $data->duration_type = "d";
        }

        if(isset($request->involvement_request))
        {
          $data->involvement_request = "1";
        }
        else
        {
          $data->involvement_request = "0";
        }

        if(isset($request->assignment_enable))
        {
          $data->assignment_enable = "1";
        }
        else
        {
          $data->assignment_enable = "0";
        }

        if(isset($request->appointment_enable))
        {
          $data->appointment_enable = "1";
        }
        else
        {
          $data->appointment_enable = "0";
        }

        if(isset($request->certificate_enable))
        {
          $data->certificate_enable = "1";
        }
        else
        {
          $data->certificate_enable = "0";
        }

                    
        if(!isset($request->preview_type))
        {
            $data->url = $request->url;
        }
        else if($request->preview_type )
        {
            if($file = $request->file('video'))
            {
                
              $filename = time().$file->getClientOriginalName();
              $file->move('video/preview',$filename);
              $data->video = $filename;
            }
        }
        

        $data->save();

        return response()->json([
            "message" => "Course created",

            'course'=>$data
        ]);
    }

    public function updatecourse(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Course::where('id', $id)->exists()) {
            $course = Course::findOrFail($id);
            $input = $request->all();
               
            

            if(isset($request->type))
            {
              $input['type'] = "1";
            }
            else
            {
              $input['type'] = "0";
            }

            
            if ($file = $request->file('image')) {
              
              if($course->preview_image != null) {
                $content = @file_get_contents(public_path().'/images/course/'.$course->preview_image);
                if ($content) {
                  unlink(public_path().'/images/course/'.$course->preview_image);
                }
              }

              $optimizeImage = Image::make($file);
              $optimizePath = public_path().'/images/course/';
              $image = time().$file->getClientOriginalName();
              $optimizeImage->save($optimizePath.$image, 72);

              $input['preview_image'] = $image;
              
            }

            $input['drip_enable'] = isset($request->drip_enable)  ? 1 : 0;


            if(isset($request->preview_type))
            {
              $input['preview_type'] = "video";
            }
            else
            {
              $input['preview_type'] = "url";
            }

            if(isset($request->duration_type))
            {
              $input['duration_type'] = "m";
            }
            else
            {
              $input['duration_type'] = "d";
            }

            if(isset($request->involvement_request))
            {
              $input['involvement_request'] = "1";
            }
            else
            {
              $input['involvement_request'] = "0";
            }

            if(isset($request->assignment_enable))
            {
              $input['assignment_enable'] = "1";
            }
            else
            {
              $input['assignment_enable'] = "0";
            }

            if(isset($request->appointment_enable))
            {
              $input['appointment_enable'] = "1";
            }
            else
            {
              $input['appointment_enable'] = "0";
            }

            if(isset($request->certificate_enable))
            {
              $input['certificate_enable'] = "1";
            }
            else
            {
              $input['certificate_enable'] = "0";
            }

            
            if(!isset($request->preview_type))
            {
                $course->url = $request->video_url;
                $course->video = null;
                
            }
            else if($request->preview_type )
            {
                if($file = $request->file('video'))
                {
                  if($course->video != "")
                  {
                    $content = @file_get_contents(public_path().'/video/preview/'.$course->video);
                    if ($content) {
                      unlink(public_path().'/video/preview/'.$course->video);
                    }
                  }
                  
                  $filename = time().$file->getClientOriginalName();
                  $file->move('video/preview',$filename);
                  $input['video'] = $filename;
                  $course->url = null;

                }
            }

           

            Cart::where('course_id', $id)
             ->update([
                 'price' => $request->price,
                 'offer_price' => $request->discount_price,
              ]);


            $course->update($input);

       

            return response()->json([
              "message" => "records updated successfully", 'course'=>$course
            ], 200);

        } else {
            return response()->json([
              "message" => "course not found"
            ], 404);
        }
    }


    public function deletecourse(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(Categories::where('id', $id)->exists()) {
            $course = Categories::find($id);

            if ($course->image != null)
            {
                    
                $image_file = @file_get_contents(public_path().'/images/course/'.$course->image);

                if($image_file)
                {
                    unlink(public_path().'/images/course/'.$course->image);
                }
            }

            $course->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "course not found"
            ], 404);
        }
    }


    public function getAllrefundpolicy(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $policies = RefundPolicy::get();

        $result = array();

        foreach ($policies as $policy) {

            $result[] = array(
                'id' => $policy->id,
                'name' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $policy->getTranslations('name')),
                'detail' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $policy->getTranslations('detail')),
                'amount' => $policy->amount,
                'days' => $policy->days,
                'status' => $policy->status,
                'created_at' => $policy->created_at,
                'updated_at' => $policy->updated_at,
            );
        }

        return response()->json(array('refundpolicies'=>$result), 200); 
    }


     public function instructorprofileupdate(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $auth = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$auth->id,
        ]);


        if(config('app.demolock') == 0){

            $input = $request->all();
          

            if($file = $request->file('user_img')) {

                if($auth->user_img != null) {
                  $content = @file_get_contents(public_path().'/images/user_img/'.$auth->user_img);
                    if ($content) {
                    unlink(public_path().'/images/user_img/'.$auth->user_img);
                    }
                }

              $optimizeImage = Image::make($file);
              $optimizePath = public_path().'/images/user_img/';
              $image = time().$file->getClientOriginalName();
              $optimizeImage->save($optimizePath.$image, 72);
              $input['user_img'] = $image;
            
            }


            $verified = \Carbon\Carbon::now()->toDateTimeString();


            if(isset($request->password)){
            
                $input['password'] = Hash::make($request->password);
            }
            else{
                $input['password'] = $auth->password;
            }


            $input['email_verified_at'] = isset($request->email_verified_at) ? $request->email_verified_at : $auth->email_verified_at;
            $input['status'] = isset($request->status) ? $request->status : $auth->status;

            $auth->update($input);


          return response()->json(array('profile' =>$auth), 200);
        } 
        else {
          return response()->json('error: password doesnt match', 400);
        }

        
    } 


    public function getAllorder(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }


        $user = Auth::user();

        $enroll = Order::where('instructor_id', $user->id)->where('status', 1)->get();

        $enroll_details = array();

        if(isset($enroll)){
        
            foreach ($enroll as $enrol) {


                $enroll_details[] = array(

                    'id' => $enrol->id,
                    'instructor_id' => $enrol->instructor_id,
                    'user_id' => $enrol->user_id,
                    'user' => optional($enrol->user)['fname'] . ' ' . optional($enrol->user)['lname'],
                    'course_id' => $enrol->courses->title,
                    'order_id' => $enrol->order_id,
                    'transaction_id' => $enrol->transaction_id,
                    'payment_method' => $enrol->payment_method,
                    'total_amount' => $enrol->total_amount,
                    'coupon_discount' => $enrol->coupon_discount,
                    'currency' => $enrol->currency,
                    'currency_icon' => $enrol->currency_icon,
                    'duration' => $enrol->duration,
                    'enroll_start' => $enrol->enroll_start,
                    'enroll_expire' => $enrol->enroll_expire,
                    'bundle_course_id' => $enrol->bundle_course_id,
                    'bundle_id' => $enrol->bundle_id,
                    'proof' => $enrol->proof,
                    'sale_id' => $enrol->sale_id,
                    'refunded' => $enrol->refunded,
                    'price_id' => $enrol->price_id,
                    'subscription_id' => $enrol->subscription_id,
                    'customer_id' => $enrol->customer_id,
                    'subscription_status' => $enrol->subscription_status,
                    'status' => $enrol->status,
                    'created_at' => $enrol->created_at,
                    'updated_at' => $enrol->updated_at,

                );

            }
            return response()->json(array('enroll_details' =>$enroll_details), 200);
        }

        return response()->json(array('enroll_details' =>$enroll_details), 200);

    }

    public function getorder(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Order::where('id', $id)->exists()) {
            $enrol = Order::where('id', $id)->first();

            $result = array();

            $result[] = array(

                'id' => $enrol->id,
                'instructor_id' => $enrol->instructor_id,
                'user_id' => $enrol->user_id,
                'user' => optional($enrol->user)['fname'] . ' ' . optional($enrol->user)['lname'],
                'course_id' => $enrol->courses->title,
                'order_id' => $enrol->order_id,
                'transaction_id' => $enrol->transaction_id,
                'payment_method' => $enrol->payment_method,
                'total_amount' => $enrol->total_amount,
                'coupon_discount' => $enrol->coupon_discount,
                'currency' => $enrol->currency,
                'currency_icon' => $enrol->currency_icon,
                'duration' => $enrol->duration,
                'enroll_start' => $enrol->enroll_start,
                'enroll_expire' => $enrol->enroll_expire,
                'bundle_course_id' => $enrol->bundle_course_id,
                'bundle_id' => $enrol->bundle_id,
                'proof' => $enrol->proof,
                'sale_id' => $enrol->sale_id,
                'refunded' => $enrol->refunded,
                'price_id' => $enrol->price_id,
                'subscription_id' => $enrol->subscription_id,
                'customer_id' => $enrol->customer_id,
                'subscription_status' => $enrol->subscription_status,
                'status' => $enrol->status,
                'created_at' => $enrol->created_at,
                'updated_at' => $enrol->updated_at,

            );


            return response()->json(array('data'=>$result), 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }

    public function createorder(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $subscription_status=null;

        if (isset($request->bundle_id)) {
            $selectedBundle = BundleCourse::findOrFail($request->bundle_id);
            if($selectedBundle->is_subscription_enabled) {
                $subscription_status = 'active';
            }

            $bundle = BundleCourse::where('id', $request->bundle_id)->first();

            $created_bundle = Order::create([
                'bundle_id' => $request->bundle_id,
                'user_id' => $request->user_id,
                'instructor_id' => $bundle->user_id,
                'subscription_status'=>$subscription_status,
                'payment_method' => 'Admin Enroll',
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }

         if (isset($request->course_id)) {

            $course = Course::where('id', $request->course_id)->first();

            $created_course = Order::create([
                'course_id' => $request->course_id,
                'user_id' => $request->user_id,
                'instructor_id' => $course->user_id,
                'payment_method' => 'Admin Enroll',
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
        }

        return response()->json([
            "message" => "Added successfully"
        ], 201);
    }


    public function deleteorder(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(Order::where('id', $id)->exists()) {
            $data = Order::find($id);


            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function getAllinclude(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $includes = CourseInclude::get();

        $result = array();

        foreach ($includes as $data) {

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'detail' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('detail')),
                'icon' => $data->icon,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('data'=>$result), 200); 
    }

    public function getinclude(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (CourseInclude::where('id', $id)->exists()) {
            $data = CourseInclude::where('id', $id)->first();

            $result = array();

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'detail' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('detail')),
                'icon' => $data->icon,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );


            return response()->json(array('data'=>$result), 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }

    public function createinclude(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $this->validate($request,[
            "course_id" => "required",
            "detail" => "required",
            "icon" => "required",
            "status" => "required",
        ]);

        $data = new CourseInclude;

        $data->course_id = $request->course_id;
        $data->detail = $request->detail;
        $data->icon = $request->icon;
        $data->status = $request->status;
        $data->save();

        return response()->json([
            "message" => "Added successfully"
        ], 201);
    }

    public function updateinclude(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (CourseInclude::where('id', $id)->exists()) {
            $data = CourseInclude::find($id);


       

            $data->course_id = isset($request->course_id) ? $request->course_id : $data->course_id;
            $data->detail = isset($request->detail) ? $request->detail : $data->detail;
            $data->icon = isset($request->icon) ? $request->icon : $data->icon;
            $data->status = isset($request->status) ? $request->status : $data->status;
            $data->save();

       

            return response()->json([
              "message" => "records updated successfully", 'data'=>$data
            ], 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function deleteinclude(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(CourseInclude::where('id', $id)->exists()) {
            $data = CourseInclude::find($id);


            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function getAllwhatlearn(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $whatlearns = WhatLearn::get();

        $result = array();

        foreach ($whatlearns as $data) {

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'detail' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('detail')),
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('data'=>$result), 200); 
    }

    public function getwhatlearn(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (WhatLearn::where('id', $id)->exists()) {
            $data = WhatLearn::where('id', $id)->first();

            $result = array();

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'detail' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('detail')),
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );


            return response()->json(array('data'=>$result), 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }

    public function createwhatlearn(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $this->validate($request,[
            "course_id" => "required",
            "detail" => "required",
            "status" => "required",
        ]);

        $data = new WhatLearn;

        $data->course_id = $request->course_id;
        $data->detail = $request->detail;
        $data->status = $request->status;
        $data->save();

        return response()->json([
            "message" => "Added successfully"
        ], 201);
    }

    public function updatewhatlearn(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (WhatLearn::where('id', $id)->exists()) {
            $data = WhatLearn::find($id);


       

            $data->course_id = isset($request->course_id) ? $request->course_id : $data->course_id;
            $data->detail = isset($request->detail) ? $request->detail : $data->detail;
            $data->status = isset($request->status) ? $request->status : $data->status;
            $data->save();

       

            return response()->json([
              "message" => "records updated successfully", 'data'=>$data
            ], 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function deletewhatlearn(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(WhatLearn::where('id', $id)->exists()) {
            $data = WhatLearn::find($id);


            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function getAllchapter(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $coursechapter = CourseChapter::get();

        $result = array();

        foreach ($coursechapter as $data) {

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'chapter_name' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('chapter_name')),
                'status' => $data->status,
                'file' => $data->file,
                'position' => $data->position,
                'drip_type' => $data->file,
                'drip_date' => $data->drip_date,
                'drip_days' => $data->drip_days,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('data'=>$result), 200); 
    }

    public function getchapter(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (CourseChapter::where('id', $id)->exists()) {
            $data = CourseChapter::where('id', $id)->first();

            $result = array();

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'chapter_name' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('chapter_name')),
                'status' => $data->status,
                'file' => $data->file,
                'position' => $data->position,
                'drip_type' => $data->file,
                'drip_date' => $data->drip_date,
                'drip_days' => $data->drip_days,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );


            return response()->json(array('data'=>$result), 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }

    public function createchapter(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $this->validate($request,[
            "course_id" => "required",
            "chapter_name" => "required",
            "status" => "required",
        ]);

        
        $input = $request->all();

        if($file = $request->file('file'))
        { 
          $filename = time().$file->getClientOriginalName();
          $file->move('files/material',$filename);
          $input['file'] = $filename;
        }

        if($request->drip_type == "date")
        {
            $start_time = date('Y-m-d\TH:i:s', strtotime($request->drip_date));
            $input['drip_date'] = $start_time; 
            $input['drip_days'] = null;
           

        }
        elseif($request->drip_type == "days"){

            $input['drip_days'] = $request->drip_days;
            $input['drip_date'] = null; 

        }
        else{

            $input['drip_days'] = null;
            $input['drip_date'] = null; 

        }

        

        $input['position'] = (CourseChapter::count()+1);

        


        $data = CourseChapter::create($input);

        $data->save();

        return response()->json([
            "message" => "Added successfully"
        ], 201);
    }

    public function updatechapter(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (CourseChapter::where('id', $id)->exists()) {
            $data = CourseChapter::findorfail($id);
            
            $input = $request->all();


            if($request->drip_type == "date")
            {
                $start_time = date('Y-m-d\TH:i:s', strtotime($request->drip_date));
                $input['drip_date'] = $start_time; 
                $input['drip_days'] = null;
               

            }
            elseif($request->drip_type == "days"){

                $input['drip_days'] = $request->drip_days;
                $input['drip_date'] = null; 

            }
            else{

                $input['drip_days'] = null;
                $input['drip_date'] = null; 

            }

            if(isset($request->status))
            {
                $input['status'] = '1';
            }
            else
            {
                $input['status'] = '0';
            }

            if($file = $request->file('file'))
            {
                if($data->file != "")
                {
                    $chapter_file = @file_get_contents(public_path().'/files/material/'.$data->file);

                    if($chapter_file)
                    {
                        unlink('files/material/'.$data->file);
                    }
                }
                $name = time().$file->getClientOriginalName();
                $file->move('files/material', $name);
                $input['file'] = $name;
            }

            $data->update($input);

       

            return response()->json([
              "message" => "records updated successfully", 'data'=>$data
            ], 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function deletechapter(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(CourseChapter::where('id', $id)->exists()) {
            $data = CourseChapter::find($id);


            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function getAllclass(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $class = CourseClass::get();

        $result = array();

        foreach ($class as $data) {

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                                'course_name' => $data->courses->title,
                'coursechapter_id' => $data->coursechapter_id,
                                                'chapter_name' => $data->coursechapters->chapter_name,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('title')),
                'status' => $data->status,
                'file' => $data->file,
                'position' => $data->position,

                'duration' => $data->duration,
                'featured' => $data->featured,
                'url' => $data->url,
                'size' => $data->size,
                'image' => url('images/class/' . $data->image),
                'video' => $data->video,
                'pdf' => $data->pdf,
                'file' => $data->file,
                'zip' => $data->zip,
                'preview_video' => $data->preview_video,
                'preview_url' => $data->preview_url,
                'preview_type' => $data->preview_type,
                'date_time' => $data->date_time,
                'audio' => $data->audio,
                'detail' => $data->detail,
                'aws_upload' => $data->aws_upload,
                'type' => $data->type,
                'drip_type' => $data->file,
                'drip_date' => $data->drip_date,
                'drip_days' => $data->drip_days,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('data'=>$result), 200); 
    }

    public function getclass(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (CourseClass::where('id', $id)->exists()) {
            $data = CourseClass::where('id', $id)->first();

            $result = array();

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'coursechapter_id' => $data->coursechapter_id,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('title')),
                'status' => $data->status,
                'file' => $data->file,
                'position' => $data->position,

                'duration' => $data->duration,
                'featured' => $data->featured,
                'url' => $data->url,
                'size' => $data->size,
                'image' => url('images/class/' . $data->image),
                'video' => $data->video,
                'pdf' => $data->pdf,
                'file' => $data->file,
                'zip' => $data->zip,
                'preview_video' => $data->preview_video,
                'preview_url' => $data->preview_url,
                'preview_type' => $data->preview_type,
                'date_time' => $data->date_time,
                'audio' => $data->audio,
                'detail' => $data->detail,
                'aws_upload' => $data->aws_upload,
                'type' => $data->type,
                'drip_type' => $data->file,
                'drip_date' => $data->drip_date,
                'drip_days' => $data->drip_days,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );


            return response()->json(array('data'=>$result), 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }

    public function createclass(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $this->validate($request,[
            "course_id" => "required",
            "title" => "required",
            "status" => "required",
        ]);
    
      

        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $courseclass = new CourseClass;
        $courseclass->course_id = $request->course_id;
        $courseclass->coursechapter_id =  $request->coursechapter_id;
        $courseclass->title = $request->title;
        $courseclass->duration = $request->duration;
        $courseclass->status = $request->status;
        $courseclass->featured = $request->featured;
        $courseclass->video = $request->video;
        $courseclass->image = $request->image;
        $courseclass->zip = $request->zip;
        $courseclass->pdf = $request->pdf;
        $courseclass->size = $request->size;
        $courseclass->url = $request->url;
        $courseclass->date_time = $request->date_time;
        $courseclass->detail = $request->detail;

        $courseclass->user_id = Auth::user()->id;

        $courseclass['position'] = (CourseClass::count()+1);



        if($request->drip_type == "date")
        {
            $courseclass->drip_type = $request->drip_type; 
            $start_time = date('Y-m-d\TH:i:s', strtotime($request->drip_date));
            $courseclass->drip_date = $start_time; 
            $courseclass->drip_days = null;
           

        }
        elseif($request->drip_type == "days"){

            $courseclass->drip_type = $request->drip_type;
            $courseclass->drip_days = $request->drip_days;
            $courseclass->drip_date = null; 

        }
        else{

            $courseclass->drip_days = null;
            $courseclass->drip_date = null; 

        }

        
        $courseclass->status = $request->status;
        $courseclass->featured = $request->featured;

    
        if($request->type == "video")
        {
            $courseclass->type = "video";
                    
            if($request->checkVideo == "url")
            {
                $courseclass->url = $request->vidurl;
                $courseclass->video = null;
                $courseclass->iframe_url = null;
            }
            else if($request->checkVideo == "uploadvideo")
            {
                if($file = $request->file('video_upld'))
                {
                    $name = 'video_course_'.time().'.'.$file->getClientOriginalExtension();
                    $file->move('video/class',$name);
                    $courseclass->video = $name;
                    $courseclass->url = null;
                    $courseclass->iframe_url = null;
                }
            }

            else if($request->checkVideo == "iframeurl")
            {
                $courseclass->iframe_url = $request->iframe_url;
                $courseclass->url = null;
                $courseclass->video = null;
            }
            elseif($request->checkVideo == "liveurl")
            {
                $courseclass->url = $request->vidurl;
                $courseclass->video = null;
                $courseclass->iframe_url = null;
            }

            elseif($request->checkVideo == "aws_upload")
            {

                if($request->hasFile('aws_upload'))
                {

                    $file = request()->file('aws_upload');
                    $videoname = time() . '_'. $file->getClientOriginalName();

                    $t = Storage::disk('s3')->put($videoname, file_get_contents($file) , 'public');
                    $upload_video = $videoname;
                    $aws_url = env('AWS_URL') . $videoname;
                    

                    $videoname = Storage::disk('s3')->url($videoname);

                    $courseclass->aws_upload = $aws_url;
                }

            }

            elseif($request->checkVideo == "youtube")
            {
                $courseclass->url = $request->vidurl;
                $courseclass->video = null;
                $courseclass->iframe_url = null;
            }

            elseif($request->checkVideo == "vimeo")
            {
                $courseclass->url = $request->vidurl;
                $courseclass->video = null;
                $courseclass->iframe_url = null;
            }
        }

        

                    
        if(!isset($request->preview_type))
        {
            $courseclass['preview_url'] = $request->url;
            $courseclass['preview_type'] = "url";
        }
        else
        {
            if($file = $request->file('video'))
            {
                
              $filename = time().$file->getClientOriginalName();
              $file->move('video/class/preview',$filename);
              $courseclass['preview_video'] = $filename;
            }
            $courseclass['preview_type'] = "video";
        }



        if($request->type == "image")
        { 
            $courseclass->type = "image";

            if($request->checkImage == "url")
            {
                $courseclass->url = $request->imgurl;
                $courseclass->image = null;
            }
            else if($request->checkImage == "uploadimage")
            {
                if($file = $request->file('image'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move('images/class',$name);
                    $courseclass->image = $name;
                    $courseclass->url = null;
                }
            }
        }


        if($request->type == "zip")
        {
            $courseclass->type = "zip";

            if($request->checkZip == "zipURLEnable")
            {
                $courseclass->url = $request->zipurl;
                $courseclass->zip = null;
            }
            else if($request->checkZip == "zipEnable")
            {
                if($file = $request->file('uplzip'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move('files/zip',$name);
                    $courseclass->zip = $name;
                    $courseclass->url = null;
                }
            }
        } 


        if($request->type == "pdf")
        {
            $courseclass->type = "pdf";

            if($request->checkPdf == "pdfURLEnable")
            {
                $courseclass->url = $request->pdfurl;
                $courseclass->pdf = null;
            }
            elseif($request->checkPdf == "pdfEnable")
            {
                if($file = $request->file('pdf'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move('files/pdf',$name);
                    $courseclass->pdf = $name;
                    $courseclass->url = null;
                }
            }
        }


        if($request->type == "audio")
        {
            $courseclass->type = "audio";

            if($request->checkAudio == "audiourl")
            {
                $courseclass->url = $request->audiourl;
                $courseclass->audio = null;
            }
            elseif($request->checkAudio == "uploadaudio")
            {
                if($file = $request->file('audioupload'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move('files/audio',$name);
                    $courseclass->audio = $name;
                    $courseclass->url = null;
                }
            }
        }

        if($file = $request->file('file')) 
        { 
          
          $path = 'files/class/material/';

          if(!file_exists(public_path().'/'.$path)) {
            
            $path = 'files/class/material/';
            File::makeDirectory(public_path().'/'.$path,0777,true);
          } 

          $filename = time().$file->getClientOriginalName();
          $file->move('files/class/material',$filename);
          $courseclass['file'] = $filename;
          
        }

        

       
        $courseclass->save();
          
        // Subtitle 
        if($request->has('sub_t')){
        foreach($request->file('sub_t') as $key=> $image)
          {
          
            $name = $image->getClientOriginalName();
            $image->move(public_path().'/subtitles/', $name);  
           
            $form= new Subtitle();
            $form->sub_lang = $request->sub_lang[$key];
            $form->sub_t=$name;
            $form->c_id = $courseclass->id;
            $form->save(); 
          }
        }

        
        

        return response()->json([
            "message" => "Added successfully",
            'courseclass'=>$courseclass
        ], 201);
    }

    public function updateclass(Request $request, $id) {
        //return $request;
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (CourseClass::where('id', $id)->exists()) {
            
            $courseclass = CourseClass::findOrFail($id);
            $courseclass->coursechapter_id=$request->coursechapter_id;
            $courseclass->title = $request->title;
            $courseclass->duration = $request->duration;
            $courseclass->status = $request->status;
            $courseclass->featured = $request->featured;
            $courseclass->size = $request->size;
            $courseclass->date_time = $request->date_time;
            $courseclass->detail = $request->detail;
             
            $coursefind  = CourseChapter::findOrFail($request->coursechapter_id);
            $maincourse = Course::findorfail($coursefind->course_id);

                //return $coursefind;
            if($request->drip_type == "date")
            {
                $courseclass->drip_type = $request->drip_type;
                $start_time = date('Y-m-d\TH:i:s', strtotime($request->drip_date));
                $courseclass->drip_date = $start_time; 
                $courseclass->drip_days = null;
               

            }
            elseif($request->drip_type == "days"){

                $courseclass->drip_type = $request->drip_type;
                $courseclass->drip_days = $request->drip_days;
                $courseclass->drip_date = null; 

            }
            else{

                $courseclass->drip_days = null;
                $courseclass->drip_date = null; 

            }
            

            if($request->type == "video")
            {

                $courseclass->type = "video";
                    
                if($request->checkVideo == "url")
                {

                    $courseclass->url = $request->vidurl;
                    $courseclass->video = null;
                    $courseclass->iframe_url = null;
                    $courseclass->date_time = null;
                    $courseclass->aws_upload = null;
                }

                else if($request->checkVideo == "uploadvideo")
                {

                    if($file = $request->file('video_upld'))
                    {
                        if($courseclass->video !="")
                        {
                            $content = @file_get_contents(public_path().'/video/class/'.$courseclass->video);

                            if ($content) {
                                unlink(public_path().'/video/class/'.$courseclass->video);
                            }
                        }
                    
                        $name = 'video_course_'.time().'.'.$file->getClientOriginalExtension();
                        $file->move('video/class',$name);
                        $courseclass->video = $name;
                        $courseclass->url = null;
                        $courseclass->iframe_url = null;
                        $courseclass->date_time = null;
                        $courseclass->aws_upload = null;

                    }
                }

                else if($request->checkVideo == "iframeurl")
                {
                    $courseclass->iframe_url = $request->iframe_url;
                    $courseclass->url = null;
                    $courseclass->video = null;
                    $courseclass->date_time = null;
                    $courseclass->aws_upload = null;
                }
                elseif($request->checkVideo == "liveurl")
                {
                    $courseclass->url = $request->vidurl;
                    $courseclass->video = null;
                    $courseclass->iframe_url = null;
                    $courseclass->aws_upload = null;
                }
                elseif($request->checkVideo == "aws_upload")
                {

                    if($request->hasFile('aws_upload'))
                    {

                        $file = request()->file('aws_upload');
                        $videoname = time() . '_'. $file->getClientOriginalName();

                        $t = Storage::disk('s3')->put($videoname, file_get_contents($file) , 'public');
                        $upload_video = $videoname;
                        $aws_url = env('AWS_URL') . $videoname;
                        

                        $videoname = Storage::disk('s3')->url($videoname);

                        $courseclass->aws_upload = $aws_url;
                        $courseclass->video = null;
                        $courseclass->iframe_url = null;
                        $courseclass->date_time = null;
                    }

                }
                elseif($request->checkVideo == "youtube")
                {
                    $courseclass->url = $request->vidurl;
                    $courseclass->video = null;
                    $courseclass->iframe_url = null;
                }

                elseif($request->checkVideo == "vimeo")
                {
                    $courseclass->url = $request->vidurl;
                    $courseclass->video = null;
                    $courseclass->iframe_url = null;
                }
            } 


            if($request->type == "audio")
            { 
                $courseclass->type = "audio";

                if($request->checkAudio == "audiourl")
                {
                    $courseclass->url = $request->audiourl;
                    $courseclass->audio = null;
                }
                else if($request->checkAudio == "uploadaudio")
                {
                    if($file = $request->file('audio'))
                    {
                        if($courseclass->audio !="")
                        {
                            $content = @file_get_contents(public_path().'/files/audio/'.$courseclass->audio);

                            if ($content) {
                                unlink(public_path().'/files/audio/'.$courseclass->audio);
                            }
                        }

                        $name = time().$file->getClientOriginalName();
                        $file->move('files/audio',$name);
                        $courseclass->audio = $name;
                        $courseclass->url = null;
                     }
                }

            } 


            if($request->type == "image")
            { 
                $courseclass->type = "image";

                if($request->checkImage == "url")
                {
                    $courseclass->url = $request->imgurl;
                    $courseclass->image = null;
                }
                else if($request->checkImage == "uploadimage")
                {
                    if($file = $request->file('image'))
                    {
                        if($courseclass->image !="")
                        {
                            $content = @file_get_contents(public_path().'/images/class/'.$courseclass->image);

                            if ($content) {
                                unlink(public_path().'/images/class/'.$courseclass->image);
                            }
                        }

                        $name = time().$file->getClientOriginalName();
                        $file->move('images/class',$name);
                        $courseclass->image = $name;
                        $courseclass->url = null;
                     }
                }

            } 

            if($request->type == "zip")
            {

                $courseclass->type = "zip";

                if($request->checkZip == "zipURLEnable")
                {
                    $courseclass->url = $request->zipurl;
                    $courseclass->zip = null;
                }
                else if($request->checkZip == "zipEnable")
                {
                    if($file = $request->file('uplzip'))
                    {
                        $content = @file_get_contents(public_path().'/files/zip/'.$courseclass->zip);

                        if ($content) {
                            unlink(public_path().'/files/zip/'.$courseclass->zip);
                        }

                        $name = time().$file->getClientOriginalName();
                        $file->move('files/zip',$name);
                        $courseclass->zip = $name;
                        $courseclass->url = null;
                    }
                }
            }


            if($request->type == "pdf")
            {
                $courseclass->type = "pdf";

                if($request->checkPdf == "url")
                {
                    $courseclass->url = $request->pdfurl;
                    $courseclass->pdf = null;
                }
                else if($request->checkPdf == "uploadpdf")
                {
                    if($file = $request->file('pdf'))
                    {
                        $content = @file_get_contents(public_path().'/files/pdf/'.$courseclass->pdf);

                        if ($content) {
                            unlink(public_path().'/files/pdf/'.$courseclass->pdf);
                        }
            
                        
                        $name = time().$file->getClientOriginalName();
                        $file->move('files/pdf',$name);
                        $courseclass->pdf = $name;
                        $courseclass->url = null;
                     }
                }
            }




            if(isset($request->preview_type))
            {
              $courseclass['preview_type'] = "video";
            }
            else
            {
              $courseclass['preview_type'] = "url";
            }

            
            if(!isset($request->preview_type))
            {
                $courseclass->preview_url = $request->preview_url;
                $courseclass->preview_video = null;
                $courseclass['preview_type'] = "url";
                
            }
            else
            {
                
                if($file = $request->file('video'))
                {
                    // return $request;
                  if($courseclass->preview_video != "")
                  {
                    $content = @file_get_contents(public_path().'/video/class/preview/'.$courseclass->preview_video);
                    if ($content) {
                      unlink(public_path().'/video/class/preview/'.$courseclass->preview_video);
                    }
                  }
                  
                  $filename = time().$file->getClientOriginalName();
                  $file->move('video/class/preview',$filename);
                  $courseclass['preview_video'] = $filename;
                  $courseclass->preview_url = null;

                  $courseclass['preview_type'] = "video";

                }
            }

            if($file = $request->file('file'))
            {
                $path = 'files/class/material/';

                if(!file_exists(public_path().'/'.$path)) {
                    
                    $path = 'files/class/material/';
                    File::makeDirectory(public_path().'/'.$path,0777,true);
                } 

                if($courseclass->file != "")
                {
                    $class_file = @file_get_contents(public_path().'/files/class/material/'.$courseclass->file);

                    if($class_file)
                    {
                        unlink('files/class/material/'.$courseclass->file);
                    }
                }
                $name = time().$file->getClientOriginalName();
                $file->move('files/class/material', $name);
                $courseclass['file'] = $name;
            }
            

            if(isset($request->status))
            {
                $courseclass['status'] = '1';
            }
            else
            {
                $courseclass['status'] = '0';
            }

            if(isset($request->featured))
            {
                $courseclass['featured'] = '1';
            }
            else
            {
                $courseclass['featured'] = '0';
            }


            $courseclass->save();

       

            return response()->json([
              "message" => "records updated successfully", 'data'=>$courseclass
            ], 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function deleteclass(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(CourseClass::where('id', $id)->exists()) {
            $data = CourseClass::find($id);


            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function getAllrelated(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $relatedcourse = RelatedCourse::with('courses')->get();
    
        $result = array();
        
        foreach ($relatedcourse as $data) {
            if($data->course_id != NULL && $data->course_id != 0){
                $result[] = array(
                    'id' => $data->id,
                    'course_id' => $data->course_id,
                    'user_id' => $data->user_id,
                    'title' => $data->courses->title,
                    'main_course_id' => $data->main_course_id,
                    'status' => $data->status,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                );
            }
        }

        return response()->json(array('all_related_course'=>$result));

    }

    public function getrelated(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (RelatedCourse::where('id', $id)->exists()) {

            $data = RelatedCourse::first();

            $result = array();

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );


            return response()->json(array('related_course_by_id'=>$result));

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }

    public function createrelated(Request $request) {


        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'user_id' => 'required',
            'main_course_id' => 'required',
        ]);

        if ($validator->fails()) {

        $errors = $validator->errors();
            if($errors->first('course_id')){
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
            
            if($errors->first('user_id')){
                return response()->json(['message' => $errors->first('user_id'), 'status' => 'fail']);
            }
            
            if($errors->first('main_course_id')){
                return response()->json(['message' => $errors->first('main_course_id'), 'status' => 'fail']);
            }
    
            $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
    
            if (!$key) {
                return response()->json(['Invalid Secret Key !'], 400);
            }
        }

        $data = new RelatedCourse;
        $data->course_id = $request->course_id;
        $data->user_id = $request->user_id;
        $data->main_course_id = $request->main_course_id;
        $data->status = $request->status;
        $data->save();
        
        return response()->json([
            "message" => "created successfully",
            'related_course'=>$data
        ]);
    }

    public function updaterelated(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (RelatedCourse::where('id', $id)->exists()) {
            $data = RelatedCourse::find($id);

        DB::table('related_courses')->where('id',$id)
        ->update([

        'course_id' => $request->course_id,
        'main_course_id' => $request->main_course_id,
        'user_id' => $request->user_id,
        'status' => isset($request ->status) ? 1 : 0,
        'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

            return response()->json(array('related_course_by_id'=>$data));
        }

        else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function deleterelated(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(RelatedCourse::where('id', $id)->exists()) {
            $data = RelatedCourse::find($id);
            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function getAllquestions(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();

        $question = Question::where('instructor_id', $auth->id)->get();

        $result = array();

        foreach ($question as $data) {

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'course' => $data->courses->title,
                'user_id' => $data->user_id,
                'user' => optional($data->user)['fname'] . ' ' . optional($data->user)['lname'],
                'instructor_id' => $data->user_id,
                'question' => $data->question,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('course_questions'=>$result));

    }

    public function getquestions(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Question::where('id', $id)->exists()) {

            $auth = Auth::user();

            $data = Question::where('instructor_id', $auth->id)->first();

            $result = array();

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'course' => $data->courses->title,
                'user_id' => $data->id,
                'user' => optional($data->user)['fname'] . ' ' . optional($data->user)['lname'],
                'instructor_id' => $data->user_id,
                'question' => $data->question,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );


            return response()->json(array('course_questions'=>$result));

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }

    public function createquestions(Request $request) {


        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }


        $auth = Auth::user();

        $data = new Question;
        $data->course_id = $request->course_id;
        $data->user_id = $auth->id;
        $data->instructor_id = $auth->id;
        $data->question = $request->question;
        $data->status = $request->status;
        $data->save();

        return response()->json([
            "message" => "created successfully",
            'course_questions'=>$data
        ]);
    }

    public function updatequestions(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();

        if (Question::where('id', $id)->exists()) {
            $data = Question::find($id);

            $data->course_id = isset($request->course_id) ? $request->course_id : $data->course_id;
            $data->user_id = isset($auth->id) ? $auth->id : $data->user_id;
            $data->instructor_id = isset($auth->id) ? $auth->id : $data->instructor_id;
            $data->question = isset($request->question) ? $request->question : $data->question;
            $data->status = isset($request->status) ? $request->status : $data->status;
            $data->save();

            return response()->json([
              "message" => "records updated successfully",
              'questions'=>$data
            ]);
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function deletequestions(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(Question::where('id', $id)->exists()) {
            $data = Question::find($id);
            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function getAllanswer(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }


        $answers = Answer::where('instructor_id',Auth::user()->id)->get();

        $result = array();

        foreach ($answers as $data) {

            $result[] = array(
                'id' => $data->id,
                'course' => $data->courses->title,
                'user_fname' => $data->user->fname,
                'user_lname' => $data->user->lname,
                'question' => $data->question->question,
                'answer' => $data->answer,
                'status' => $data->status,
                
            );
        }

        return response()->json(array('course_answer'=>$result));

    }

    public function getanswer(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Answer::where('id', $id)->exists()) {

            $data = Answer::findOrFail($id);

            $result = array();

            $result[] = array(
                
                'course_id' => $data->courses->title,
                'answer' => $data->answer,
                'status' => $data->status,
                
            );


            return response()->json(array('answer'=>$result));

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }

    

    public function updateanswer(Request $request, $id) {
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Answer::where('id', $id)->exists()) {
            $answer = Answer::find($id);
            $data->answer = isset($request->answer) ? $request->answer : $answer->answer;
            $answer->update($data);

            return response()->json([
              "message" => "Updated successfully",
              
            ]);
        } else {
            return response()->json([
              "message" => "Data not found"
            ], 404);
        }
    }




    public function getAllrefund(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }


        $user = Auth::user();

        $enroll = RefundCourse::where('instructor_id', $user->id)->where('status', 1)->get();

        $enroll_details = array();

        if(isset($enroll)){
        
            foreach ($enroll as $enrol) {


                $enroll_details[] = array(

                    'id' => $enrol->id,
                    'instructor_id' => $enrol->instructor_id,
                    'user_id' => $enrol->user_id,
                    'user' => optional($enrol->user)['fname'] . ' ' . optional($enrol->user)['lname'],
                    'order_id' => $enrol->order_id,
                    'refund_transaction_id' => $enroll->refund_transaction_id,
                    'ref_id' => $enroll->ref_id,
                    'txn_fee' => $enroll->txn_fee,
                    'payment_method' => $enrol->payment_method,
                    'total_amount' => $enrol->total_amount,
                    'currency' => $enrol->currency,
                    'currency_icon' => $enrol->currency_icon,
                    'reason' => $enrol->reason,
                    'detail' => $enrol->detail,
                    'approved' => $enrol->approved,
                    'bank_id' => $enrol->bank_id,
                    'order_refund_id' => $enrol->order_refund_id,
                    'refunded_amt' => $enrol->refunded_amt,
                    'status' => $enrol->status,
                    'created_at' => $enrol->created_at,
                    'updated_at' => $enrol->updated_at,

                );

            }
            return response()->json(array('refund' =>$enroll_details), 200);
        }

        return response()->json(array('refund' =>$enroll_details), 200);

    }

    public function getrefund(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (RefundCourse::where('id', $id)->exists()) {
            $enrol = RefundCourse::where('id', $id)->first();

            $result = array();

            $result[] = array(

                'id' => $enrol->id,
                'instructor_id' => $enrol->instructor_id,
                'user_id' => $enrol->user_id,
                'user' => optional($enrol->user)['fname'] . ' ' . optional($enrol->user)['lname'],
                'order_id' => $enrol->order_id,
                'refund_transaction_id' => $enroll->refund_transaction_id,
                'ref_id' => $enroll->ref_id,
                'txn_fee' => $enroll->txn_fee,
                'payment_method' => $enrol->payment_method,
                'total_amount' => $enrol->total_amount,
                'currency' => $enrol->currency,
                'currency_icon' => $enrol->currency_icon,
                'reason' => $enrol->reason,
                'detail' => $enrol->detail,
                'approved' => $enrol->approved,
                'bank_id' => $enrol->bank_id,
                'order_refund_id' => $enrol->order_refund_id,
                'refunded_amt' => $enrol->refunded_amt,
                'status' => $enrol->status,
                'created_at' => $enrol->created_at,
                'updated_at' => $enrol->updated_at,

            );


            return response()->json(array('data'=>$result), 200);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }

    public function updaterefund(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (RefundCourse::where('id', $id)->exists()) {
            $data = RefundCourse::find($id);

            RefundCourse::where('id', $id)
                ->update([
                'status' => 1,
                'order_refund_id' => $request->order_id,
                'refund_transaction_id' => $request->txn_id,
                'txn_fee' => null,
                'refunded_amt' => $request->amount,
                'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),

            ]);

            Order::where('id', $request->order_id)
                ->update([
                'refunded' => 1,

            ]);

            return response()->json([
              "message" => "records updated successfully",
            ]);
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function deleterefund(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(RefundCourse::where('id', $id)->exists()) {
            $data = RefundCourse::find($id);


            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function getAllassignment(Request $request) {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $user = Auth::user();

        $assignment = Assignment::where('instructor_id', $user->id)->get();

        $result = array();

        foreach ($assignment as $data) {

            $result[] = array(
                'id' => $data->id,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('title')),
                                'user_id' => $data->user->id,

                'user_name' => $data->user->fname,
                                'course_id' => $data->courses->id,

                'course_name' => $data->courses->title,
                                'instructor_id' => $data->instructor->id,

                'instructor_name' => $data->instructor->fname,
                'assignment' => url('files/assignment/' . $data->assignment),
                'type' => $data->type,
                                'chapter_id' => $data->chapter->id,
                'chapter_name' => $data->chapter->chapter_name,
                'detail' => $data->detail,
                'rating' => $data->rating,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('data'=>$result));

    }

    public function getassignment(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Assignment::where('id', $id)->exists()) {

            $data = Assignment::where('id', $id)->first();

            $result = array();

            $result[] = array(
                'id' => $data->id,
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $data->getTranslations('title')),
                'user_id' => $data->user->fname,
                'course_id' => $data->courses->title,
                'instructor_id' => $data->instructor->fname,
                'assignment' => $data->assignment,
                'type' => $data->type,
                'chapter_id' => $data->chapter->chapter_name,
                'detail' => $data->detail,
                'rating' => $data->rating,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );


            return response()->json(array('data'=>$result));

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

    }


    public function updateassignment(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Assignment::where('id', $id)->exists()) {
            $language = Assignment::find($id);
        

            if(isset($request->type))
            {
            
                Assignment::where('id', $id)
                        ->update(['rating' => $request->rating, 'type' => 1]);
            }
            else
            {
                
                Assignment::where('id', $id)
                        ->update(['rating' => NULL, 'type' => 0]);
            }

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }


    public function deleteassignment(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(Assignment::where('id', $id)->exists()) {
            $assignment = Assignment::find($id);
            $assignment->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "Assignment not found"
            ], 404);
        }
    }


    public function toinvolvecourses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $user = Auth::user();

        $all_course = Course::where('involvement_request','1')->where('user_id', '!=', $user->id)->get();

        foreach ($all_course as $course) {

            $result[] = array(
                'id' => $course->id,
                'subcategory_id' => $course->subcategory_id,
                'category_id' => $course->category->title,
                'childcategory_id' => $course->childcategory_id,
                'language_id' => $course->language->name,
                'user_id' => $course->user_id,
                'user' => optional($course->user)['fname'] . ' ' . optional($course->user)['lname'],
                'title' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $course->getTranslations('title')),
                'short_detail' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $course->getTranslations('short_detail')),
                'requirement' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $course->getTranslations('requirement')),
                'detail' => array_map(function ($lang) {
                                return trim(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($lang))));
                            }, $course->getTranslations('detail')),
                'price' => $course->price,
                'discount_price' => $course->discount_price,
                'day' => $course->day,
                'video' => $course->video,
                'video_path' => url('video/preview/'.$course->video),
                'video_url' => $course->video_url,
                'url' => $course->url,
                'featured' => $course->featured,
                'status' => $course->status,
                'slug' => $course->slug,
                'duration' => $course->duration,
                'duration_type' => $course->duration_type,
                'instructor_revenue' => $course->instructor_revenue,
                'involvement_request' => $course->involvement_request,
                'refund_policy_id' => $course->refund_policy_id,
                'assignment_enable' => $course->assignment_enable,
                'appointment_enable' => $course->appointment_enable,
                'certificate_enable' => $course->certificate_enable,
                'course_tags' => $course->course_tags,
                'level_tags' => $course->level_tags,
                'preview_image' => $course->preview_image,
                'imagepath' =>  url('images/course/'.$course->preview_image),
                'course_tags' => $course->course_tags,
                'level_tags' => $course->level_tags,
                'reject_txt' => preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode( $course->reject_txt))),
                'drip_enable' => $course->drip_enable,
                'preview_type' => $course->preview_type,
                'updated_at' => $course->created_at,
            );
        }
        

        return response()->json(array('courses' => $result), 200);
    }

    public function requesttoinvolve(Request $request, $id)
    {

         $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Involvement::where('id', $id)->exists()) {
            $data = Involvement::find($id);

            $data->reason = isset($request->reason) ? $request->reason : $data->reason;


            $data->save();

            return response()->json([
              "message" => "records updated successfully",
              'request'=>$data
            ]);
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    } 


    public function Allinvolvementrequest(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $user = Auth::user();
        //$involve_requests = Course::where('involvement_request','1')->where('user_id', '!=', Auth::user()->id)->get();
        $involve_requests = Involvement::where('user_id', Auth::user()->id)->get();
        $result = array();

        foreach ($involve_requests as $data) {
                              if(Auth::user()->id == $data->course->user->id)

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'course_name' => $data->course->title,
                'user_id' => $data->user->id,
                'user_name' => $data->user->fname,
                'reason' => $data->reason,
                'image' =>  url('images/user_img/'.$data->user->user_img),
                'slug'=>$data->course->slug,
                'featured' => $data->course->featured,
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        
        }

        return response()->json(array('data'=>$result));
    }

    public function involvedcourses(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $user = Auth::user();

        $involve_requests = Involvement::where('user_id', '!=', $user->id)->where('status', '0')->get();

        $result = array();

        foreach ($involve_requests as $data) {

            $result[] = array(
                'id' => $data->id,
                'image' => url('images/course/' . $data->preview_image),
                'course_id' => $data->course->title,
                'user_id' => $data->user->fname,
                'reason' => $data->reason,
               
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('data'=>$result));

    }


    public function allannouncement(Request $request) {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $announcement = Announcement::get();
    
        $result = array();
        
        foreach ($announcement as $data) {
            if($data->course_id != NULL && $data->course_id != 0){
                $result[] = array(
                    'id' => $data->id,
                    'course_id' => $data->course_id,
                    'course_name' => $data->courses->title,
                    'user_id' => $data->user_id,
                    'user_name' => $data->user->fname,
                    'announsment' => $data->announsment,
                    'status' => $data->status,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                );
            }
        }
        return response()->json(array('all_announcement'=>$result));
    }

    public function getannouncement(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Announcement::where('user_id', Auth::user()->id)->exists()) {

            $announcement = Announcement::where('id', $id)->get();

            $result = array();
            foreach ($announcement as $data) {
                $result[] = array(
                    'id' => $data->id,
                    'course_id' => $data->courses->id,
                    'announsment' => $data->announsment,
                    'course' => $data->courses->title,
                    'status' => $data->status,

                );
            }

            return response()->json(array('data' => $result));

        } else {
            return response()->json([
                "message" => "announcement not found",
            ], 404);
        }

    }

    public function createannouncement(Request $request) {

       $data = $this->validate($request,[
            'course_id' => 'required',
            'announsment' => 'required',
            'user_id' => 'required',
        ]);

        $input = $request->all();
        $data = Announcement::create($input);

        if(isset($request->status) && !empty($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }

        $data->save(); 

        return response()->json([
            "message" => "created successfully",
            'announsment_created'=>$data
        ]);
    }

    // public function updateannouncement(Request $request, $id)
    // {
    //     //return $request;
    //     $data = Announcement::findorfail($id);
    //     $maincourse = Course::findorfail($request->course_id);
    //     $input['accept'] = $request->accept;

    //     if(isset($request->accept))
    //     {
    //         Appointment::where('id', $id)
    //                 ->update(['reply' => $request->reply, 'accept' => 1]);
    //     }
    //     else
    //     { 
    //         Appointment::where('id', $id)
    //                 ->update(['reply' => NULL, 'accept' => 0]);
    //     }

    //     return response()->json([
    //         "message" => "records updated successfully",
    //         'announsment_updated'=>$data
    //     ]);
    // }
    
    public function updateannouncement(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        if (Announcement::where('id', $id)->exists()) {
            //return $id;
            $data = Announcement::find($id);

            $data->announsment = isset($request->announsment) ? $request->announsment : $data->announsment;
            $data->status = isset($request->status) ? $request->status : $data->status;
            $data->save();

            return response()->json([
              "message" => "records updated successfully",
              'announsment'=>$data
            ]);
        } else {
            return response()->json([
              "message" => "announsment not found"
            ], 404);
        }
    }

    public function deleteannouncement(Request $request, $id) {

        $validator = Validator::make($request->all(), [
        'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(Announcement::where('id', $id)->exists()) {
            $data = Announcement::find($id);
            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
            }
    }
    
    

    public function vacationmode(Request $request){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }
        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        $vacation = User::where('id',Auth::user()->id)->select(['id','vacation_start','vacation_end'])->get();
        return response()->json(array('vacation'=>$vacation));
    }

    public function vacationmodeupdate(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }
        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        if (User::where('id', Auth::user()->id)->exists()) {
            $vacation     =  User::findOrFail(Auth::user()->id);
            $vacationmode =  User::where('id',Auth::user()->id)->select(['vacation_start','vacation_end'])->get();
            $data['vacation_start']  =  isset($request->vacation_start) ? $request->vacation_start : $vacation->vacation_start;
            $data['vacation_end']    =  isset($request->vacation_end) ? $request->vacation_end : $vacation->vacation_end;
            $vacation->update($data);
            return response()->json([
              "message" => "Vacation mode updated successfully",
              'vacation'=> $vacationmode
            ]);
        } else {
            return response()->json([
              "message" => "language not found"
            ], 404);
        }
    }
    
    public function reportreview(Request $request){
          $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
        $course = ReportReview::with('user','courses')->get();

        $result = array();

        foreach ($course as $data) {

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'course_name' => $data->courses['title'],
                'title' => $data->title,
                'instructor_id' => $data->user->id, 
                'instructor_name' => $data->user->fname,
                'detail' => $data->detail,
                'email' => $data->email,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }
        return response()->json(array('course'=>$result));
    }
    
    public function updatereportreview(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        if (ReportReview::where('id', $id)->exists()) {
            $data = ReportReview::find($id);

            $data->title = isset($request->title) ? $request->title : $data->title;
            $data->email = isset($request->email) ? $request->email : $data->email;
            $data->detail = isset($request->detail) ? $request->detail : $data->detail;
            $data->save();

            return response()->json([
              "message" => "updated successfully",
              'record'=>$data
            ]);
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }


        return response()->json(array('message' => 'Update Report Review', 'status' => 'success'), 200);
    }

    public function reportreviewbyid(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (ReportReview::where('id', $id)->exists()) {

            $data = ReportReview::findOrFail($id);

            $result = array();

            $result[] = array(
                
                'course_id' => $data->courses->id,
                'user_id' => $data->user_id,
                'review_id' => $data->review_id,
                'title' => $data->title,
                'email' => $data->email,
                'detail' => $data->detail,
            );
            return response()->json(array('report_review_id'=>$result));
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function deletereportreview(Request $request, $id) {

    $validator = Validator::make($request->all(), [
        'secret' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['Secret Key is required'], 402);
    }

    $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

    if (!$key) {
        return response()->json(['Invalid Secret Key !'], 400);
    }

    if(ReportReview::where('id', $id)->exists()) {
        $data = ReportReview::find($id);
        $data->delete();

        return response()->json([
          "message" => "records deleted"
        ]);

    } else {
        return response()->json([
          "message" => "data not found"
        ], 404);
        }
    }

    public function quizreview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $answers = QuizAnswer::where('type', '1')->get();
             $result = array();

        foreach ($answers as $data) {

            $result[] = array(
                'id' => $data->id,
                'course' => $data->courses->title,
                'user ' => $data->user->fname,
                'topic' => $data->topic->title,
                'question' => $data->quiz->question,
                'answer' => $data->txt_answer
            );
        }

        return response()->json(array('course_answer'=>$result));


    }

    public function quiztopic(Request $request){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $topics = QuizTopic::all();
        return response()->json(array('quiztopic' =>$topics), 200);
    }

    public function quiztopicbyid(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (QuizTopic::where('id', $id)->exists()) {

            $data = QuizTopic::findOrFail($id);

            $result = array();

            $result[] = array(
                
                'course_id' => $data->courses->id,
                'title' => $data->title,
                'answer' => $data->answer,
                'description' => $data->description,
                'per_q_mark' => $data->per_q_mark,
                'timer' => $data->timer,
                'quiz_again' => $data->quiz_again,
                'due_days' => $data->due_days,
                'type' => $data->type,
                'status' => $data->status,
                
            );


            return response()->json(array('quiz_topic'=>$result));

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function createquiztopic(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }


        $auth = Auth::user();

        $data = new QuizTopic;
        $data->id = $request->id;
        $data->course_id = $request->course_id;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->per_q_mark = $request->per_q_mark;
        $data->timer = $request->timer;
        $data->status = $request->status;
        $data->quiz_again = $request->quiz_again;
        $data->due_days = $request->due_days;
        $data->type = $request->type;
        $data->save();

        return response()->json([
            "message" => "created successfully",
            'quiz_topic_created'=>$data
        ]);
    }

    public function updatequiztopic(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (QuizTopic::where('id', $id)->exists()) {
            $data = QuizTopic::find($id);

            $data->course_id = isset($request->course_id) ? $request->course_id : $data->course_id;
            $data->title = isset($request->title) ? $request->title : $data->title;
            $data->description = isset($request->description) ? $request->description : $data->description;
            $data->per_q_mark = isset($request->per_q_mark) ? $request->per_q_mark : $data->per_q_mark;
            $data->timer = isset($request->timer) ? $request->timer : $data->timer;
            $data->quiz_again = isset($request->quiz_again) ? $request->course_id : $data->course_id;
            $data->due_days = isset($request->due_days) ? $request->due_days : $data->due_days;
            $data->type = isset($request->type) ? $request->type : $data->type;
            $data->status = isset($request->status) ? $request->status : $data->status;
            $data->save();

            return response()->json([
              "message" => "records updated successfully",
              'questions'=>$data
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function deletequiztopic(Request $request, $id)
    {

    $validator = Validator::make($request->all(), [
        'secret' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['Secret Key is required'], 402);
    }

    $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

    if (!$key) {
        return response()->json(['Invalid Secret Key !'], 400);
    }

    if(QuizTopic::where('id', $id)->exists()) {
        $data = QuizTopic::find($id);
        $data->delete();

        return response()->json([
          "message" => "records deleted"
        ]);

    } else {
        return response()->json([
          "message" => "data not found"
        ], 404);
        }
    }

    public function appointment(Request $request){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        $app = Appointment::get();
            $auth = Auth::user();

        $result = array();

        foreach ($app as $data) {

            $result[] = array(
                'id' => $data->id,
                'user_id' => $data->user->id,
                'user_name' =>$data->user->fname,
                'instructor_id'=> $auth->id,
                'instructor_name'=>$data->user->fname,
                'course_id'=>$data->courses->id,
                'course_name'=>$data->courses->title,
                'title'=>$data->title,
                'detail'=> $data->detail,
                'start_time'=>$data->start_time,
                'request'=>$data->request,
                'accept' => $data->accept,
                'files'=>$data->files,
                'reply'=>$data->reply,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('appointment'=>$result));

     
    }

    public function appointmentbyid(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Appointment::where('id', $id)->exists()) {

            $data = Appointment::findOrFail($id);

            $result = array();

            $result[] = array(
                
                'course_id' => $data->courses->id,
                'user_id' => $data->user_id,
                'instructor_id' => $data->instructor_id,
                'title' => $data->title,
                'accept' => $data->accept,
            );
            return response()->json(array('report_review_id'=>$result));
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function deleteappointment(Request $request, $id) {

    $validator = Validator::make($request->all(), [
        'secret' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['Secret Key is required'], 402);
    }

    $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

    if (!$key) {
        return response()->json(['Invalid Secret Key !'], 400);
    }

    if(Appointment::where('id', $id)->exists()) {
        $data = Appointment::find($id);
        $data->delete();

        return response()->json([
          "message" => "records deleted"
        ]);

    } else {
        return response()->json([
          "message" => "data not found"
        ], 404);
        }
    }
    
        public function previouspaper(Request $request){

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $previouspapers = PreviousPaper::all();

        return response()->json(array('previouspapers' =>$previouspapers), 200);
    }

    public function previouspaperbyid(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (PreviousPaper::where('id', $id)->exists()) {

            $data = PreviousPaper::findOrFail($id);

            $result = array();

            $result[] = array(
                
                'course_id' => $data->courses->id,
                'title' => $data->title,
                'detail' => $data->detail,
                'status' => $data->status,
                'file' => $data->file,
            );
            return response()->json(array('review_rating_id'=>$result));
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function createpreviouspaper(Request $request) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'title' => 'required',
            'detail' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

           if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if($errors->first('title')){
                return response()->json(['message' => $errors->first('title'), 'status' => 'fail']);
            }

            if($errors->first('course_id')){
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }

            if($errors->first('detail')){
                return response()->json(['message' => $errors->first('detail'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::user();

        $data = new PreviousPaper;
        $data->course_id = $request->course_id;
        $data->title = $request->title;
        $data->detail = $request->detail;
        if($file = $request->file('file'))
        {
            $path = 'files/papers/';

            if(!file_exists(public_path().'/'.$path)) {
                
                $path = 'files/papers/';
                File::makeDirectory(public_path().'/'.$path,0777,true);
            } 

            $filename = time().$file->getClientOriginalName();
            $file->move('files/papers',$filename);
            $input['file'] = $filename;
        }
        $data->file =  $input['file'];
        $data->status = $request->status;
        $data->save();

        return response()->json([
            "message" => "created successfully",
            'previous_paper_created' => $data
        ]);
    }
    
    public function updatepreviouspaper(Request $request, $id)
    {
        $data = $this->validate($request,[
            'title' => 'required',
        ]);

        $data = PreviousPaper::findorfail($id);
        $input = $request->all();

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        if($file = $request->file('file'))
        {
            if($data->file != "")
            {
                $path = 'files/papers/';

                if(!file_exists(public_path().'/'.$path)) {
                    
                    $path = 'files/papers/';
                    File::makeDirectory(public_path().'/'.$path,0777,true);
                } 
                
                $chapter_file = @file_get_contents(public_path().'/files/papers/'.$data->file);

                if($chapter_file)
                {
                    unlink('files/papers/'.$data->file);
                }
            }
            $name = time().$file->getClientOriginalName();
            $file->move('files/papers', $name);
            $input['file'] = $name;
        }

        $data->update($input);

        return response()->json(array('previous_paper_updated' =>$data), 200);

    }
    
    public function deletepreviouspaper(Request $request, $id) {

    $validator = Validator::make($request->all(), [
        'secret' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['Secret Key is required'], 402);
    }

    $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

    if (!$key) {
        return response()->json(['Invalid Secret Key !'], 400);
    }

    if(PreviousPaper::where('id', $id)->exists()) {
        $data = PreviousPaper::find($id);
        $data->delete();

        return response()->json([
          "message" => "records deleted"
        ]);

    } else {
        return response()->json([
          "message" => "data not found"
        ], 404);
        }
    }

    public function reviewrating(Request $request){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
           $data = ReviewRating::get();

        $result = array();

        foreach ($data as $review) {

            $result[] = array(
                'id' => $review->id,
                'review' => $review->review,
                'course_id' => $review->courses->id,
                'course_name' => $review->courses->title,
                'user_id' => $review->user->id,
                'user_name' => $review->user->fname,
                'learn' => $review->learn,
                'price' => $review->price,
                'value' => $review->value,
                'status' => $review->status,
                'approved' => $review->approved,
                'featured' => $review->featured,
                'created_at' => $review->created_at,
                'updated_at' => $review->updated_at,
            );
        }

        return response()->json(array('review'=>$result), 200); 
    }

    // public function reviewratingbyid(Request $request, $id){
    
    //     $validator = Validator::make($request->all(), [
    //         'secret' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['Secret Key is required'], 402);
    //     }

    //     $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

    //     if (!$key) {
    //         return response()->json(['Invalid Secret Key !'], 400);
    //     }

    //     if (ReviewRating::where('id', $id)->exists()) {

    //         $data = ReviewRating::findOrFail($id);

    //         $result = array();

    //         $result[] = array(
                
    //             'course_id' => $data->courses->id,
    //             'user_id' => $data->user_id,
    //             'learn' => $data->learn,
    //             'review' => $data->review,
    //             'price' => $data->price,
    //             'value' => $data->value,
    //             'status' => $data->status,
    //             'approved' => $data->approved,
    //         );
    //         return response()->json(array('review_rating_id'=>$result));
    //     } else {
    //         return response()->json([
    //           "message" => "data not found"
    //         ], 404);
    //     }
    // }
    
    public function reviewratingbyid(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
            'user_id' => 'required',
            'learn' => 'required',
            'price' => 'required',
            'value' => 'required',
            'review' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        // $input = $request->all();
        $input['course_id'] = $request->course_id;
        $input['user_id'] = $request->user_id;
        $input['learn'] = $request->learn;
        $input['price'] = $request->price;
        $input['value'] = $request->value;
        $input['review'] = $request->review;
        $input['status'] = $request->status;
        $input['approved'] = $request->approved;
        $input['featured'] = $request->featured;
        $data = ReviewRating::whereId($id)->update($input);
        return response()->json([
            "message" => "records updated successfully",
            'data'=>$input
        ]);
    }

    public function deletereviewrating(Request $request, $id) {
    $validator = Validator::make($request->all(), [
        'secret' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['Secret Key is required'], 402);
    }

    $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

    if (!$key) {
        return response()->json(['Invalid Secret Key !'], 400);
    }

    if(ReviewRating::where('id', $id)->exists()) {
        $data = ReviewRating::find($id);
        $data->delete();

        return response()->json([
          "message" => "records deleted"
        ]);

    } else {
        return response()->json([
          "message" => "data not found"
        ], 404);
        }
    }
    
    public function getblogs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $show = Blog::all();

        return response()->json(array('blog' =>$show), 200);
    }

    public function getblogsbyid(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Blog::where('user_id', Auth::user()->id)->exists()) {

            $blogs = Blog::where('id', $id)->get();

            $result = array();
            foreach ($blogs as $data) {
                $result[] = array(
                    'id' => $data->id,
                    'course_id' => $data->courses->id,
                    'heading' => $data->heading,
                    'detail' => $data->detail,
                    'text' => $data->text,
                    'approved' => $data->approved,
                );
            }

            return response()->json(array('data' => $result));

        } else {
            return response()->json([
                "message" => "blog not found",
            ], 404);
        }

    }

    public function createblog(Request $request) {

        $data = $this->validate($request,[
            'date' => 'required',
            'image'=>'required',
            'heading' => 'required',
            'text' => 'required',
            'detail' => 'required',
            'slug' => 'required',
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
            if ($file = $request->file('image')) 
             {            
              $optimizeImage = Image::make($file);
              $optimizePath = public_path().'/images/blog/';
              $image = time().$file->getClientOriginalName();
              $optimizeImage->save($optimizePath.$image, 72);
              $input['image'] = $image;         
              
            }
        }

        $start_time = date('Y-m-d\TH:i:s', strtotime($request->date));

        $input['date'] = $start_time;

        $data = Blog::create($input); 

        if(isset($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }

        if(isset($request->approved))
        {
            $data->approved = '1';
        }
        else
        {
            $data->approved = '0';
        }

        $data->save();
        return response()->json(array('blog_created' =>$data), 200);

    }

    public function updateblog(Request $request, $id)
    {

        $blog = Blog::findOrFail($id);

        $input = $request->all();


        if(Auth::user()->role == 'admin')
        {
            if ($request->image != null) {

                $input['image'] = $request->image;

            }
            else{
                $input['image'] = $blog->image;
            }
        }

        if(Auth::user()->role == 'instructor')
        {
            if ($file = $request->file('image')) 
            { 
              if($blog->image != "")
              {
                $image_file = @file_get_contents(public_path().'/images/blog/'.$blog->image);

                if($image_file)
                {
                    unlink(public_path().'/images/blog/'.$blog->image);
                }
              }       
              $optimizeImage = Image::make($file);
              $optimizePath = public_path().'/images/blog/';
              $image = time().$file->getClientOriginalName();
              $optimizeImage->save($optimizePath.$image, 72);

              $input['image'] = $image;
                           
            }
        }
        
        $start_time = date('Y-m-d\TH:i:s', strtotime($request->date));

        $input['date'] = $start_time;

        if(isset($request->approved))
        {
            $input['approved'] = '1';
        }
        else
        {
            $input['approved'] = '0';
        }

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        $blog->update($input);

        return response()->json(array('blog_updated' =>$blog), 200);

    }

    public function deleteblog(Request $request, $id) {

    $validator = Validator::make($request->all(), [
        'secret' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['Secret Key is required'], 402);
    }

    $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

    if (!$key) {
        return response()->json(['Invalid Secret Key !'], 400);
    }

    if(Blog::where('id', $id)->exists()) {
        $data = Blog::find($id);
        $data->delete();

        return response()->json([
          "message" => "records deleted"
        ]);

    } else {
        return response()->json([
          "message" => "data not found"
        ], 404);
        }
    }
    
    public function createinstitute(Request $request)
    {
        $request->validate([
            "title" => "required",
            "detail" => "required",
            "skill" => "required",
            "mobile" => "required|digits:10",
            "email" => "required|email",

        ]);
        $institute['title'] = strip_tags($request->title);
        $institute['detail'] = strip_tags($request->detail);
        $institute['user_id'] = Auth::user()->id;
        $institute['skill'] = strip_tags($request->skill);
        $institute['mobile'] = strip_tags($request->mobile);
        $institute['affilated_by'] = strip_tags($request->affilated_by);
        $institute['email'] = strip_tags($request->email);
        $institute['address'] = strip_tags($request->address);

        

        if ($file = $request->file('image')) {

            $validator = Validator::make(
                [
                    'file' => $request->image,
                    'extension' => strtolower($request->image->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|mimes:jpg,png',
                ]
            );
            
            if ($file = $request->file('image')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('files/institute', $name);
                $institute['image'] = $name;
            }
        }
        $institute = Institute::create($institute);

        return response()->json(array('institute_created' =>$institute), 200);
    }
    
    public function updateinstitute(Request $request,$id)
    {
        $request->validate([
            "title" => "required",
            "detail" => "required",
            "skill" => "required",
            "mobile" => "required",
            "email" => "required",

        ]);

        $data = Institute::findOrFail($id);
        $institute['title'] = strip_tags($request->title);
        $institute['detail'] = strip_tags($request->detail);
        $institute['mobile'] = strip_tags($request->mobile);
        $institute['affilated_by'] = strip_tags($request->affilated_by);
        $institute['email'] = strip_tags($request->email);
        $institute['address'] = strip_tags($request->address);
        $institute['skill'] = strip_tags($request->skill);
        
        if ($file = $request->file('image')) {

            $validator = Validator::make(
                [
                    'file' => $request->image,
                    'extension' => strtolower($request->image->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|mimes:jpg,png',
                ]
            );

            if ($validator->fails()) {
                return back()->withErrors('Invalid file !');
            }

            if ($file = $request->file('image')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('files/institute', $name);
                $institute['image'] = $name;
            }
        }

        $data->update($institute);
        return response()->json(array('institute_updated' =>$data), 200);

    }
     public function getAllanswers(Request $request){
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

         $auth = Auth::user();
        $answer = Answer::get();

        $result = array();

        foreach ($answer as $data) {

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'course' => $data->courses->title,
                'instructor_id' => $data->instructor->id,
                'user' => optional($data->instructor)['fname'] . ' ' . optional($data->instructor)['lname'],
                'ans_user_id'=> $data->user->id,
                'ans_user_name'=>$data->user->fname,
                'question_id' => $data->question->id,
                'question_name' => $data->question->question,
                'ques_user_id'=>$data->ques_user_id,
                'answer' => $data->answer,
                'status'=>$data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('course_answer'=>$result));
    }
      public function createanswers(Request $request) {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
        $data = new Answer;
        $data->answer = $request->answer;
        $data->ans_user_id = $auth->id;
        $data->instructor_id = $auth->id;
        $data->question_id = $request->question_id;
        $data->course_id = $request->course_id;
        $data->ques_user_id = $request->ques_user_id;
        $data->status = $request->status;
        $data->save();

        return response()->json([
            "message" => "created successfully",
            'course_answers'=>$data
        ]);
    }
    public function updateanswers(Request $request, $id){
          $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();

        if (Answer::where('id', $id)->exists()) {
            $data = Answer::find($id);

            $data->answer = isset($request->answer) ? $request->answer : $data->answer;
            $data->ans_user_id = isset($auth->id) ? $auth->id : $data->ans_user_id;
            $data->instructor_id = isset($auth->id) ? $auth->id : $data->instructor_id;
            $data->question_id = isset($request->question_id) ? $request->question_id : $data->question_id;
            $data->course_id = isset($request->course_id) ? $request->course_id : $data->course_id;
            $data->ques_user_id = isset($request->ques_user_id) ? $request->ques_user_id : $data->ques_user_id;
            $data->status = isset($request->status) ? $request->status : $data->status;
            $data->save();

            return response()->json([
              "message" => "records updated successfully",
              'questions'=>$data
            ]);
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function deleteanswer(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(Answer::where('id', $id)->exists()) {
            $data = Answer::find($id);
            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }
    
    public function appointment1(Request $request, $id)
    {
        
    $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        
        $auth = Auth::guard('api')->user();
        if (Appointment::where('id', $id)->exists()) {
             $data = Appointment::findOrFail($id);
            
            $data->course_id = isset($request->course_id) ? $request->course_id : $data->course_id;
            $data->accept = isset($request->accept) ? $request->accept : $data->accept;
            $data->reply = isset($request->reply) ? $request->reply : $data->reply;
            $data->title = isset($request->title) ? $request->title : $data->title;
                        $data->save();

            return response()->json([
              "message" => "records updated successfully",
              'appointment'=>$data
            ]);
        }
        else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }

      

    }
    public function deleteappoint(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        Appointment::where('id', $id)->delete();

        return response()->json('Deleted Successfully !', 200);

    }
    
    public function review(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

         $review = ReviewRating::where('course_id', $request->course_id)->get();
         $result = array();

        foreach ($review as $data) {

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'course' => $data->courses->title,
                 'user_id' => $data->user_id,
                'user' => $data->user->fname,
                'learn' => $data->learn,
                'price' => $data->price,
                'value'=> $data->value,
                'review'=>$data->review,
                'approved' => $data->approved,
                'featured' => $data->featured,
                'status'=>$data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }


        if ($result) {

            return response()->json(array('review' => $result), 200);
        } else {
            return response()->json(array('error'), 401);
        }
    }
    public function getappointment(Request $request){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

         $auth = Auth::user();
        $appointment = Appointment::get();

        $result = array();

        foreach ($appointment as $data) {

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'course' => $data->courses->title,
                'user_id' => $data->user->id,
                'user' => optional($data->instructor)['fname'] . ' ' . optional($data->instructor)['lname'],
                'title'=> $data->title,
                'detail'=>$data->detail,
                'start_time' => $data->start_time,
                'request' => $data->request,
                'ques_user_id'=>$data->ques_user_id,
                'accept' => $data->accept,
                'files'=>$data->files,
                'reply'=>$data->reply,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('appointment'=>$result));
    }
    
    public function rejectcourse(Request $request){
         $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
         $course = Course::where('reject_txt', '!=', NULL)->get();


        $result = array();

        foreach ($course as $data) {

            $result[] = array(
                'id' => $data->id,
                'image' => url('images/course/' . $data->preview_image),
                'course name' => $data->title,
                'instructor_id' => $data->user->id,
                'instructor_name' => $data->user->fname,
                'slug'=>$data->slug,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('course'=>$result));
    }
    public function rejectcourseaction(Request $request){
          $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
         $course = Course::where('reject_txt', '!=', NULL)->get();


        $result = array();

        foreach ($course as $data) {

            $result[] = array(
                'id' => $data->id,
                'image' => url('images/course/' . $data->preview_image),
                'title' => $data->title,
                'course name' => $data->title,
                'instructor_id' => $data->user->id,
                'instructor_name' => $data->user->fname,
                'detail'=>$data->detail,
                'reject'=>$data->reject_txt,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }
        return response()->json(array('course'=>$result));
    }
    
    public function institute(Request $request){
        
          $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
        $ins = Institute::where('user_id',$auth->id)->get();


        $result = array();

        foreach ($ins as $data) {

            $result[] = array(
                'id' => $data->id,
                'image' => url('files/institute/' . $data->image),
                'title' => $data->title,
                'detail' => $data->detail,
                'user_id' => $data->user_id,
               'status'=>$data->status,
                'verified'=>$data->verified,
                'skill'=>$data->skill,
                 'email'=>$data->email,
                  'mobile'=>$data->mobile,
                  'affilated_by'=>$data->affilated_by,
                  'address'=>$data->address,
                  'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('Institute'=>$result));
    }
    
    public function deleterejectcourse(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        if(Course::where('id', $id)->exists()) {
            $category = Course::find($id);

            $category->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "Rejected Course Not Found"
            ], 404);
        }
    }
    
    public function quiz_review(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        $auth = Auth::user();
        $answers = QuizAnswer::where('type', '1')->where('user_id',$auth->id)->get();
        $datas = [];
        foreach($answers as $key => $answer){
            $info['course'] = $answer->courses->title;
            $user = User::where('id',$answer->user_id)->first();
            $info['user'] = $user->fname.' '.$user->lname;
            $info['topic'] = $answer->topic->title;
            $info['question'] = $answer->quiz->question;
            $info['answer'] = $answer->txt_answer;
            array_push($datas, $info);
        }
        
        return response()->json([
           
            'datas' => $datas
          ]);
    }
    public function deleteinstitute(Request $request, $id){
        //return $id;
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        if(Institute::where('id', $id)->exists()) {
            $data = Institute::find($id);

            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "Institute Deleted"
            ], 404);
        }
    }
    public function instructorfeatured(Request $request){
          $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
         $course = FeaturePayment::get();


        $result = array();

        foreach ($course as $data) {

            $result[] = array(
                'id' => $data->id,
                'user_id' => $data->user_id,
                'user_name'=>$data->user->fname,
                'course_id' => $data->course_id,
                'course_name' => $data->courses->title,
                  'total_amount'=>$data->total_amount,
                  'transaction_id'=>$data->transaction_id,
                  'payment_method'=>$data->payment_method,
                  'currency'=>$data->currency,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('featuredcourse'=>$result));
    }
    public function deleteinstructorfeatured(Request $request, $id){
     $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        //return $id;
        if(FeaturePayment::where('id', $id)->exists()) {
            //return 'x';
            $data = FeaturePayment::find($id);

            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "FeatureCourse Deleted"
            ], 404);
        }
    }
    public function instructorfeaturedpayment(Request $request){
       $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
         $course = FeaturePayment::get();


        $result = array();

        foreach ($course as $data) {

            $result[] = array(
                'id' => $data->id,
                'user_id' => $data->user_id,
                'user_name'=>$data->user->fname,
                'course_id' => $data->course_id,
                'course_name' => $data->courses->title,
                 'total_amount'=>$data->total_amount,
                 'transaction_id'=>$data->transaction_id,
                 'Currency'=>$data->currency,
                 'featured'=>$data->featured,
                 'payment_method'=>$data->payment_method,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('course'=>$result));  
    }
    public function updatereviewrating(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (ReviewRating::where('id', $id)->exists()) {
            $data = ReviewRating::find($id);

            $data->review = isset($request->review) ? $request->review : $data->review;
            $data->status = isset($request->status) ? $request->status : $data->status;
            $data->approved = isset($request->approved) ? $request->approved : $data->approved;
            $data->featured = isset($request->featured) ? $request->featured : $data->featured;

            $data->save();

            return response()->json([
              "message" => "records updated successfully",
              'language'=>$data
            ]);
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }
    public function requestinvolve(Request $request){
         $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
        $all_course = Course::where('involvement_request','1')->where('user_id', '!=', Auth::user()->id)->get();
      
        $result = array();

        foreach ($all_course as $data) {

            $result[] = array(
                'id' => $data->id,
                'image' => url('images/course/' . $data->preview_image),
                'title' => $data->title,
                'slug'=>$data->slug,
                'featured' => $data->featured,
                'status' => $data->status,
                
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('all_course'=>$result));  
    }
    public function updaterequest(Request $request, $id){
          $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Involvement::where('id', $id)->exists()) {
            $data = Involvement::find($id);

            $data->reason = isset($request->reason) ? $request->reason : $data->reason;
            $data->status = '1';

            $data->save();

            return response()->json([
              "message" => "records updated successfully",
              'request'=>$data
            ]);
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }
    public function involvementcourses(Request $request){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
        $involve_requests = Involvement::where('status','1')->get();
        $result = array();

        foreach ($involve_requests as $data) {

            $result[] = array(
                'id' => $data->id,
                'image' => url('images/course/' . $data->course->preview_image),
                'user_id' => $data->user_id,
                'user_name' => $data->user->fname,
                'course_id' => $data->course_id,
                'course_name' => $data->course->title,
                'reason'=>$data->reason,
                'status' => $data->status,
                'featured' => $data->course->featured,
                'slug' => $data->course->slug,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('involve_course'=>$result));  
    }
        public function deleteinvolvementcourses(Request $request, $id){
                $validator = Validator::make($request->all(), [
            'secret' => 'required',
            ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        if(Involvement::where('id', $id)->exists()) {
            $data = Involvement::find($id);

            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "Involvement Deleted"
            ], 404);
        }
    }
        public function applycourses(Request $request){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $involve_requests = Course::where('involvement_request','1')->where('user_id', '!=', Auth::user()->id)->get();
    
        $result = array();

        foreach ($involve_requests as $data) {

            $result[] = array(
                'id' => $data->id,
                'image' => url('images/course/' . $data->preview_image),
                'user_id' => $data->user_id,
                'user_name' => $data->user->fname,
                'course_id' => $data->id,
                'involvement_id' => Involvement::where('course_id',$data->id)->value('id'),
                'course_name' => $data->title,
                'reason'=> Involvement::where('course_id',$data->id)->value('reason'),
                'status' => $data->status,
                'featured'=>$data->featured,
                'slug'=>$data->slug,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('involve_requests'=>$result));  
    }
    public function quizreport(Request $request){
     $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
        $user = User::where('role', '=', 'user')->with('courses')->get();
        $result = array();

        foreach ($user as $data) {

            $result[] = array(
                'id' => $data->id,
                'user_name' => $data->fname,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('quizreport'=>$result));  
    }
    public function quizreportbyid(Request $request ,$id){
            
            $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
        
        $quiz = QuizTopic::join('quiz_questions','quiz_questions.topic_id','=','quiz_topics.id')

            ->join('quiz_answers','quiz_answers.question_id','=','quiz_questions.id')
            ->join('users','quiz_answers.user_id','=','users.id')
            ->select(
                'users.fname as fname','users.lname as lname','users.email as useremail',
                'quiz_topics.title->en as topictitle','quiz_topics.per_q_mark','quiz_topics.id as topicid',
                'quiz_answers.type as answer_type','quiz_answers.user_answer','quiz_answers.answer','quiz_answers.txt_approved','quiz_answers.course_id','quiz_questions.id'
              )
            ->withCount('quizquestion')
            ->groupBy('quiz_topics.id')
            ->where('quiz_answers.user_id','=',$id)
            ->get();
            
        $result = array();

        foreach ($quiz as $data) {

            $result[] = array(
                'id' => $data->id,
                'user_name' => $data->fname,
                'email' => $data->useremail,
                'title' =>$data->topictitle,
                'marks_get' =>$data->per_q_mark,
                'total_marks' =>$data->quizquestion_count * $data->per_q_mark,
                
            );
        }

        return response()->json(array('quizreport'=>$result));  
    }
    public function jitsicreate(Request $request){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $jitsimeeting = new JitsiMeeting;
        $auth = Auth::user();
        $jitsimeeting->meeting_title = $request->meeting_title;
        $jitsimeeting->meeting_id = mt_rand(1000000000, 9999999999);
        $jitsimeeting->start_time = date('Y-m-d h:i:s',strtotime($request->start_time));
        $jitsimeeting->end_time = date('Y-m-d h:i:s',strtotime($request->end_time));
        $jitsimeeting->duration = $request->duration;
        $jitsimeeting->agenda = $request->agenda;
        $jitsimeeting->time_zone = $request->time_zone;
        $jitsimeeting->user_id = $auth->id;
        $jitsimeeting->course_id = $request->course_id;
        $jitsimeeting->link_by = $request->link_by;
                $jitsimeeting->image = $request->image;

        $jitsimeeting->save();

        return response()->json([
            "message" => "Jitsimeeting created",
            'language'=>$jitsimeeting
        ]);
}
    public function getjitsi(Request $request){
    
      $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
                $auth = Auth::user();

        $data = JitsiMeeting::where('user_id', $auth->id)->get();
        return response()->json(array("Posted Jobs" => $data), 200);
}
    public function deletejitsi(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(JitsiMeeting::where('id', $id)->exists()) {
            $data = JitsiMeeting::find($id);
            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "language not found"
            ], 404);
        }
    }
    public function featuredcreate(Request $request){
         $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }
        $user = Auth::user();

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
                    $currency = Currency::where('default', '=', '1')->first();
        $created_order = new FeaturePayment;
        $created_order->course_id = $request->course_id;
        $created_order->user_id = $user->id;
        $created_order->transaction_id = $request->transaction_id;
        $created_order->payment_method = $request->payment_method;
        $created_order->total_amount = $request->total_amount;
        $created_order->currency = $request->currency;

         $created_order->currency_icon = $currency->symbol;
        $created_order->save();

        return response()->json([
            "message" => "ordered successfully",
            'order'=>$created_order
        ]);
    }
    public function function2(Request $request){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $auth = Auth::user();
        $involve_requests = Involvement::all();
        $result = array();

        foreach ($involve_requests as $data) {

            $result[] = array(
                'id' => $data->id,
                'image' => url('images/course/' . $data->preview_image),
                'user_id' => $data->user_id,
                'user_name' => $data->user->fname,
                'course_id' => $data->course_id,
                'course_name' => $data->course->title,
                'reason'=>$data->reason,
                'status' => $data->status,
                'featured' => $data->course->featured,
                'slug' => $data->course->slug,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('involve_requests'=>$result));  
    }
    
    public function involverequest(){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        $involve_requests = Involvement::all();
        return response()->json(array('request_involved'=>$involve_requests));
    }
    
    public function deleteinvolverequest($id){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(Involvement::where('id', $id)->exists()) {
            $data = Involvement::find($id);
            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }
    
    public function enrollUser(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
       
        if (!isset($user_id)) {
            return redirect('order/create');
        }
        $users = User::all();
        $selectedUser = User::findOrFail($user_id);

        $orders = Order::where('user_id', $user_id)->get();
        
        $enrolledCourses = [];
        $enrolledBundles = [];

        $enrolledCourseIds = [];
        $enrolledBundleIds = [];

        foreach ($orders as $order) {
            if ($order->course_id !== null) {
                array_push($enrolledCourseIds, $order->course_id);
                array_push($enrolledCourses, $order->courses);
            } else {
                array_push($enrolledBundleIds, $order->bundle_id);
                array_push($enrolledBundles, $order->bundle);
            }
        }

        $courses = Course::all()->whereNotIn('id', $enrolledCourseIds);
        $bundles = BundleCourse::all()->whereNotIn('id', $enrolledBundleIds);

        return response()->json(array('user'=> $users, 'course' =>$courses, 'bundles' =>$bundles, 'enrolledCourses'=> $enrolledCourses, 'selectedUser' => $selectedUser));
      
    }
    
    public function progressreport(Request $request){

         $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
		$user = User::all();
	    $progress = CourseProgress::all();

		return response()->json(array('progress' =>$progress, 'user' =>$user));
    }
    
    public function progressreportbyid(Request $request, $id){

         $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        if (CourseProgress::where('id', $id)->exists()) {
    		
    	    $progress = CourseProgress::where('id',$id)->get();
    
    	    
    	    return response()->json(array('progress' =>$progress));
        }
        else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }
    public function involveupdate(Request $request, $id){
         $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Involvement::where('id', $id)->exists()) {
            $data = Involvement::find($id);

        DB::table('involvements')->where('id',$id)
        ->update([

        'status' => $request->status,
        'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

            return response()->json(array('involve request'=>$data));
        }

        else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }
    public function involvedelete(Request $request, $id){
        //return $request;
          $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if(Involvement::where('id', $id)->exists()) {
             $data = Involvement::find($id);
            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }
    public function paymentupdate(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }
        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        if (User::where('id', Auth::user()->id)->exists()) {
            $user  =  User::findOrFail(Auth::user()->id);
            $payment_setting =  User::where('id',Auth::user()->id)->get();
            if($request->type == "paytm")
        {
            //return 'x';
            $data['paytm_mobile']  =  isset($request->paytm_mobile) ? $request->paytm_mobile : $user->paytm_mobile;
            $data['prefer_pay_method'] = "paytm";
            //return $data;
        }

        if($request->type == "paypal")
        {
            //return 'y';
            $data['paypal_email']  =  isset($request->paypal_email) ? $request->paypal_email : $user->paypal_email;
            $data['prefer_pay_method'] = "paypal";
        }

        if($request->type == "bank")
        {
            //return 'z';
            $data['bank_acc_name']  =  isset($request->bank_acc_name) ? $request->bank_acc_name : $user->bank_acc_name;
            $data['bank_acc_no']  =  isset($request->bank_acc_no) ? $request->bank_acc_no : $user->bank_acc_no;
            $data['ifsc_code']  =  isset($request->ifsc_code) ? $request->ifsc_code : $user->ifsc_code;
            $data['bank_name']  =  isset($request->bank_name) ? $request->bank_name : $user->bank_name;
            $data['prefer_pay_method'] = "banktransfer";
        }
        //return $data;
            $user->update($data);
            return response()->json([
              "message" => "Payment Setting  updated successfully",
              'user'=> $payment_setting
            ]);
        } else {
            return response()->json([
              "message" => "language not found"
            ], 404);
        }
}
    public function paymentsetting(Request $request){
      $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        $auth = Auth::user();
        if (User::where('id', $auth->id)->exists()) {
    		
    	    $user = User::where('id',$auth->id)->get();
    
    	    
    	    return response()->json(array('user' =>$user));
        }
        else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
}
 public function instructorrevenue(Request $request){

         $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
		$data = Setting::all();

		return response()->json(array('revenue' =>$data));
    }
}