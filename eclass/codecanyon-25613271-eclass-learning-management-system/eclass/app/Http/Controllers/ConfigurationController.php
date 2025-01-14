<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class ConfigurationController extends Controller
{

    private $key;

    public function __construct()
    {
        $this->key = DB::table('api_keys')
                        ->where('id', '2')
                        ->first();
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index(Request $request,$theme)
    {
        $module = Module::find($theme);
        
        ini_set("zlib.output_compression", "Off");

        $key = $this->key;
        
        return view('configuration', compact('key','module'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function update(Request $request,$theme)
    {
        if (config('app.demolock') == 1) {
            return back()->with('delete', 'Disabled in demo');
        }
        
        $module = Module::find($theme);
        $d = \Request::getHost();

        $domain = str_replace("www.", "", $d);

        if (strstr($domain, 'localhost') || strstr($domain, '192.168.') || strstr($domain, '.test') || strstr($domain, 'mediacity.co.in') || strstr($domain, 'castleindia.in')) {

            if(!$this->key){

                $secret = Str::uuid();

                DB::table('api_keys')
                    ->insert([
                        'secret_key' => filter_var($secret), 
                        'user_id'    => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
            }
            
            if( $request->status=='on')
            {
                $module->enable();
                $env = DotenvEditor::setKeys([
                    'DEFAULT_THEME' => 'blizzard',
                ]);
            }
            else{
                $module->disable();
            }

            $env = DotenvEditor::setKeys([
                'MIX_THEME_FOLDER' => $request->mix_theme,
            ]);

            $env->save();

            Session::flash('success', 'Updated successfully');
            return back()->withInput();


        } else {

            $request->validate([
                'purchase_code' => 'required',
            ],[
                'purchase_code.required' => 'Please enter your envato purchase code !',
            ]);

            $code = request()->purchase_code;

            if( $request->status=='on')
            {
                $module->enable();
            }
            else{
                $module->disable();
            }

            $personalToken = "inNy83FTjV2CTPqvNdPGRr2mAJ0raPC4";
            if (!preg_match("/^(\w{8})-((\w{4})-){3}(\w{12})$/", $code)) {
                //throw new Exception("Invalid code");
                $message = __("Invalid Purchase Code");
                return back()->withErrors($message)->withInput();
            }
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 20,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$personalToken}",
                ),
            ));
            // Send the request with warnings supressed
            $response = curl_exec($ch);
            // Handle connection errors (such as an API outage)
            if (curl_errno($ch) > 0) {
                //throw new Exception("Error connecting to API: " . curl_error($ch));
                $message = __("Error connecting to API !");
                return back()->withErrors($message)->withInput();
            }
            // If we reach this point in the code, we have a proper response!
            // Let's get the response code to check if the purchase code was found
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // HTTP 404 indicates that the purchase code doesn't exist
            if ($responseCode === 404) {
                //throw new Exception("The purchase code was invalid");
                $message = __("Purchase Code is invalid");
                return back()->withErrors($message)->withInput();
            }
            // Anything other than HTTP 200 indicates a request or API error
            // In this case, you should again ask the user to try again later
            if ($responseCode !== 200) {
                //throw new Exception("Failed to validate code due to an error: HTTP {$responseCode}");

                $message = __("Failed to validate code.");
                return back()->withErrors($message)->withInput();
            }
            // Parse the response into an object with warnings suppressed
            $body = json_decode($response);
            // Check for errors while decoding the response (PHP 5.3+)
            if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
                //new Exception("Error parsing response");
                $message = __("Can't Verify Now.");
                return back()->withErrors($message)->withInput();
            }
            if ($body->item->id == '34807246') {

                // success

                $env = DotenvEditor::setKeys([
                    'MIX_THEME_FOLDER' => $request->mix_theme,
                ]);

                $env->save();

                Session::flash('success', 'Updated successfully');
                return back();

            } else {

                $message = __("Please enter Blizzard Theme purchase code.");

                Session::flash('deleted', $message);
                return back()->withInput();
            }

        }
    }

    /** This function is used to re-generate api key for theme */
    /** @return Response json */

    public function reGenerate(){

        /** Check demo lock */

        if(request()->ajax()){

            if (config('app.demolock') == 1) {

                return response()->json([
                    'status' => 'fail',
                    'msg'    => __('This action is disabled in demo !')
                ]);

            }
    
            if(!$this->key){
    
                $secret = Str::uuid();
    
                DB::table('api_keys')
                    ->insert([
                        'secret_key' => filter_var($secret), 
                        'user_id'    => auth()->id(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
    
            }else{
                
                $secret = Str::uuid();
    
                DB::table('api_keys')
                    ->where('id','=','2')
                    ->update([
                        'secret_key' => filter_var($secret),
                        'updated_at' => now()
                    ]);
                
            }
    
            return response()->json([
                'status' => 'success',
                'msg'    => __('Keys updated successfully !'),
                'key'    =>  DB::table('api_keys')
                            ->where('id', '2')
                            ->first()
                            ->secret_key
            ]);
        }

    }

    /** This function is used to get api key for theme */
    /** @return Response json */


    public function getSecret(){

        if(request()->ajax()){

            try{

                return response()->json([
                    'status' => 'success',
                    'key'    =>  DB::table('api_keys')
                                ->where('id', '2')
                                ->first()
                                ->secret_key
                ]);

            }catch(\Exception $e){

                return response()->json([
                    'status' => 'fail',
                    'key'    => $e->getMessage()
                ]);

            }
        }

    }
}