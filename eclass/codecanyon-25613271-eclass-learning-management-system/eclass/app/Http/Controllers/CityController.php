<?php

namespace App\Http\Controllers;

use App\Allcity;
use App\Allstate;
use App\Allcountry;
use Illuminate\Http\Request;
use Session;
use App\City;
use App\State;
use App\Country;
use DB;
use Spatie\Permission\Models\Role;

class CityController extends Controller
{
    public function __construct()
    {
    $this->middleware('permission:locations.city.view', ['only' => ['index']]);
    $this->middleware('permission:locations.city.create', ['only' => ['create', 'store','addcity']]);
    $this->middleware('permission:locations.city.edit', ['only' => [ 'update','status']]);
    $this->middleware('permission:locations.city.delete', ['only' => ['destroy']]);

}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
        return view('admin.country.state.city.index',compact('cities','states','countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $countries = Country::all();
        $states = State::all();
        return view("admin.country.state.city.add",compact('states', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
        // $this->validate($request, [
        //     'city' => 'required',
        // ]);
        $data = State::where('state_id', $request->state_id)->first();

        $allcities = Allcity::where('state_id', $data->state_id)->get();

        $cities = City::where('state_id', $data->state_id)->first();

        if(count($allcities)>0){

            if($cities == NULL){

                foreach($allcities as $city)
                { 

                  DB::table('cities')->insert(
                        array(
                            'name'      => $city->name,
                            'state_id'=> $city->state_id,
                            'country_id'=> $data->country_id,
                        )
                    );

                }

                Session::flash('success',trans('flash.AddedSuccessfully'));

            }
            else{
               Session::flash('delete',trans('flash.AlreadyExist')); 
            }
        }
        else{

            Session::flash('delete',trans('flash.NoCitiesAvailable')); 
        }
        
        return redirect('admin/city');
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, array(

        'c_name' => 'required:cities,city',
        'status' => 'required|int'

      ));

      $city = City::findorfail($id);
      $city->status = $request->status;
      $city->city = $request->c_name;
      $city->save();

      Session::flash('success',trans('flash.UpdatedSuccessfully'));
      return redirect()->route('city.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $city = City::find($id);
      $city->delete();
      Session::flash('success',trans('flash.DeletedSuccessfully'));
      return redirect('admin/city');
    }

    public function addcity(Request $request)
    {

        $this->validate($request, array(

            'state_id' => 'required',

        ));
        
        $data = State::where('state_id', $request->state_id)->first();
           

          DB::table('cities')->insert(
                array(
                    'name'      => $request->name,
                    'state_id'=> $data->state_id,
                    'country_id'=> $data->country_id,
                )
            );
        

        Session::flash('success',trans('flash.AddedSuccessfully'));
      
        
        return redirect('admin/city');
    }
}
