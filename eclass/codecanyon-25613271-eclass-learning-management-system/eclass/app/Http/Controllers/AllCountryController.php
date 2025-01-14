<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Allcountry;
use App\Allstate;

class AllCountryController extends Controller
{
    public function upload_info(Request $request) 
    {
        
        $id = $request['catId'];
        
        $country = Allcountry::findOrFail($id);
        $upload = $country->states->where('country_id',$id)->pluck('name','id')->all();

        return response()->json($upload);
    }


    public function gcity(Request $request) 
    {
        $id = $request['catId'];

        $state = Allstate::findOrFail($id);
        $upload = $state->city->where('state_id',$id)->pluck('name','id')->all();

        return response()->json($upload);
    }
}
