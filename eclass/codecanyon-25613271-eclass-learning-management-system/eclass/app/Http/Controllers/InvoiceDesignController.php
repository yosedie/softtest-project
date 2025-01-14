<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvoiceDesign;
use Spatie\Permission\Models\Role;


class InvoiceDesignController extends Controller
{
	
    public function __construct()
    {
		$this->middleware('permission:invoice-design.manage', ['only' => ['index','update']]);
      
    
    }
    public function index()
    {
    	$settings = InvoiceDesign::first();
    	return view('admin.invoice.settings', compact('settings'));
    }

    public function update(Request $request)
    {

    	$invoice = InvoiceDesign::first();

      	$input = $request->all();

        if(isset($invoice))
        {
            $invoice->border_color = $request->border_color;
            $invoice->border_radius = $request->border_radius;
            $invoice->border_style = $request->border_style;
            $invoice->date_format = $request->date_format;
      

            if(isset($request->logo_enable))
          	{
            	$invoice->logo_enable = 1;
          	}
          	else
          	{
            	$invoice->logo_enable = 0;
          	}

          	if(isset($request->border_enable))
          	{
            	$invoice->border_enable = 1;
          	}
          	else
          	{
            	$invoice->border_enable = 0;
          	}
			 
			  if (strstr($request->signature, '.png') || strstr($request->signature, '.jpg') || strstr($request->signature, '.jpeg') || strstr($request->signature, '.webp') || strstr($request->signature, '.gif')) {
				
                $input['signature'] = $request->signature;
				$invoice->signature =$input['signature'];

            } else {
                return back()->withInput()->with('deleted', __('Invalid file format Please use jpg,jpeg,png,webp and gif image format !'));
            }
		
			  $invoice->save();
        }
        else
        { 
        	$invoice->border_color = $request->border_color;
            $invoice->border_radius = $request->border_radius;
            $invoice->border_style = $request->border_style;
            $invoice->date_format = $request->date_format;

        	if(isset($request->logo_enable))
          	{
            	$invoice->logo_enable = 1;
          	}
          	else
          	{
            	$invoice->logo_enable = 0;
          	}

          	if(isset($request->border_enable))
          	{
            	$invoice->border_enable = 1;
          	}
          	else
          	{
            	$invoice->border_enable = 0;
          	}
			 
			   
			  if (strstr($request->signature, '.png') || strstr($request->signature, '.jpg') || strstr($request->signature, '.jpeg') || strstr($request->signature, '.webp') || strstr($request->signature, '.gif')) {
				return $request;
                $input['signature'] = $request->signature;
              
                $input['signature'] = $request->signature;
				$invoice->signature =$input['signature'];

            } else {
                return back()->withInput()->with('deleted', __('Invalid file format Please use jpg,jpeg,png,webp and gif image format !'));
            }
		
			  
            $invoice = InvoiceDesign::create($input);
          
            $invoice->save();
        }

    	return back()->with('success', 'Updated Successfully');
    }
}

