<?php

namespace App\Http\Controllers;

use App\Testimonial;
use Illuminate\Http\Request;
use DB;
use Image;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;


class TestimonialController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:front-settings.testimonial.view', ['only' => ['index']]);
        $this->middleware('permission:front-settings.testimonial.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:front-settings.testimonial.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:front-settings.testimonial.delete', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $test = Testimonial::all();
        return view('admin.testimonial.index',compact('test'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial.testi_form');
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
            'client_name'=>'required',
            'details'=>'required',
            'image'=>'required',
            'image'=>'image|mimes:jpg,jpeg,png,webp',
        ]);


        $input = $request->all();
        if ($file = $request->file('image')) 
        {       
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/testimonial/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);

          $input['image'] = $image;
          
        }

        $input['created_at']  = \Carbon\Carbon::now()->toDateTimeString();
        $input['updated_at']  = \Carbon\Carbon::now()->toDateTimeString();
        

        $input['status'] = isset($request->status)  ? 1 : 0;

        $data = Testimonial::create($input);
        
        $data->save();

        return redirect('testimonial');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */

    public function show(testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $test= Testimonial::find($id);
        return view('admin.testimonial.testi_edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id)
    {

        $testimonial = Testimonial::findorfail($id);

        $input = $request->all();

        if ($file = $request->file('image'))
        {
            
            if($testimonial->image != "")
            {
                $content = @file_get_contents(public_path().'/images/testimonial/'.$testimonial->image);
                if ($content) {
                  unlink(public_path().'/images/testimonial/'.$testimonial->image);
                }
            }

            $name = time().$file->getClientOriginalName();
            $file->move('images/testimonial', $name);
            $input['image'] = $name;
        }


        $input['updated_at']  = \Carbon\Carbon::now()->toDateTimeString();

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        $testimonial->update($input);

        return redirect('testimonial');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        DB::table('testimonials')->where('id',$id)->delete();
        return redirect('testimonial');
    }


}
