<?php

namespace App\Http\Controllers;

use App\SeoDirectory;
use Illuminate\Http\Request;
use Session;
use DB;
use Spatie\Permission\Models\Role;

class SeoDirectoryController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:front-settings.seo-directory.view', ['only' => ['index','show','view']]);
        $this->middleware('permission:front-settings.seo-directory.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:front-settings.seo-directory.edit', ['only' => ['update']]);
        $this->middleware('permission:front-settings.seo-directory.delete', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directory = SeoDirectory::get();
        return view('admin.directory.index', compact('directory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.directory.create');
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
            'city' => 'required',
            'detail' => 'required',

        ]);

        $input = $request->all();

        $input['status'] = isset($request->status)  ? 1 : 0;
        
        $data = SeoDirectory::create($input);
        $data->save();

        Session::flash('success','Added Successfully !');
        return redirect()->route('directory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SeoDirectory  $seoDirectory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = SeoDirectory::where('id', $id)->first();
        return view('admin.directory.edit', compact('show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SeoDirectory  $seoDirectory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SeoDirectory  $seoDirectory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $this -> validate($request,[
        //     'city' => 'required',
        //     'detail' => 'required'
        // ]);

        $data = SeoDirectory::findorfail($id);
        $input = $request->all();

        $input['status'] = isset($request->status)  ? 1 : 0;

        $data->update($input);
      
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect()->route('directory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SeoDirectory  $seoDirectory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('seo_directory')->where('id',$id)->delete();
        return redirect()->route('directory.index');
    }

    public function view($id)
    {
        $directory = SeoDirectory::findorfail($id);
        return view('front.directory.show', compact('directory'));
    }
}
