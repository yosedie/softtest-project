<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adsense;
use Session;
use Spatie\Permission\Models\Role;

class AdsenseController extends Controller
{
  public function __construct()
    {
    
      $this->middleware('permission:adsense-setting.manage', ['only' => ['index','update']]);
    
    }
    public function index()
    {
        $ad = Adsense::first();
        return view('admin.adsense.edit', compact('ad'));
    }

  
    public function update(Request $request)
    {
        $data = $this->validate($request, [
            'code' => 'required',
        ]);

       	$ad = Adsense::first();
        $input = $request->all();

        if(isset($ad))
        {
        
          if($request->status == 'on')
          {
            $input['status'] = '1';
          }
          else
          {
            $input['status'] = '0';
          }

         	if($request->ishome == 'on')
         	{
           	$input['ishome'] = '1';
        	}else
        	{
           	$input['ishome'] = '0';
        	}

         	if($request->isviewall == 'on')
         	{
           	$input['isviewall'] = '1';
    	    }
    	    else
    	    {
    	      $input['isviewall'] = '0';
    	    }

          if($request->iscart == 'on')
          {
           	$input['iscart'] = '1';
        	}else
        	{
           	$input['iscart'] = '0';
        	}

          if($request->iswishlist == 'on')
          {
           	$input['iswishlist'] = '1';
        	}
        	else
        	{
           	$input['iswishlist'] = '0';
        	}

        	if($request->isdetail == 'on')
          {
           	$input['isdetail'] = '1';
        	}
        	else
        	{
           	$input['isdetail'] = '0';
        	}
        	
            $ad->update($input);
            Session::flash('success', trans('flash.UpdatedSuccessfully'));
            return redirect()->route('adsense');

        }
        else
        {
          if($request->status == 'on')
          {
            $input['status'] = '1';
          }
          else
          {
            $input['status'] = '0';
          }

          if($request->ishome == 'on')
          {
            $input['ishome'] = '1';
          }else
          {
            $input['ishome'] = '0';
          }

          if($request->isviewall == 'on')
          {
            $input['isviewall'] = '1';
          }
          else
          {
            $input['isviewall'] = '0';
          }

          if($request->iscart == 'on')
          {
            $input['iscart'] = '1';
          }else
          {
            $input['iscart'] = '0';
          }

          if($request->iswishlist == 'on')
          {
            $input['iswishlist'] = '1';
          }
          else
          {
            $input['iswishlist'] = '0';
          }

          if($request->isdetail == 'on')
          {
            $input['isdetail'] = '1';
          }
          else
          {
            $input['isdetail'] = '0';
          }

          $data = Adsense::create($input);
        
          $data->save();
            Session::flash('success', trans('flash.UpdatedSuccessfully'));
            return redirect()->route('adsense');
        }
      
        
      	

    }
}
