<?php

namespace App\Http\Controllers;

use App\Contactreason;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Session;
use DB;

class ContactreasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactreason = Contactreason::all();
        return view('admin.contactreason.index',compact('contactreason'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contactreason.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactreasonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request,[
            'reason'=>'required',
        ]);

        $input = $request->all();
        $input['contactreason'] = clean($request->contactreason);
        $data = Contactreason::create($input);
        if(isset($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }
        $data->save();

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect('contactreason');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contactreason  $contactreason
     * @return \Illuminate\Http\Response
     */
    public function show(Contactreason $contactreason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contactreason  $contactreason
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $find= Contactreason::find($id);
        return view('admin.contactreason.edit', compact('find'));
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactreasonRequest  $request
     * @param  \App\Contactreason  $contactreason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
            $this -> validate($request,[
            'reason'=>'required',
            
        ]);

        $data = Contactreason::findorfail($id);
        $input = $request->all();
         if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }
        $input['slug'] = $request->slug;
        $data->update($input);
        
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect('contactreason'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contactreason  $contactreason
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         DB::table('contactreasons')->where('id',$id)->delete();
        Session::flash('delete', trans('flash.DeletedSuccessfully'));
        return redirect('contactreason');
    }
}
