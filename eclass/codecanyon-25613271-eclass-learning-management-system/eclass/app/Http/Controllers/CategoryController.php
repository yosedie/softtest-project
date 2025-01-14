<?php

namespace Modules\Ebook\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Image;
use Modules\Ebook\Models\EbookCategory;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['category'] = EbookCategory::all();
        return view('ebook::category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ebook::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if ($file = $request->file('image')) 
        {            
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/ebook_category/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);
            $input['image'] = $image;  
        }
        $input['title'] = $request->title;
        EbookCategory::create($input);
        Session::flash('success', trans('flash.CreatedSuccessfully'));
        return back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('ebook::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ebook::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $category = EbookCategory::find($request->id);
        if ($file = $request->file('image')) 
        {  
            if($category->image != "")
            {
              $image_file = @file_get_contents(public_path().'/images/ebook_category/'.$category->image);

              if($image_file)
              {
                  unlink(public_path().'/images/ebook_category/'.$category->image);
              }
            }            
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/ebook_category/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);
            $input['image'] = $image;  
        }
        $input['title'] = $request->title;
        EbookCategory::whereId($request->id)->update($input);
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        $category = EbookCategory::find($id);
        // return $category;
        if ($category->image != null)
        {
                
            $image_file = @file_get_contents(public_path().'/images/ebook_category/'.$category->image);

            if($image_file)
            {
                unlink(public_path().'/images/ebook_category/'.$category->image);
            }
        }

        $category->delete();
        Session::flash('success', trans('flash.DeleteSuccessfully'));
        return back();
    }
}
