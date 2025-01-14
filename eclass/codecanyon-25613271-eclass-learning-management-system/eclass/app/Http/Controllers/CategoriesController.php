<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\SubCategory;
use App\ChildCategory;
use Session;
use App\Course;
use App\Setting;
use File;
use Image;
use App\CourseLanguage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CategoriesController extends Controller
{
  public function __construct()
  {
    $this->middleware('permission:categories.view', ['only' => ['index', 'show']]);
    $this->middleware('permission:categories.create', ['only' => ['store']]);
    $this->middleware('permission:categories.edit', ['only' => ['update', 'catstatus']]);
    $this->middleware('permission:categories.delete', ['only' => ['destroy', 'bulk_delete']]);
  }
  public function index()
  {
    $userid = auth()->user()->id;
    $cate = Categories::orderBy('position', 'ASC')->get();
    return view('admin.category.view', compact('cate'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    
    $data = $this->validate($request, [
      "title" => "required|unique:categories,title",
      "title.required" => "Please enter category title !",
      "slug" => "required",
      "icon" => "required",
      "cat_image" => "required",
      "cat_image" => "image|mimes:jpg,jpeg,png,webp",
    ]);

    $input = $request->all();
    // $slug = str_slug($input['title'],'-');
    // $input['slug'] = $slug;
    $input['position'] = (Categories::count() + 1);

    if ($file = $request->file('image')) {

      $path = 'images/category/';

      if (!file_exists(public_path() . '/' . $path)) {

        $path = 'images/category/';
        File::makeDirectory(public_path() . '/' . $path, 0777, true);
      }
      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/category/';
      $image = time() . $file->getClientOriginalName();
      $optimizeImage->save($optimizePath . $image, 72);
      $input['cat_image'] = $image;
    }

    $input['status'] = isset($request->status)  ? 1 : 0;
    $input['featured'] = isset($request->featured)  ? 1 : 0;
    $input['slug'] = strtolower(str_replace(" ","_",$request->slug));
    $data = Categories::create($input);

    $data->save();
    Session::flash('success', trans('flash.AddedSuccessfully'));
    return redirect('category');
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\categories  $categories
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {

    $cate = Categories::find($id);
    return view('admin.category.update', compact('cate'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\categories  $categories
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
   * @param  \App\categories  $categories
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $data = $this->validate($request, [
      "title" => "required|unique:categories,title",
      "title.required" => "Please enter category title !",
      "title.unique" => "This Category name is already exist !",
      "slug" => "required",
      "icon" => "required"
    ]);

    $data = Categories::findorfail($id);
    $input = $request->all();

    // $slug = str_slug($input['title'],'-');
    // $input['slug'] = $slug;

    if ($file = $request->file('image')) {

      $path = 'images/category/';

      if (!file_exists(public_path() . '/' . $path)) {

        $path = 'images/category/';
        File::makeDirectory(public_path() . '/' . $path, 0777, true);
      }

      if ($data->cat_image != null) {
        $content = @file_get_contents(public_path() . '/images/category/' . $data->cat_image);
        if ($content) {
          unlink(public_path() . '/images/category/' . $data->cat_image);
        }
      }

      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/category/';
      $image = time() . $file->getClientOriginalName();
      $optimizeImage->save($optimizePath . $image, 72);

      $input['cat_image'] = $image;
    }
    if (isset($request->status)) {
      $input['status'] = '1';
    } else {
      $input['status'] = '0';
    }

    if (isset($request->featured)) {
      $input['featured'] = '1';
    } else {
      $input['featured'] = '0';
    }
    $input['slug'] = strtolower(str_replace(" ","_",$request->slug));

    $data->update($input);
    Session::flash('success', trans('flash.UpdatedSuccessfully'));
    return redirect('category');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\categories  $categories
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    if (Auth::User()->role == "admin") {

      $course = Course::where('category_id', $id)->get();

      if (!$course->isEmpty()) {
        return back()->with('delete', trans('flash.CannotDeleteCategory'));
      } else {

        DB::table('categories')->where('id', $id)->delete();
        SubCategory::where('category_id', $id)->delete();
        ChildCategory::where('category_id', $id)->delete();

        return back()->with('delete', trans('flash.DeletedSuccessfully'));
      }
    }

    return redirect('category');
  }

  public function categoryStore(Request $request)
  {
    $cat = new Categories;
    $cat->title = $request->category;
    $cat->icon = $request->icon;

    $cat->slug = $request->slug;

    $cat->position = (Categories::count() + 1);
    // $cat->slug = str_slug($request->category);
    $cat->featured = $request->featured;
    $cat->status = $request->status;

    $cat->save();
    return back()->with('success', trans('flash.AddedSuccessfully'));
  }

  public function categoryPage(Request $request)
  {

    $ipaddress = $request->getClientIp();

    $geoip = geoip()->getLocation($ipaddress);
    $usercountry = strtoupper($geoip->country);


    if (!$request->slug && !$request->category) {

      return redirect('/')->with('delete', 'Invalid URL');
    }

    $cats = Categories::with('courses')->where('slug', $request->slug)->first();

    if (!$cats) {

      return redirect('/')->with('delete', '404 | category not found !');
    }

    $query = $cats->courses()->orWhereRaw("JSON_SEARCH(other_cats, 'one' ,'$cats->id') is not null")->where('status', '1');
    if ($request->type) {
      $query->where('type', '=', $request->type == 'paid' ? '1' : '0');
    } elseif ($request->sortby) {
      switch ($request->sortby) {
          case 'a-z':
              $query->orderBy('title', 'ASC');
              break;
          case 'z-a':
              $query->orderBy('title', 'DESC');
              break;
          case 'newest':
              $query->orderBy('created_at', 'DESC');
              break;
          case 'featured':
              $query->where('featured', '=', '1');
              break;
          case 'l-h':
              $query->orderBy('price', 'ASC');
              break;
          case 'h-l':
              $query->orderBy('price', 'DESC');
              break;
      }
    }  elseif ($request->lang) {
      $lang = CourseLanguage::where('id', $request->lang)->first();
      $query->where('language_id', '=', $lang->id);
  }

  $limit = 5;
    if ($request->limit) {
        switch ($request->limit) {
            case '10':
                $limit = 10;
                break;
            case '30':
                $limit = 30;
                break;
            case '50':
                $limit = 50;
                break;
            case '100':
                $limit = 100;
                break;
        }
    }

    $courses = $query->paginate($limit);
    $filter_count = $courses->total();


    $subcat = SubCategory::where('category_id', $cats->id)->get();
    $setting = setting::first();
    if($setting->theme == '1'){

    return view('front.category', compact('cats', 'courses', 'subcat', 'filter_count', 'usercountry'));
    }
    return view('theme_2.front.category', compact('cats', 'courses', 'subcat', 'filter_count', 'usercountry'));

  }

  public function subcategoryPage(Request $request,$categorySlug, $slug)
  {
    $ipaddress = $request->getClientIp();

    $geoip = geoip()->getLocation($ipaddress);
    $usercountry = strtoupper($geoip->country);

    $cats = SubCategory::where('slug', $slug)->first();

    if (!$cats) {

      return redirect('/')->with('delete', '404 | category not found !');
    }

    if ($request->type) {

      $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 5);
    } else if ($request->sortby) {

      if ($request->sortby == 'l-h') {


        $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'ASC')->paginate($request->limit ?? 5);
      }

      if ($request->sortby == 'h-l') {


        $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'DESC')->paginate($request->limit ?? 5);
      }

      if ($request->sortby == 'a-z') {

        if ($request->type) {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'ASC')->paginate($request->limit ?? 5);
        } else {

          $courses = $cats->courses()->where('status', '1')->orderBy('title', 'ASC')->paginate($request->limit ?? 5);
        }
      }

      if ($request->sortby == 'z-a') {

        if ($request->type) {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'DESC')->paginate($request->limit ?? 5);
        } else {

          $courses = $cats->courses()->where('status', '1')->orderBy('title', 'DESC')->paginate($request->limit ?? 5);
        }
      }

      if ($request->sortby == 'newest') {

        if ($request->type) {

          $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 5);
        } else {

          $courses = $cats->courses()->where('status', '1')->orderBy('created_at', 'DESC')->paginate($request->limit ?? 5);
        }
      }

      if ($request->sortby == 'featured') {

        if ($request->type) {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->where('featured', '=', '1')->paginate($request->limit ?? 5);
        } else {

          $courses = $cats->courses()->where('status', '1')->where('featured', '=', '1')->paginate($request->limit ?? 5);
        }
      }
    } else if ($request->limit) {

      // return 'ghjj';

      if ($request->limit == '10') {

        $courses = $cats->courses()->where('status', '1')->paginate(2);
      } elseif ($request->limit == '30') {

        $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
      } elseif ($request->limit == '50') {

        $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
      } elseif ($request->limit == '100') {

        $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
      } else {

        $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 5);
      }
    } else if ($request->lang) {

      $lang = CourseLanguage::where('id', $request->lang)->first();

      $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 5);
    } else {

      $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 5);
    }

    $filter_count = $courses->where('status',1)->count();

    $childcat = ChildCategory::where('subcategory_id', $cats->id)->get();
    $setting = Setting::first();
    if($setting->theme == '1'){
    return view('front.category', compact('cats', 'courses', 'childcat', 'filter_count', 'usercountry'));
    }
    return view('theme_2.front.category', compact('cats', 'courses', 'childcat', 'filter_count', 'usercountry'));
  }

  public function childcategoryPage(Request $request)
  {

    $ipaddress = $request->getClientIp();

    $geoip = geoip()->getLocation($ipaddress);
    $usercountry = strtoupper($geoip->country);

    $cats = ChildCategory::where('slug', $request->slug)->first();


    if (!$cats) {

      return redirect('/')->with('delete', '404 | category not found !');
    }

    if ($request->type) {

      $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 5);
    } else if ($request->sortby) {


      if ($request->sortby == 'l-h') {


        $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'DESC')->paginate($request->limit ?? 5);
      }

      if ($request->sortby == 'h-l') {


        $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'ASC')->paginate($request->limit ?? 5);
      }

      if ($request->sortby == 'a-z') {

        if ($request->type) {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'ASC')->paginate($request->limit ?? 5);
        } else {

          $courses = $cats->courses()->where('status', '1')->orderBy('title', 'ASC')->paginate($request->limit ?? 5);
        }
      }

      if ($request->sortby == 'z-a') {

        if ($request->type) {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'DESC')->paginate($request->limit ?? 5);
        } else {

          $courses = $cats->courses()->where('status', '1')->orderBy('title', 'DESC')->paginate($request->limit ?? 5);
        }
      }

      if ($request->sortby == 'newest') {

        if ($request->type) {

          $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 5);
        } else {

          $courses = $cats->courses()->where('status', '1')->orderBy('created_at', 'DESC')->paginate($request->limit ?? 5);
        }
      }

      if ($request->sortby == 'featured') {

        if ($request->type) {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->where('featured', '=', '1')->paginate($request->limit ?? 5);
        } else {

          $courses = $cats->courses()->where('status', '1')->where('featured', '=', '1')->paginate($request->limit ?? 5);
        }
      }
    } else if ($request->limit) {

      // return 'ghjj';

      if ($request->limit == '10') {

        $courses = $cats->courses()->where('status', '1')->paginate(2);
      } elseif ($request->limit == '30') {

        $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
      } elseif ($request->limit == '50') {

        $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
      } elseif ($request->limit == '100') {

        $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
      } else {

        $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 5);
      }
    } else if ($request->lang) {

      $lang = CourseLanguage::where('id', $request->lang)->first();

      $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 5);
    } else {

      $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 5);
    }

    $filter_count = $courses->where('status',1)->count();

    
    $setting = Setting::first();
    if($setting->theme == '1'){
    return view('front.category', compact('cats', 'courses', 'filter_count', 'usercountry'));
  }
  return view('theme_2.front.category', compact('cats', 'courses', 'filter_count', 'usercountry'));

  }

  public function reposition(Request $request)
  {

    $data = $request->all();

    $posts = Categories::all();
    $pos = $data['id'];

    $position = json_encode($data);

    foreach ($posts as $key => $item) {

      Categories::where('id', $item->id)->update(array('position' => $pos[$key]));
    }

    return response()->json(['msg' => 'Updated Successfully', 'success' => true]);
  }

  public function bulk_delete(Request $request)
  {

    $validator = Validator::make($request->all(), ['checked' => 'required']);
    if ($validator->fails()) {
      return back()->with('error', trans('Please select field to be deleted.'));
    }
    Categories::whereIn('id', $request->checked)->delete();

    return back()->with('error', trans('Selected Categories has been deleted.'));
  }

  public function catstatus(Request $request)
  {
    $catstatus = Categories::find($request->id);
    $catstatus->status = $request->status;
    $catstatus->save();
    return back()->with('success', 'Status change successfully.');
  }

  public function catfeatured(Request $request)
  {
    $catfeature = Categories::find($request->id);
    $catfeature->featured = $request->featured;
    $catfeature->save();
    return back()->with('success', 'Status change successfully.');
  }
}