<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class InitializeController extends Controller
{
    public function verify(Request $request)
    {

        $d = \Request::getHost();
        $domain = str_replace("www.", "", $d);   
     
        $alldata = ['app_id' => "25613271", 'ip' => "127.0.0.1", 'domain' => $domain , 'code' => $request->code];
        $data = $this->make_request($alldata);

        if ($data['status'] != 1)
        {   
            $put = 1;
            file_put_contents(public_path().'/config.txt', $put);
            $status = 'complete';
            $status = Crypt::encrypt($status);
            @file_put_contents(public_path().'/step3.txt', $status);
            return redirect()->route('installApp');
        }
        elseif ($data['msg'] == 'Already Register')
        {   
            return back()->withErrors(['User is already registered']);
        }
        else
        {
            return back()->withErrors([$data['msg']]);
        }
    }

    public function make_request($alldata)
    {
        $lic_json = array(
        
            'name'     => request()->user_id,
            'code'     => 'code',
            'type'     => __('envato'),
            'domain'   => 'domain',
            'lic_type' => __('regular'),
            'token'    => 'token'
            
        );

        $file = json_encode($lic_json);
        
        $filename =  'license.json';

        Storage::disk('local')->put('/keys/'.$filename,$file);

        return array(
            'msg' => 'Valid license!',
            'status' => '1'
        );
    }

}

