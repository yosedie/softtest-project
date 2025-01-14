<?php

namespace App\Http\Controllers;

use App\Dropdown;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Session;
use DB;


class DropdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dsetting = Dropdown::get();
        return view('admin.drop.index',compact('dsetting'));
    }

   public function create(){

    $roles = Role::where('name', '!=' , 'Admin')->where('name', '!=' , 'Instructor')->where('name', '!=' , 'User')->get();
    $dsetting = Dropdown::first();
    return view('admin.drop.create',compact('dsetting','roles'));
   }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHomesettingRequest  $request
     * @param  \App\Homesetting  $homesetting
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $this->validate($request,[
            'role_id' => 'required',
            
        ]);
        $input = $request->all();
        $input['my_courses'] = isset($request->my_courses) ? 1 : 0;
        $input['my_wishlist'] = isset($request->my_wishlist) ? 1 : 0;
        $input['purchased_history'] = isset($request->purchased_history) ? 1 : 0;
        $input['my_profile'] = isset($request->my_profile) ? 1 : 0;
        $input['flash_deal'] = isset($request->flash_deal) ? 1 : 0;
        $input['donation'] = isset($request->donation) ? 1 : 0;
        $input['my_wallet'] = isset($request->my_wallet) ? 1 : 0;
        $input['affilate'] = isset($request->affilate) ? 1 : 0;
        $input['compare'] = isset($request->compare) ? 1 : 0;
        $input['search_job'] = isset($request->search_job) ? 1 : 0;
        $input['job_portal'] = isset($request->job_portal) ? 1 : 0;
        $input['form_enable'] = isset($request->form_enable) ? 1 : 0;
        $input['my_leadership'] = isset($request->my_leadership) ? 1 : 0;
        $input['affilate_dashboard'] = isset($request->affilate_dashboard) ? 1 : 0;
        $input['role_id'] = $request->role_id;
        $dsetting = Dropdown::create($input); 
        $dsetting->save();
        Session::flash('success',trans('Create Successfully'));
        return redirect('dropdown');


    }
    public function edit(){
        $roles = Role::where('name', '!=' , 'Admin')->where('name', '!=' , 'Instructor')->where('name', '!=' , 'User')->get();
        $dsetting = Dropdown::first();
        return view('admin.drop.edit',compact('dsetting','roles'));

    }
    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'role_id' => 'required',
            
        ]);
        $dsetting = Dropdown::findOrFail($id);
        $input = $request->all();
        $input['my_courses'] = isset($request->my_courses) ? 1 : 0;
        $input['my_wishlist'] = isset($request->my_wishlist) ? 1 : 0;
        $input['purchased_history'] = isset($request->purchased_history) ? 1 : 0;
        $input['my_profile'] = isset($request->my_profile) ? 1 : 0;
        $input['flash_deal'] = isset($request->flash_deal) ? 1 : 0;
        $input['donation'] = isset($request->donation) ? 1 : 0;
        $input['my_wallet'] = isset($request->my_wallet) ? 1 : 0;
        $input['affilate'] = isset($request->affilate) ? 1 : 0;
        $input['compare'] = isset($request->compare) ? 1 : 0;
        $input['search_job'] = isset($request->search_job) ? 1 : 0;
        $input['job_portal'] = isset($request->job_portal) ? 1 : 0;
        $input['form_enable'] = isset($request->form_enable) ? 1 : 0;
        $input['my_leadership'] = isset($request->my_leadership) ? 1 : 0;
        $input['affilate_dashboard'] = isset($request->affilate_dashboard) ? 1 : 0;
        $input['role_id'] = $request->role_id;
     
        $dsetting->update($input);
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect('dropdown');


    }
    public function destroy($id)
    {
        DB::table('dropdowns')->where('id',$id)->delete();
        Session::flash('delete', trans('flash.DeletedSuccessfully'));
        return redirect('dropdown');
    }

    
}
