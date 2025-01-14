<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use App\Page;
use Session;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::get();
        return view('admin.menu.index',compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::where('status','=','1')->get();
        return view('admin.menu.create',compact('pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $menu = new Menu;

        $request->validate([
            'title' => 'required'
        ],[
            'title.required' => __('Menu title is required !')
        ]);

        $input = $request->all();

        if(isset($request->status)){

            $input['status'] = 1;

        }else{

             $input['status'] = 0;

        }
         if($request->link_by == 'page'){

            $input['url']  = NULL;
            $input['page_id'] = $request->page_id;
        }

        if($request->link_by == 'url'){

            $input['page_id'] = NULL;
            $input['url'] = $request->url;
        }
        if($request->position_menu == 'top'){

            $input['footer']  = NULL;
            $input['top'] = $request->top;
        }

        if($request->position_menu == 'footer'){

            $input['top'] = NULL;
            $input['footer'] = $request->footer;
        }
        //return $request;
        $input['position'] = Menu::count()+1;
        $input['icon'] = substr($request->icon, 3);
        $menu->create($input);
        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect()->route('menu.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        $pages = Page::all();
        return view("admin.menu.edit", compact('menu','pages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        $request->validate([
            'title' => 'required'
        ],[
            'title.required' => __('Menu title is required !')
        ]);

        $input = $request->all();
  
        if(isset($request->status)){

            $input['status'] = 1;

        }else{
             $input['status'] = 0;

        }
        if($request->link_by == 'page'){

            $input['url']  = NULL;
            $input['page_id'] = $request->page_id;

        }
        if($request->link_by == 'url'){

            $input['page_id'] = NULL;
            $input['url'] = $request->url;
        }
        if($request->position_menu == 'top'){

            $input['footer']  = NULL;
            $input['top'] = $request->top;
        }

        if($request->position_menu == 'footer'){

            $input['top'] = NULL;
            $input['footer'] = $request->footer;
        }
        $input['icon'] = substr($request->icon, 3);
        $menu->update($input);

        Session::flash('success', trans('flash.UpdateSuccessfully'));

        return redirect()->route('menu.index');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //return $id;
        $menu = Menu::findorfail($id);
        $menu->delete();
        return back()->with('deleted', 'Menu has been deleted !');
    }
}
