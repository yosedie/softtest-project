<?php

namespace App\Http\Controllers;

use App\Allcountry;
use Illuminate\Http\Request;
use Session;
use App\Allstate;
use App\Country;
use DB;
use App\State;
use App\City;
use Validator;
use Spatie\Permission\Models\Role;

class CountryController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:locations.country.view', ['only' => ['index']]);
        $this->middleware('permission:locations.country.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:locations.country.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:locations.country.delete', ['only' => ['destroy']]);
    
    }
    public function index(Request $request)
    {
        $countries = Country::all();

        return view("admin.country.index",compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Allcountry::all();
        return view("admin.country.add_country",compact('countries'));
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
            'country' => 'required',
        ]);
        $countries = Country::where('country_id', $request->country)->first();

        if($countries == NULL){

            $data = Allcountry::where('id', $request->country)->first();

            DB::table('countries')->insert(
                array(
                    'country_id'=> $data->id,
                    'iso'       => $data->iso,
                    'name'      => $data->name,
                    'nicename'  => $data->nicename,
                    'iso3'      => $data->iso3,
                    'numcode'   => $data->numcode,
                    'created_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                )
            );

            session()->flash('success', trans('flash.AddedSuccessfully'));
        }
        else{
            session()->flash('delete', trans('flash.AlreadyExist'));
        }
                
        return redirect('admin/country');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countries = Country::findOrFail($id);
        $allcountry = Allcountry::all();
        return view("admin.country.edit",compact("countries", "allcountry"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $countries = Country::where('country_id', $request->country)->first();

        if($countries == NULL){

            $data = Allcountry::where('id', $request->country)->first();

            DB::table('countries')->where('id',$id)
            ->update([
               'country_id'=> $data->country_id,
               'iso'       => $data->iso,
               'name'      => $data->name,
               'nicename'  => $data->nicename,
               'iso3'      => $data->iso3,
               'numcode'   => $data->numcode,

            ]);

            session()->flash('success',trans('flash.AddedSuccessfully'));
        }
        else{
            session()->flash('delete',trans('flash.AlreadyExist'));
        }
                
        return redirect('admin/country');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new Country;
        $obj = $daa->findorFail($id);
        $value = $obj->delete();

        State::where('country_id', $obj->country_id)->delete();
        City::where('country_id', $obj->country_id)->delete();

        if($value){
            session()->flash('delete',trans('flash.DeletedSuccessfully'));
            return redirect("admin/country");
        }
    }

    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'At least one item is required to be checked');

        } else {
            Country::whereIn('id', $request->checked)->delete();
            Session::flash('success', trans('Deleted Successfully'));
            return redirect()->back();

        }
    }

    public function upload_info(Request $request) 
    {
        $id = $request['catId'];
        
        $country = Allcountry::findOrFail($id);
        $upload = State::where('country_id',$country->id)->pluck('name','state_id')->all();

        return response()->json($upload);
    }


    public function gcity(Request $request) 
    {

        $id = $request['catId'];

        $state = Allstate::findOrFail($id);
        $upload = City::where('state_id',$state->id)->pluck('name','id')->all();

        return response()->json($upload);

    }

    public function get_state_country(Request $request)
    {
        $city = City::where('name',$request->city)->first();
        if($city){
            $state = Allstate::where('id',$city->state_id)->first();
            $country = Allcountry::where('id',$city->country_id)->first();
            if($state && $country){
                $data['status'] = "True";
                $data['city_id'] = $city->id;
                $data['state'] = $state->name;
                $data['state_id'] = $state->id;
                $data['country'] = $country->name;
                $data['country_id'] = $country->id;
            } else {
                $data['status'] = "False";
                $data['msg'] = "State And Country Not Found";
            }
        } else {
            $data['status'] = "False";
            $data['msg'] = "City Not Found";
        }
        return response()->json($data);
    }



}
