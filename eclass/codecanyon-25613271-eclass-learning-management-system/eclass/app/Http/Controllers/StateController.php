<?php

namespace App\Http\Controllers;

use App\State;
use App\Allcountry;
use Illuminate\Http\Request;
use Session;
use App\Country;
use App\Allstate;
use DB;
use Spatie\Permission\Models\Role;


class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    
        $this->middleware('permission:locations.state.view', ['only' => ['index']]);
        $this->middleware('permission:locations.state.create', ['only' => ['create', 'store','addstate']]);
        $this->middleware('permission:locations.state.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:locations.state.delete', ['only' => ['destroy']]);
    
    }
    public function index()
    {
        $country = Country::all();
        $states = State::all();
        return view('admin.country.state.index',compact('states', 'country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $country = Country::all();
        return view("admin.country.state.add",compact('country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'country_id' =>'required'
    ]);

      $data = Country::where('id', $request->country_id)->first();

      $allstates = Allstate::where('country_id', $data->country_id)->get();

      //add if state is not added
      $states = State::where('country_id', $data->country_id)->first();

        if($states == NULL){

          foreach($allstates as $state)
          { 

            DB::table('states')->insert(
                  array(
                      'state_id'  => $state->id,
                      'name'      => $state->name,
                      'country_id'=> $state->country_id,
                  )
              );
          }

          session()->flash('success', trans('flash.AddedSuccessfully'));

        }
        else{

            session()->flash('delete',trans('flash.AlreadyExist'));
        }


      
        return redirect('admin/state');

     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $states = State::findorfail($id);
      return view('admin.country.state.edit')->withStates($states);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $this->validate($request, array(

        's_name' => 'required:states,state'

      ));

      $state = State::findorfail($id);

      $state->state = $request->s_name;
      $state->save();

      Session::flash('success', trans('flash.UpdatedSuccessfully'));
      return redirect()->route('state.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $state = State::find($id);
      $state->delete();
      Session::flash('success', trans('flash.DeletedSuccessfully'));
      return redirect('admin/state');
    }

    public function addstate(Request $request)
    {
        $country = Country::where('country_id', $request->country_id)->first();

        $state = State::where('country_id', $request->country_id)->first();

        $data = $this->validate($request, [
            'name' => 'required|unique:allstates,name'
        ]);

        $created_state = Allstate::create([
            'name' => $request->name,
            'country_id'=> $country->country_id,
            ]
        );
           
        if($created_state){
          DB::table('states')->insert(
                array(
                    'name' => $request->name,
                    'state_id'=> $created_state->id,
                    'country_id'=> $created_state->country_id,
                )
            );
        }

        Session::flash('success', trans('flash.AddedSuccessfully'));
        
        return redirect('admin/state');
    }
}
