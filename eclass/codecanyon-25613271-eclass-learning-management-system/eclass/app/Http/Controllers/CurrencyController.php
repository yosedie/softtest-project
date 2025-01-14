<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use Session;
use Spatie\Permission\Models\Role;

class CurrencyController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:currency.view', ['only' => ['show']]);
        
        $this->middleware('permission:currency.edit', ['only' => ['update']]);
        
    
    }
    public function show()
    {

    	$show = Currency::first();
    	return view('admin.currency.edit',compact('show'));
    }

    public function update(Request $request)
    {

    	$data = Currency::first();
        $input = $request->all();

        if(isset($data))
        {
            $data->update($input);
        }
        else
        {
            $data = Currency::create($input);
            $data->save();
        }

		return back()->with('success',trans('flash.UpdatedSuccessfully'));
    }


    public function CurrencySwitch($currency)
    {
        Session::put('changed_currency', $currency);
        return back();
    }

    
}
