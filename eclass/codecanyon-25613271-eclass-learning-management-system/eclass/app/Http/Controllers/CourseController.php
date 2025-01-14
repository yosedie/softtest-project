<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Image;
use App\CourseInclude;
use App\WhatLearn;
use App\QuestionBookPdf;
use App\CourseChapter;
use App\RelatedCourse;
use App\CourseClass;
use App\Categories;
use App\User;
use App\Wishlist;
use App\ReviewRating;
use App\Question;
use App\Announcement;
use App\Order;
use App\Answer;
use App\Cart;
use App\ReportReview;
use App\SubCategory;
use Session;
use App\QuizTopic;
use App\Quiz;
use Auth;
use Redirect;
use App\BundleCourse;
use App\CourseProgress;
use App\Adsense;
use App\Assignment;
use App\Appointment;
use App\BBL;
use App\Meeting;
use App\Currency;
use Cookie;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use App\PlanSubscribe;
use App\Setting;
use App\Googlemeet;
use App\JitsiMeeting;
use App\PreviousPaper;
use App\PrivateCourse;
use Illuminate\Support\Facades\Validator;
use File;
use App\Allcountry;
use App\CourseBackup;
use App\Coursereject;
use Modules\Certificate\Models\CertificateDesign;
use Spatie\Permission\Models\Role;
use Module;
use App\NoticeBoard;



