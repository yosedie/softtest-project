<?php

namespace App\Http\Controllers;

use App\Trusted;
use Illuminate\Http\Request;
use DB;
use Image;
use Spatie\Permission\Models\Role;


class TrustedController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:front-settings.trusted-sliders.view', ['only' => ['index','show']]);
        $this->middleware('permission:front-settings.trusted-sliders.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:front-settings.trusted-sliders.edit', ['only' => ['update']]);
        $this->middleware('permission:front-settings.trusted-sliders.delete', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $trusted = Trusted::all();
         return view('admin.trusted.index',compact('trusted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.trusted.insert');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          
        $data = $this->validate($request,[
            'url' => 'required',
            'image'=>'required',
            'image'=>'image|mimes:jpg,jpeg,png,webp',
        ]);


        $input = $request->all();
        if ($file = $request->file('image')) 
         {        
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/trusted/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);

          $input['image'] = $image;
          
        }

        $data = Trusted::create($input);

        if(isset($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }
        
        $data->save();

      return redirect('trusted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Trusted  $trusted
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
      
        $trusted = Trusted::find($id);
        return view('admin.trusted.edit',compact('trusted'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trusted  $trusted
     * @return \Illuminate\Http\Response
     */
    public function edit(Trusted $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trusted  $trusted
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $trusted = Trusted::findOrFail($id);

        $input = $request->all();

        if ($file = $request->file('image')) {
          $name = 'trust_' . time() . $file->getClientOriginalName();
          if($trusted->image != null) {
            $content = @file_get_contents(public_path().'/images/trusted/'.$trusted->image);
            if ($content) {
              unlink(public_path().'/images/trusted/'.$trusted->image);
            }
          }
          $file->move('images/trusted', $name);
          $input['image'] = $name;
          $trusted->update([
          'image' => $input['image']
          ]);
          
        }

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        $trusted->update($input);

        return redirect('trusted');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Trusted  $trusted
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $trusted = Trusted::find($id);
        if ($trusted->image != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/trusted/'.$trusted->image);

            if($image_file)
            {
                unlink(public_path().'/images/trusted/'.$trusted->image);
            }
        }
        
        $value = $trusted->delete();
        if($value){
            session()->flash('delete', trans('flash.DeletedSuccessfully'));
            return redirect("trusted");
        }

    }
}
