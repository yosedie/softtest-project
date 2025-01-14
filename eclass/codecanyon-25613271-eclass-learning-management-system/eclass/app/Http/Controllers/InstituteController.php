<?php

namespace App\Http\Controllers;
use App\Institute;
use App\Course;
use Illuminate\Support\Facades\Validator;
use Session;
use Auth;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:institute.view', ['only' => ['index']]);
        $this->middleware('permission:institute.create', ['only' => ['create','save']]);
        $this->middleware('permission:institute.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:institute.delete', ['only' => ['destroy']]);
    
    }
    public function index()
    {
        $institute = Institute::all();
        return view('admin.Institute.index',compact('institute'));
    }

    public function create()
    {
        return view('admin.Institute.create');
    }

    public function edit($id)
    {
         $data = Institute::findOrFail($id);
        return view('admin.Institute.edit',compact('data'));
    }

    public function view($id,$cour)
    {
        
        $data = Institute::findOrFail($id);
        $course = Course::where('institude_id',$data->id)->first();
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.institute.view',compact('data','course'));
        }
        return view('theme_2.front.institute.view',compact('data','course'));

    }

    public function destroy($id)
    {
        //return $id;
        Institute::findOrFail($id)->delete();
        Session::flash('success', __('Delete Successfully'));
        return back();
    }


    public function save(Request $request)
    {
        $request->validate([
            "title" => "required",
            "detail" => "required",
            "skill" => "required",
            "mobile" => "required|digits:10",
            "email" => "required|email",
            "slug" => "required|unique:institute,slug",
            "image" => "image|mimes:jpg,jpeg,png,webp",
         ]);
                //return $request;

        $institute['title'] = strip_tags($request->title);
        $institute['detail'] = strip_tags($request->detail);
        $institute['user_id'] = Auth::user()->id;
        $institute['skill'] = strip_tags($request->skill);
        $institute['mobile'] = strip_tags($request->mobile);
        $institute['affilated_by'] = strip_tags($request->affilated_by);
        $institute['email'] = strip_tags($request->email);
         $institute['address'] = strip_tags($request->address);
         $institute['slug'] = strip_tags($request->slug);

        

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
        Institute::create($institute);
        Session::flash('success', __('flash.AddedSuccessfully'));
        return redirect()->route('institute.index');

    }

    public function update(Request $request,$id)
    {
        $data = Institute::findOrFail($id);

        $request->validate([
            "title" => "required",
            "detail" => "required",
            "skill" => "required",
            "mobile" => "required",
            "email" => "required",
            'slug' => 'required|unique:institute,slug,' . $data->id,


        ]);

        $institute['title'] = strip_tags($request->title);
        $institute['detail'] = strip_tags($request->detail);
        $institute['mobile'] = strip_tags($request->mobile);
        $institute['affilated_by'] = strip_tags($request->affilated_by);
        $institute['email'] = strip_tags($request->email);
         $institute['address'] = strip_tags($request->address);
        $institute['skill'] = strip_tags($request->skill);
        $institute['slug'] = strip_tags($request->slug);

        
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

        $data->update($institute);
        Session::flash('success', __('flash.UpdatedSuccessfully'));
        return redirect()->route('institute.index');

    }

    

    public function verify(Request $request)
    { 
        $inst = Institute::find(strip_tags($request->id));

        $inst->verified = strip_tags($request->verify);

        $inst->save();
        return response()->json($request->all());
    }

    public function status(Request $request)
    {
        $inst = Institute::find(strip_tags($request->id));

        $inst->status = strip_tags($request->status);

        $inst->save();
        return response()->json($request->all()); 
    }
    
    public function import()
    {
        return view('admin.Institute.import');
    }

    public function csvfileupload(Request $req){

    $institute = Institute::all();
    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
    fgetcsv($csvFile); 
         $file_data= array();
        $data = array();
            while(($line = fgetcsv($csvFile)) !== FALSE){
            $data= array(
           'image' => $line[0],
            'address' => $line[1],
            'email' => $line[2],
            'mobile' => $line[3],
            'skill' => $line[4],
            'detail' => $line[5],
            'status' => $line[6],
            'verified' => $line[7],
            'title' => $line[8],
            'user_id' => $line[9],
            'affilated_by' => $line[10]
           );
           Institute::create($data);
           }
          fclose($csvFile);
          Session::flash('success', trans('Import Successfully'));
          return redirect()->route('institute.index');
        }
 }
