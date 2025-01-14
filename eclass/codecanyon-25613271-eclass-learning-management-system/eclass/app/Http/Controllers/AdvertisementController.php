<?php

namespace App\Http\Controllers;

use App\Advertisement;
use Illuminate\Http\Request;
use File;
use Image;
use Session;
use Spatie\Permission\Models\Role;


class AdvertisementController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:front-settings.advertisement.view', ['only' => ['index','show']]);
        $this->middleware('permission:front-settings.advertisement.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:front-settings.advertisement.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:front-settings.advertisement.delete', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisement = Advertisement::get();
        return view('admin.advertisement.index',compact('advertisement'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.advertisement.create');
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
            'image1' => 'mimes:jpeg,jpg,png,webp|required|',
        ]);


        $input = $request->all();

        if($file = $request->file('image1')) 
        {
            $path = 'images/advertisement/';

            if(!file_exists(public_path().'/'.$path)) {
                
                $path = 'images/advertisement/';
                File::makeDirectory(public_path().'/'.$path,0777,true);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/advertisement/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);

            $input['image1'] = $image;
          
        }

        

        $input['status'] = isset($request->status)  ? 1 : 0;
       

        $data = Advertisement::create($input);


        
        $data->save();

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('advertisement');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advs = Advertisement::find($id);
        return view('admin.advertisement.edit',compact('advs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertisement $advertisement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ads = Advertisement::findorfail($id);

        $input = $request->all();

        if($file = $request->file('image1'))
        {
            if($ads->image1 != null) {
                $content = @file_get_contents(public_path().'/images/advertisement/'.$ads->image1);
                if ($content) {
                  unlink(public_path().'/images/advertisement/'.$ads->image1);
                }
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/advertisement/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);

            $input['image1'] = $image;
        }

        $input['status'] = isset($request->status)  ? 1 : 0;

       

        $ads->update($input);

        Session::flash('success',trans('flash.UpdatedSuccessfully'));
        return redirect('advertisement');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $adv = Advertisement::find($id);

        if ($adv->image1 != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/advertisement/'.$adv->image1);

            if($image_file)
            {
                unlink(public_path().'/images/advertisement/'.$adv->image1);
            }
        }
        
        $value = $adv->delete();

        if($value)
        {
            session()->flash('delete',trans('flash.DeletedSuccessfully'));
            return redirect('advertisement');
        }
    }
}
