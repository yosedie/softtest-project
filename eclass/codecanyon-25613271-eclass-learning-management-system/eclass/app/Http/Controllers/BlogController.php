<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\User;
use Image;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Setting;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:blogs.view', ['only' => ['index']]);
        $this->middleware('permission:blogs.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:blogs.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:blogs.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    public function index()
    {

        if(Auth::User()->role == "admin"){
           $items = Blog::all();
        }
        else{
           $items = Blog::where('user_id', Auth::User()->id)->get(); 
        }

        return view('admin.blog.index',compact('items'));
        $blogs = Blog::paginate(4); // Change the number '5' to the desired number of items per page
        return view('your_view_name', compact('blogs'));
    }
   
    public function create()
    {
        $show = Blog::all();
        return view('admin.blog.create',compact('show'));
    }

    public function store(Request $request)
    {
        

        $data = $this->validate($request,[
            'date' => 'required',
            'image'=> 'required',
            'heading' => 'required',
            'text' => 'required',
            'detail' => 'required',
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
        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect()->route('blog.index');
    }

    public function show()
    {

    }

    public function edit($id)
    {
      $show = Blog::where('id', $id)->first();
      return view('admin.blog.edit',compact('show'));
    }
    public function update(Request $request, $id)
    {
        // return $request->detail;
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
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect()->route('blog.index');
    }

    public function destroy($id)
    {

        $blog = Blog::find($id);
        if ($blog->image != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/blog/'.$blog->image);

            if($image_file)
            {
                unlink(public_path().'/images/blog/'.$blog->image);
            }
        }

        $value = $blog->delete();

        if($value)
        {
            Session::flash('success', trans('flash.DeletedSuccessfully'));
            return redirect()->route('blog.index');
        }
    }

    public function blogpage()
    {
        $blogs = Blog::orderby('id','desc')->paginate(4); // Change the number '5' to the desired number of items per page
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.blog.blog', compact('blogs'));
        }
        return view('theme_2.front.blog.blog', compact('blogs'));
    }

    public function blogdetailpage($slug)
    {
        $blog = Blog::where('slug',$slug)->first();
        $blogs = Blog::where('status', 1)->where('approved', 1)->where('id', '!=' ,$blog->id)->get();
        $setting = Setting::first();
        if($setting->theme == '1'){
      return view('front.blog.blog_detail',compact('blog','blogs'));
         }
      return view('theme_2.front.blog.blog_detail',compact('blog','blogs'));
    }

    // This function performs bulk delete action
    public function bulk_delete(Request $request)
    {
    
         $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                return back()->with('warning', 'Atleast one item is required to be checked');
               
            }
            else{
                Blog::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }    
    }

    public function status(Request $request)
    {
        $blog = Blog::find($request->id);
        $blog->status = $request->status;
        $blog->save();
        Session::flash('success', trans('Status has been changed successfully !'));
        return redirect()->route('blog.index'); 
    }

    public function blogapproved(Request $request)
    {
        $blogapp = Blog::find($request->id);
        $blogapp->approved = $request->approved;
        $blogapp->save();
        Session::flash('success', trans('Status has been approved successfully !'));
        return redirect()->route('blog.index'); 
    }
    public function openai(Request $request){
        //return $request;
        // echo 'hello';
        $heading = $request->heading;
        $prompt = "Give a short detail related to this $heading";
        $settings = Setting::first();
        return response()->stream(function () use ($prompt,$settings) {
        $stream1 = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$settings->api_key,
        ])
        ->post("https://api.openai.com/v1/chat/completions", [
            "model" => "gpt-3.5-turbo",
            'messages' => [
                [
                "role" => "user",
                "content" => $prompt
            ]
            ],
            'temperature' => 1.0,
            "max_tokens" => 200,
            "stream"=> true,
        ]);
        $var22 = $stream1;
            // }
            echo "event: update\n";
            echo 'data: <END_STREAMING_SSE>';
            echo "\n\n";
            ob_flush();
            flush();
        }, 200, [
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Content-Type' => 'text/event-stream',
    ]
);
        return "ss";
    }
    // public function image(Request $request){

    // }
}