class CourseController extends Controller
{
  public function __construct()
  {

    $this->middleware('permission:courses.view', ['only' => ['index', 'show','instructorCourseVerify','instructorCourseVerify']]);
    $this->middleware('permission:courses.create', ['only' => ['create', 'store']]);
    $this->middleware('permission:courses.edit', ['only' => ['update', 'status', 'courcestatus']]);
    $this->middleware('permission:courses.delete', ['only' => ['destroy', 'bulk_delete']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index(Request $request)
  {
    $searchTerm = $request->input('searchTerm');
    if (Auth::user()->role == 'instructor') {
      $cor = Course::query()->where('user_id', Auth::user()->id);
    } else {
      $cor = Course::query()->orderBy('created_at', 'desc');
    }


    $course = $cor->paginate(9);


    if ($request->searchTerm) {
      $course = $cor->where('title', 'LIKE', "%$searchTerm%")->where('status', '=', 1)->paginate(9);
    }
    if ($request->type) {
      $course = $cor->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate(9);
    }
    if ($request->featured) {
      $course = $cor->where('featured', '=', $request->featured ? '1' : '0')->paginate(9);
    }
    if ($request->status) {
      $course = $cor->where('status', '=', $request->status ? '1' : '0')->paginate(9);
    }
    if ($request->status) {
      $course = $cor->where('status', '=', $request->status ? '1' : '0')->paginate(9);
    }
    if ($request->asc) {
      $course = $cor->orderBy('title', 'ASC')->paginate(9);
    }
    if ($request->desc) {
      $course = $cor->orderBy('title', 'DESC')->paginate(9);
    }
    if ($request->category_id) {
      $course = $cor->where('category_id', '=', $request->category_id)->paginate(9);
    }


    $categorys = Categories::all();
    $coursechapter = CourseChapter::all();
    $gsettings = Setting::first();
    $paid = Course::where('type', '1')->count();
    $active = Course::where('status', '1')->count();
    $free = Course::where('type', '0')->count();
    $deactive = Course::where('status', '0')->count();


    return view('admin.course.index', compact("course", 'coursechapter', 'gsettings', 'categorys', 'paid', 'active', 'free', 'deactive'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function create()
  {
    $userid = auth()->user()->id;
    $category = Categories::all();

    $course = Course::all();
    $coursechapter = CourseChapter::all();

    if (Auth::user()->role == 'admin') {
      $users =  User::where('id', '!=', Auth::user()->id)->where('role', '!=', 'user')->get();
    } else {
      $users =  User::where('id', Auth::user()->id)->first();
    }

    $countries = Allcountry::get();

    return view('admin.course.insert', compact("course", 'coursechapter', 'category', 'users', 'countries'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function store(Request $request)
  {


    if (config('app.demolock') == 1) {
      return back()->with('delete', 'Disabled in demo');
    }

    $this->validate($request, [
      'category_id' => 'required',
      'subcategory_id' => 'required',
      'title' => 'required',
      'short_detail' => 'required',
      'video' => 'mimes:mp4,avi,wmv',
      'slug' => 'required|unique:courses,slug',
      'language_id' => 'required|not_in:0',
      'institude_id' => 'required|not_in:0',
      'course_tags' => 'required',
    ]);

    $input = $request->all();

    if (isset($request->preview_type)) {
      $input['preview_type'] = "video";
      if ($file = $request->file('video')) {

        $filename = time() . $file->getClientOriginalName();
        $file->move('video/preview', $filename);
        $input['video'] = $filename;
        $input['url'] = NULL;
      }
    } else {
      $input['preview_type'] = "url";
      $input['url'] = $request->url;
      $input['video'] = NULL;
    }
    if (Auth::user()->role == 'admin') {
      if ($request->preview_image != null) {
        $input['preview_image'] = $request->preview_image;
      }
    }


    if (Auth::user()->role == 'instructor') {
      if ($file = $request->file('preview_image')) {
        $optimizeImage = Image::make($file);
        $optimizePath = public_path() . '/images/course/';
        $image = time() . $file->getClientOriginalName();
        $optimizeImage->save($optimizePath . $image, 72);

        $input['preview_image'] = $image;
      }
    }


    if (isset($request->duration_type)) {
      $input['duration_type'] = "m";
    } else {
      $input['duration_type'] = "d";
    }

    if (isset($request->involvement_request)) {
      $input['involvement_request'] = "1";
    } else {
      $input['involvement_request'] = "0";
    }

    if (isset($request->assignment_enable)) {
      $input['assignment_enable'] = "1";
    } else {
      $input['assignment_enable'] = "0";
    }

    if (isset($request->appointment_enable)) {
      $input['appointment_enable'] = "1";
    } else {
      $input['appointment_enable'] = "0";
    }

    if (isset($request->certificate_enable)) {
      $input['certificate_enable'] = "1";
    } else {
      $input['certificate_enable'] = "0";
    }

    if (isset($request->type)) {
      $input['type'] = 1;
    } else {
      $input['type'] = 0;
    }

    if (isset($request->status)) {
      $input['status'] = 1;
    } else {
      $input['status'] = 0;
    }

    if (isset($request->type)) {
      $input['featured'] = 1;
    } else {
      $input['featured'] = 0;
    }
    if (isset($request->type)) {
      $input['drip_enable'] = 1;
    } else {
      $input['drip_enable'] = 0;
    }

    $data = Course::create($input);

    Session::flash('success', trans('flash.AddedSuccessfully'));
    return redirect('course')->withInput();
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $instructor_course = Course::where('id', $id)->where('user_id', Auth::user()->id)->first();

    if (Auth::user()->role != "instructor" && Auth::user()->role != "user") {

      if (!isset($instructor_course)) {
        abort(404, 'Page Not Found.');
      }
    }

    $cor = Course::find($id);

    $countries = Allcountry::get();

    return view('admin.course.editcor', compact('cor', 'countries'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */

  public function edit(course $course)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, $id)
  {

    $course = Course::find($id);
    if (config('app.demolock') == 1) {
      return back()->with('delete', 'Disabled in demo');
    }

    $request->validate([
      'category_id' => 'required',
      'subcategory_id' => 'required',
      'title' => 'required',
      'short_detail' => 'required',
      'video' => 'mimes:mp4,avi,wmv',
      'slug' => 'required|unique:courses,slug,' . $course->id,
      'language_id' => 'required|not_in:0',
      // 'institude_id' => 'required|not_in:0',
      // 'course_tags' => 'required'

    ]);
    $input = $request->all();


    if (isset($request->status)) {
      $input['status'] = "1";
    } else {
      $input['status'] = "0";
    }


    if (isset($request->featured)) {
      $input['featured'] = "1";
    } else {
      $input['featured'] = "0";
    }


    if (isset($request->type)) {
      $input['type'] = "1";
    } else {
      $input['type'] = "0";
    }


    if (Auth::user()->role == 'admin') {
      $request->validate([
        'course_tags' => 'required'
      ]);
      if ($request->preview_image != null) {

        $input['preview_image'] = $request->preview_image;
      } else {

        $input['preview_image'] = $course->preview_image;
      }
    }


    if (Auth::user()->role == 'instructor') {

      if ($file = $request->file('image')) {

        if ($course->preview_image != null) {
          $content = @file_get_contents(public_path() . '/images/course/' . $course->preview_image);
          if ($content) {
            unlink(public_path() . '/images/course/' . $course->preview_image);
          }
        }
        $optimizeImage = Image::make($file);
        $optimizePath = public_path() . '/images/course/';
        $image = time() . $file->getClientOriginalName();
        $optimizeImage->save($optimizePath . $image, 72);

        $input['preview_image'] = $image;
      }
    }


    if (isset($request->drip_enable)) {
      $input['drip_enable'] = 1;
    } else {
      $input['drip_enable'] = 0;
    }


    if (isset($request->preview_type)) {
      $input['preview_type'] = "video";
      if ($file = $request->file('video')) {
        if ($course->video != "") {
          $content = @file_get_contents(public_path() . '/video/preview/' . $course->video);
          if ($content) {
            unlink(public_path() . '/video/preview/' . $course->video);
          }
        }

        $filename = time() . $file->getClientOriginalName();
        $file->move('video/preview', $filename);
        $input['video'] = $filename;
        $input['url'] = NULL;
      }
    } else {
      $input['preview_type'] = "url";
      $input['url'] = $request->url;
      $input['video'] = NULL;
    }

    if (isset($request->duration_type)) {
      $input['duration_type'] = "m";
    } else {
      $input['duration_type'] = "d";
    }

    if (isset($request->involvement_request)) {
      $input['involvement_request'] = "1";
    } else {
      $input['involvement_request'] = "0";
    }

    if (isset($request->assignment_enable)) {
      $input['assignment_enable'] = "1";
    } else {
      $input['assignment_enable'] = "0";
    }

    if (isset($request->appointment_enable)) {
      $input['appointment_enable'] = "1";
    } else {
      $input['appointment_enable'] = "0";
    }

    if (isset($request->certificate_enable)) {
      $input['certificate_enable'] = "1";
    } else {
      $input['certificate_enable'] = "0";
    }

    Cart::where('course_id', $id)
      ->update([
        'price' => $request->price,
        'offer_price' => $request->discount_price,
      ]);
      
    $user_role = Auth::user()->roles[0]->name ?? 'No role set';
    if($user_role=='instructor' || Auth::user()->role == "instructor"){
      if(CourseBackup::whereId($id)->count()>0){
        CourseBackup::where('course_id',$id)->update($input);
      } else {
        $input['course_id'] = $id;
        CourseBackup::create($input);
      }      
    } else {
      $course->update($input);
    }
    Session::flash('success', trans('flash.UpdatedSuccessfully'));
    return redirect('course');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    
    if (Auth::user()->role == "admin") {

      $order = Order::where('course_id', $id)->get();

      if (config('app.demolock') == 0) {
          
        if (!$order->isEmpty()) {
          return back()->with('delete', trans('flash.CannotDelete'));
        } else {
            $course = Course::findOrFail(strip_tags($id));
          if ($course->preview_image != null) {

            $image_file = @file_get_contents(public_path() . '/images/course/' . $course->preview_image);

            if ($image_file) {
              unlink(public_path() . '/images/course/' . $course->preview_image);
            }
          }
          if ($course->video != null) {

            $video_file = @file_get_contents(public_path() . '/video/preview/' . $course->video);

            if ($video_file != null) {
              unlink(public_path() . '/video/preview/' . $course->video);
            }
          }

           $value = $course->delete();
          Wishlist::where('course_id', $id)->delete();
          Cart::where('course_id', $id)->delete();
          ReviewRating::where('course_id', $id)->delete();
          Question::where('course_id', $id)->delete();
          Answer::where('course_id', $id)->delete();
          Announcement::where('course_id', $id)->delete();
          CourseInclude::where('course_id', $id)->delete();
          WhatLearn::where('course_id', $id)->delete();
          CourseChapter::where('course_id', $id)->delete();
          RelatedCourse::where('course_id', $id)->delete();
          CourseClass::where('course_id', $id)->delete();

          return back()->with('delete', trans('flash.DeletedSuccessfully'));
        }
      } else {
        return back()->with('delete', trans('flash.DemoCannotdelete'));
      }
    }

    return back()->with('delete', 'You cannot delete course');
  }

  public function upload_info(Request $request)
  {

    $id = $request['catId'];
    $category = Categories::findOrFail($id);
    $upload = $category->subcategory->where('category_id', $id)->pluck('title', 'id')->all();

    return response()->json($upload);
  }


  public function gcato(Request $request)
  {

    $id = $request['catId'];

    $subcategory = SubCategory::findOrFail($id);
    $upload = $subcategory->childcategory->where('subcategory_id', $id)->pluck('title', 'id')->all();

    return response()->json($upload);
  }

  public function showCourse($id)
  {

    $userid = auth()->user()->id;
    $course = Course::all();

    $cor = Course::findOrFail($id);
    if (Auth::user()->role == 'admin') {
      $users =  User::where('role', '!=', 'user')->get();
    } else {
      $users =  User::where('id', Auth::user()->id)->first();
    }


    $courseinclude = CourseInclude::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $coursechapter = CourseChapter::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $whatlearns = WhatLearn::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $coursechapters = CourseChapter::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $relatedcourse = RelatedCourse::where('main_course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $courseclass = CourseClass::where('course_id', '=', $id)->orderBy('position', 'ASC')->get();
    $announsments = Announcement::where('course_id', '=', $id)->get();
    $reports = ReportReview::where('course_id', '=', $id)->get();
    $questions = Question::where('course_id', '=', $id)->get();
    $quizes = Quiz::where('course_id', '=', $id)->get();
    $topics = QuizTopic::where('course_id', '=', $id)->get();
    $appointment = Appointment::where('course_id', '=', $id)->get();

    $papers = PreviousPaper::where('course_id', '=', $id)->get();

    $countries = Allcountry::get();

    return view('admin.course.show', compact('cor', 'course', 'courseinclude', 'whatlearns', 'coursechapters', 'coursechapter', 'relatedcourse', 'courseclass', 'announsments', 'reports', 'questions', 'quizes', 'topics', 'appointment', 'papers', 'users', 'countries'));
  }



  
  public function CourseDetailPage( $slug)
  {
      $course = Course::where('slug',$slug)->firstOrFail();
      // Ensure course ID is not duplicated in session
      $recentlyViewed = session()->get('courses.recently_viewed', []);
      if (!in_array($course->id, $recentlyViewed)) {
          session()->push('courses.recently_viewed', $course->id);
      }
  
      $courseinclude = CourseInclude::where('course_id', $course->id)->orderBy('id', 'ASC')->get();
      $whatlearns = WhatLearn::where('course_id', $course->id)->orderBy('id', 'ASC')->get();
      $coursechapters = CourseChapter::where('course_id', $course->id)->orderBy('id', 'ASC')->get();
      $relatedcourse = RelatedCourse::where('status', 1)->where('main_course_id', $course->id)->get();
      $coursereviews = ReviewRating::where('course_id', $course->id)->get();
      $courseclass = CourseClass::orderBy('position', 'ASC')->get();
      $reviews = $coursereviews;
      $bundle_check = BundleCourse::first();
      $currency = Currency::first();
      $bigblue = BBL::where('course_id', $course->id)->get();
      $meetings = Meeting::where('course_id', $course->id)->get();
      $googlemeetmeetings = Googlemeet::where('course_id', $course->id)->get();
      $jitsimeetings = JitsiMeeting::where('course_id', $course->id)->get();
      $ad = Adsense::first();
      $setting = Setting::first();
  
      if (Auth::check()) {
          $private_courses = PrivateCourse::where('course_id', $course->id)->first();
  
          if ($private_courses) {
              $user_id = array_flatten(array_filter([$private_courses->user_id]));
  
              if (in_array(Auth::user()->id, $user_id)) {
                  return back()->with('delete', trans('flash.UnauthorizedAction'));
              }
          }
  
          $user_id = Auth::user()->id;
          $order = Order::where([
              ['refunded', '0'],
              ['status', '1'],
              ['user_id', $user_id],
              ['course_id', $course->id]
          ])->first();
          $wish = Wishlist::where('user_id', $user_id)->where('course_id', $course->id)->first();
          $cart = Cart::where('user_id', $user_id)->where('course_id', $course->id)->first();
          $instruct_course = Course::where('id', $course->id)->where('user_id', $user_id)->first();
  
          if (!empty($bundle_check) && Auth::user()->role == 'user') {
              $bundle_orders = Order::where('user_id', $user_id)->whereNotNull('bundle_id')->get();
              $course_id = [];
  
              foreach ($bundle_orders as $b) {
                  $bundle = BundleCourse::find($b->bundle_id);
                  if ($bundle) {
                      $course_id[] = $bundle->course_id;
                  }
              }
  
              $course_id = array_flatten(array_filter($course_id));
  
              $view = $setting->theme == '1' ? 'front.course_detail' : 'theme_2.front.course_detail';
              return view($view, compact(
                  'course', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews',
                  'relatedcourse', 'course_id', 'ad', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings',
                  'order', 'wish', 'currency', 'cart', 'instruct_course'
              ));
          } else {
              $view = $setting->theme == '1' ? 'front.course_detail' : 'theme_2.front.course_detail';
              return view($view, compact(
                  'course', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews',
                  'relatedcourse', 'ad', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings', 'order',
                  'wish', 'currency', 'cart', 'instruct_course'
              ));
          }
      } else {
          $view = $setting->theme == '1' ? 'front.course_detail' : 'theme_2.front.course_detail';
          return view($view, compact(
              'course', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews',
              'relatedcourse', 'ad', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings', 'currency'
          ));
      }
  }

  
  public function CourseContentPage($slug)
  {
    $course = Course::where('slug', $slug)->with(['user', 'chapter', 'chapter.courseclass'])->first();

    $coursequestions = Question::where('course_id', '=', $course->id)->with('user')->get();

    $announsments = Announcement::where('course_id', '=', $course->id)->with('user')->get();
    $noticeboards = NoticeBoard::where('course_id', '=', $course->id)->where('status' ,1)->get();
    $questionspdf = QuestionBookPdf::where('course_id', '=', $course->id)->first();

    $bigblue = BBL::where('course_id', '=', $course->id)->get();

    $meetings = Meeting::where('course_id', '=', $course->id)->with('user')->get();
    $googlemeetmeetings = Googlemeet::where('course_id', '=', $course->id)->get();
    $jitsimeetings = JitsiMeeting::where('course_id', '=', $course->id)->get();

    $papers = PreviousPaper::where('course_id', '=', $course->id)->get();


    if (Auth::check()) {

      $progress = CourseProgress::where('course_id', '=', $course->id)->where('user_id', Auth::User()->id)->first();

      $assignment = Assignment::where('course_id', '=', $course->id)->where('user_id', Auth::User()->id)->get();

      $appointment = Appointment::where('course_id', '=', $course->id)->where('user_id', Auth::User()->id)->get();
      if(Module::has('Certificate') && Module::find('Certificate')->isEnabled())
      $certificate_setting = CertificateDesign::first();
      else
      $certificate_setting = '0';
      $setting = Setting::first();
      if($setting->theme == '1'){
      return view('front.course_content', compact('questionspdf','noticeboards','course', 'coursequestions', 'announsments', 'progress', 'assignment', 'appointment', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings', 'papers','certificate_setting'));
      }
      return view('theme_2.front.course_content', compact('questionspdf','noticeboards','course', 'coursequestions', 'announsments', 'progress', 'assignment', 'appointment', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings', 'papers','certificate_setting'));

    }

    return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
  }

  public function mycoursepage()
  {
    if (Auth::check()) {
      $course = Course::all();
      $enroll = Order::where('refunded', '0')->where('status', '1')->where('user_id', Auth::user()->id)->get();
      $setting = Setting::first();
      if($setting->theme == '1'){
      return view('front.my_course', compact('course', 'enroll'));
      }
      return view('theme_2.front.my_course', compact('course', 'enroll'));
    }

    return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
  }
  public function status(Request $request)
  {

    $course = Course::find($request->id);
    $course->status = $request->status;
    $course->save();
    return back()->with('success', trans('flash.UpdatedSuccessfully'));
  }
  public function duplicate($id)
  {

    $existingOpening = Course::find($id);

    // $newOpenening = $existingOpening->replicate();

    if ($existingOpening->preview_image == !NULL && @file_get_contents(public_path() . 'images/course/' . $existingOpening->preview_image)) {
      $oldPath = public_path('images/course/' . $existingOpening->preview_image); // publc/images/1.jpg

      $fileExtension = \File::extension($oldPath);

      $newName = 'duplicate' . time() . '.' . $fileExtension;

      $newPathWithName = public_path('images/course/' . $newName);

      \File::copy($oldPath, $newPathWithName);
    } else {

      $newName = NULL;
    }

    if ($existingOpening->video == !NULL && @file_get_contents(public_path() . 'video/preview/' . $existingOpening->video)) {
      $oldPath = public_path('video/preview/' . $existingOpening->video); // publc/images/1.jpg

      $fileExtension = \File::extension($oldPath);

      $newVideo = 'duplicate' . time() . '.' . $fileExtension;

      $newPathWithName = public_path('video/preview/' . $newVideo);

      \File::copy($oldPath, $newPathWithName);
    } else {

      $newVideo = NULL;
    }



    $newOpenening = $existingOpening->replicate()->fill(
      [
        'preview_image' => $newName,
      ]
    );

    $newOpenening = $existingOpening->replicate()->fill(
      [
        'slug' => str_slug($existingOpening->slug . '-copy-' . time() . $existingOpening->id, '-'),
      ]
    );




    $newOpenening->save();


    $old_courseinclude = CourseInclude::where('course_id', $existingOpening->id)->get();

    foreach ($old_courseinclude as $include) {
      $new_courseinclude = $include->replicate()->fill(
        [
          'course_id' => $newOpenening->id,
        ]
      );

      $new_courseinclude->save();
    }

    $old_whatlearn = WhatLearn::where('course_id', $existingOpening->id)->get();

    foreach ($old_whatlearn as $whatlearn) {

      $new_whatlearn = $whatlearn->replicate()->fill(
        [
          'course_id' => $newOpenening->id,
        ]
      );

      $new_whatlearn->save();
    }


    $old_chapter = CourseChapter::where('course_id', $existingOpening->id)->get();

    foreach ($old_chapter as $chapter) {

      $new_chapter = $chapter->replicate()->fill(
        [
          'course_id' => $newOpenening->id,
          'file' => NULL,
        ]
      );

      $new_chapter->save();

      $old_class = CourseClass::where('coursechapter_id', $chapter->id)->get();




      foreach ($old_class as $class) {



        if ($class->video == !NULL && @file_get_contents(public_path() . 'video/class/' . $class->video)) {

          $oldPathVideo = public_path('video/class/' . $class->video); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathVideo);

          $newclassVideo = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithVideo = public_path('video/class/' . $newclassVideo);

          \File::copy($oldPathVideo, $newPathWithVideo);
        } else {

          $newclassVideo = NULL;
        }


        if ($class->pdf == !NULL && @file_get_contents(public_path() . 'files/pdf/' . $class->pdf)) {

          $oldPathPDF = public_path('files/pdf/' . $class->pdf); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathPDF);

          $newclassPDF = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithPDF = public_path('files/pdf/' . $newclassPDF);

          \File::copy($oldPathPDF, $newPathWithPDF);
        } else {

          $newclassPDF = NULL;
        }


        if ($class->zip == !NULL && @file_get_contents(public_path() . 'video/class/' . $class->zip)) {

          $oldPathZIP = public_path('video/class/' . $class->zip); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathZIP);

          $newclassZIP = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithZIP = public_path('video/class/' . $newclassZIP);

          \File::copy($oldPathZIP, $newPathWithZIP);
        } else {

          $newclassZIP = NULL;
        }


        if ($class->preview_video == !NULL && @file_get_contents(public_path() . 'video/class/' . $class->preview_video)) {

          $oldPathPreview = public_path('video/class/preview/' . $class->preview_video); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathPreview);

          $newclassPreview = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithPreview = public_path('video/class/preview/' . $newclassPreview);

          \File::copy($oldPathPreview, $newPathWithPreview);
        } else {

          $newclassPreview = NULL;
        }


        if ($class->audio == !NULL && @file_get_contents(public_path() . 'video/class/' . $class->audio)) {

          $oldPathAUDIO = public_path('video/class/' . $class->video); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathAUDIO);

          $newclassVideo = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithAUDIO = public_path('video/class/' . $newclassAUDIO);

          \File::copy($oldPathAUDIO, $newPathWithAUDIO);
        } else {

          $newclassAUDIO = NULL;
        }


        if ($class->file == !NULL && @file_get_contents(public_path() . 'files/class/material/' . $class->file)) {

          $oldPathfile = public_path('files/class/material/' . $class->file); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathfile);

          $newclassfile = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithVideo = public_path('files/class/material/' . $newclassfile);

          \File::copy($oldPathfile, $newPathWithfile);
        } else {

          $newclassfile = NULL;
        }





        $new_class = $class->replicate()->fill(
          [
            'course_id' => $newOpenening->id,
            'coursechapter_id' => $new_chapter->id,
            'video' => $newclassVideo,
            'pdf' => $newclassPDF,
            'zip' => $newclassZIP,
            'preview_video' => $newclassPreview,
            'audio' => $newclassAUDIO,
            'position' => (CourseClass::count() + 1),
            'file' => $newclassfile,
          ]
        );

        $new_class->save();
      }
    }




    return back()->with('CreatedSuccessfully');
  }


  public function courcestatus(Request $request)
  {

    $catstatus = Course::find($request->id);
    $catstatus->status = $request->status;
    $catstatus->save();
    return back()->with('success', 'Status change successfully.');
  }

  public function courcefeatured(Request $request)
  {
    $catfeature = Course::find($request->id);
    $catfeature->featured = $request->featured;
    $catfeature->save();
    return back()->with('success', 'Status change successfully.');
  }

  // This function performs bulk delete action
  public function bulk_delete(Request $request)
  {
    $validator = Validator::make($request->all(), ['checked' => 'required']);
    if ($validator->fails()) {
      return back()->with('warning', 'Atleast one item is required to be checked');
    } else {
      Course::whereIn('id', $request->checked)->delete();
      Session::flash('delete', trans('Selected item has been deleted successfully !'));
      return back()->with('error', trans('Selected User has been deleted.'));
      $validator = Validator::make($request->all(), [
        'checked' => 'required',
      ]);
    }
  }
  public function instructor_course()
  {
    $data['course'] = CourseBackup::paginate(9);
    return view('admin.course.instructor_course',$data);
  }

  public function instructorCourseDetailPage($id, $slug)
  {
    $data['cat'] = CourseBackup::whereId($id)->first();
    return view('admin.course.instructor_course_view',$data);
  }

  public function instructorCourseVerify($id, $slug)
  {
    $course_info = CourseBackup::whereId($id)->first();
    // $course['user_id'] = $course_info->user_id;
    $course['category_id'] = $course_info->category_id;
    $course['subcategory_id'] = $course_info->subcategory_id;
    $course['childcategory_id'] = $course_info->childcategory_id;
    $course['language_id'] = $course_info->language_id;
    $course['title'] = $course_info->title;
    $course['short_detail'] = $course_info->short_detail;
    $course['detail'] = $course_info->detail;
    $course['requirement'] = $course_info->requirement;
    $course['price'] = $course_info->price;
    $course['discount_price'] = $course_info->discount_price;
    $course['day'] = $course_info->day;
    $course['video'] = $course_info->video;
    $course['url'] = $course_info->url;
    $course['featured'] = 1;
    $course['slug'] = $course_info->slug;
    $course['status'] = 1;
    $course['preview_image'] = $course_info->preview_image;
    $course['video_url'] = $course_info->video_url;
    $course['preview_type'] = $course_info->preview_type;
    $course['type'] = $course_info->type;
    $course['duration'] = $course_info->duration;
    $course['duration_type'] = $course_info->duration_type;
    $course['assignment_enable'] = $course_info->assignment_enable;
    $course['appointment_enable'] = $course_info->appointment_enable;
    $course['certificate_enable'] = $course_info->certificate_enable;
    $course['course_tags'] = $course_info->course_tags;
    $course['reject_txt'] = $course_info->reject_txt;
    $course['drip_enable'] = $course_info->drip_enable;
    $course['institude_id'] = $course_info->institude_id;
    $course['country'] = $course_info->country;
    $course['other_cats'] = $course_info->other_cats;
    $course['involvement_request'] = $course_info->involvement_request;
    $course_data = Course::find($course_info->course_id);
    $course_data->update($course);
    CourseBackup::whereId($id)->delete();
    return redirect('instructor/course')->with('success', 'Update successfully.');
  }

  public function Allcourse(){
    $data = Course::where('status','1')->paginate(6);
    return view('theme_2.front.allcourse',compact('data'));  }

  public function instructor_course_delete(Request $request)
  {
    CourseBackup::where('id', $request->id)->delete();
    Session::flash('delete', trans('Deleted successfully !'));
    return back()->with('error', trans('Deleted successfully.'));
  }
  public function set_goal_date(Request $request)
  {
    $data['goal_date'] = $request->date;
    CourseChapter::whereId($request->chapter_id)->update($data);
    return $request;
  }
  public function instructorCourseNotVerify(Request $request,$id){
   
    $data = $this->validate($request,[
      'reason'=>'required',
  ]);
  $input = $request->all();
  $data = Coursereject::create($input);
  $data->save();
  CourseBackup::where('id', $request->id)->delete();
  Session::flash('delete', trans('Deleted successfully !'));
  return redirect('instructor/course');
  }


  public function downloadPdf($id, $filename)
{
    // Define the base directory where the PDFs are stored
    $baseDir = public_path('images/question_book_pdfs/'); // Adjust this path as needed

    // Construct the full file path
    $filePath = $baseDir . $filename;

    // Check if the file exists and then download it
    if (file_exists($filePath)) {
        return response()->download($filePath, $filename);
    } else {
        return redirect()->back()->with('error', 'File not found.');
    }
}

  
}