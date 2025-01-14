<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategorySlider;
use App\Categories;
use Spatie\Permission\Models\Role;

class CategorySliderController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:category-sliders.manage', ['only' => ['show','update']]);
     
    }
    
    public function show()
    {
        ini_set("zlib.output_compression", "Off");
        
    	$category = Categories::orderBy('position','ASC')->get();
    	$category_slider = CategorySlider::first();
    	return view('admin.category_slider.edit', compact('category', 'category_slider'));
    }

    public function update(Request $request)
    {

        $data = $this->validate($request, [
            'category_id' => 'required',
        ]);


        $cat = CategorySlider::first();

    	if(isset($cat))
        {
            $data = CategorySlider::first();
            $input = $request->all();
            $data->update($input);
        }
        else
        {
            $input = $request->all();
            $data = CategorySlider::create($input);
            $data->save();

        }
        return back()->with('message',trans('flash.UpdatedSuccessfully'));
    }
}
