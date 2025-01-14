<?php

namespace App\Http\Controllers;

use App\SubCategory;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Categories;
use Session;
use App\ChildCategory;
use App\Course;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class SubcategoryController extends Controller
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
        abort_if(!auth()->user()->can('subcategories.view'),403,'User does not have the right permissions.');
        $category = Categories::all();
        $subcategory = SubCategory::orderby('id', 'ASC')->get();
        return view('admin.category.subcategory.index',compact('subcategory', 'category'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        abort_if(!auth()->user()->can('subcategories.create'),403,'User does not have the right permissions.');
        $category = Categories::all();
        return view('admin.category.subcategory.insert',compact('category')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('subcategories.create'),403,'User does not have the right permissions.');
        $data = $this->validate($request,[
            "title" => "required",
                 ],[
            "title.required" => "Please enter subcategory title !",
            "slug" => "required",
            "icon" => "required",
            "category_id" => "required"
        ]);

        $input = $request->all();
        // $slug = str_slug($input['title'],'-');
        // $input['slug'] = $slug;
        $input['status'] = isset($request->status)  ? 1 : 0;
        $input['slug'] = strtolower(str_replace(" ","_",$request->slug));

        $data = SubCategory::create($input);

        $data->save();

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect ('subcategory');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  
        abort_if(!auth()->user()->can('subcategories.view'),403,'User does not have the right permissions.');
        $cate = SubCategory::find($id);
        $category = Categories::all();
        return view('admin.category.subcategory.update',compact('cate','category'));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(subcategory $subcategory)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        abort_if(!auth()->user()->can('subcategories.edit'),403,'User does not have the right permissions.');
        $data = $this->validate($request,[
            "title" => "required|unique:categories,title",
            "title.required" => "Please enter category title !",
            "title.unique" => "This Category name is already exist !",
            "slug" => "required",
            "icon" => "required",
            "category_id" => "required"
        ]);

        $data = SubCategory::findorfail($id);
        $input = $request->all();
        
        // $slug = str_slug($input['title'],'-');
        // $input['slug'] = $slug;

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        $input['slug'] = strtolower(str_replace(" ","_",$request->slug));

        $data->update($input);
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect ('subcategory');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('subcategories.delete'),403,'User does not have the right permissions.');
        if(Auth::User()->role == "admin"){


            $course = Course::where('subcategory_id', $id)->get();

            if(!$course->isEmpty())
            {
                return back()->with('delete', trans('flash.CannotDeleteCategory') );
            }
            else
            {

                DB::table('sub_categories')->where('id',$id)->delete();
                ChildCategory::where('subcategory_id', $id)->delete();

                return back()->with('delete', trans('flash.DeletedSuccessfully') );

            }
        }
     
        return redirect('subcategory');
    }
     
    public function SubcategoryStore(Request $request)
    {
        abort_if(!auth()->user()->can('subcategories.create'),403,'User does not have the right permissions.');
        $cat = new SubCategory;

        $cat->category_id = $request->categories;

        $cat->title = $request->title;

        $cat->icon = $request->icon;
           
        $cat->status = $request->status;

        $slug = str_slug($request['title'],'-');
        $cat['slug'] = $slug;

        $cat->save();

        return back()->with('success',trans('flash.AddedSuccessfully'));

    }

    public function status(Request $request)
    {
        abort_if(!auth()->user()->can('subcategories.update'),403,'User does not have the right permissions.');

        $cat = SubCategory::find($request->id);
        $cat->status = $request->status;
        $cat->save();
        return back()->with('success',trans('flash.UpdatedSuccessfully'));
        
    }

    public function bulk_delete(Request $request)
    {
        abort_if(!auth()->user()->can('subcategories.delete'),403,'User does not have the right permissions.');
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',trans('Please select field to be deleted.'));
        }
        SubCategory::whereIn('id',$request->checked)->delete();

        return back()->with('error',trans('Selected SubCategory has been deleted.'));
          
    }


}
