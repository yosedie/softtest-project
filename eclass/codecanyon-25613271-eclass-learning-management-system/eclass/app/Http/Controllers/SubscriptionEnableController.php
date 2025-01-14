<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Support\Facades\Http;
use DotenvEditor;
use Session;
use Spatie\Permission\Models\Role;


class SubscriptionEnableController extends Controller
{
	public function __construct()
    {
		$this->middleware('permission:instructor-instructor-plan.manage', ['only' => ['view','settings']]);
    
    }
    public function view(Request $request)
    {
		return view('admin.instructor.plan.settings');
	}


    public function settings(Request $request)
    {

    	if(isset($request->ENABLE_INSTRUCTOR_SUBS_SYSTEM)){
            // $this->verifyPurchase();
			request()->validate([
	            'purchase_code' => 'required'
	        ]);
	        $code = request()->purchase_code;
			$personalToken = "inNy83FTjV2CTPqvNdPGRr2mAJ0raPC4";
	        if (!preg_match("/^(\w{8})-((\w{4})-){3}(\w{12})$/", $code)) {
	            //throw new Exception("Invalid code");
	            $message = __("Invalid Purchase Code");
	            return back()->withErrors($message)->withInput();;
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
	            return back()->withErrors($message)->withInput();;
	        }
	        // If we reach this point in the code, we have a proper response!
	        // Let's get the response code to check if the purchase code was found
	        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	        // HTTP 404 indicates that the purchase code doesn't exist
	        if ($responseCode === 404) {
	            //throw new Exception("The purchase code was invalid");
	            $message = __("Purchase Code is invalid");
	            return back()->withErrors($message)->withInput();;
	        }
	        // Anything other than HTTP 200 indicates a request or API error
	        // In this case, you should again ask the user to try again later
	        if ($responseCode !== 200) {
	            //throw new Exception("Failed to validate code due to an error: HTTP {$responseCode}");
	            
	            $message = __("Failed to validate code.");
	            return back()->withErrors($message)->withInput();;
	        }
	        // Parse the response into an object with warnings supressed
	        $body = json_decode($response);
	        // Check for errors while decoding the response (PHP 5.3+)
	        if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
	            //new Exception("Error parsing response");
	            $message = __("Can't Verify Now.");
	            return back()->withErrors($message)->withInput();
	        }
	        if($body->item->id == '25613271'){
	            if($body->license == 'Extended License'){
	                $env_keys_save = DotenvEditor::setKeys([
	                    'ENABLE_INSTRUCTOR_SUBS_SYSTEM' => 1
	                ]);
	                $env_keys_save->save();
	                Storage::disk('local')->put('/extended/'.'extended.json',$code);
	               

	                Session::flash('success', 'Instructor subscription enabled successfully !');
        			return back()->withInput();
	            }


	            $env_keys_save = DotenvEditor::setKeys([
	                'ENABLE_INSTRUCTOR_SUBS_SYSTEM' => 0
	            ]);


	            $env_keys_save->save();
	            

	            Session::flash('delete', 'Instructor subscription cannot be enabled with this Regular license.');
        		return back()->withInput();

	        }else{
				$env_keys_save = DotenvEditor::setKeys([
	                'ENABLE_INSTRUCTOR_SUBS_SYSTEM' => 0
	            ]);
				$env_keys_save->save();
	            Session::flash('delete', 'Instructor subscription cannot be enabled with this purchase code.');
        		return back()->withInput();
	        }
        }else{
            $env_keys_save = DotenvEditor::setKeys([
                'ENABLE_INSTRUCTOR_SUBS_SYSTEM' => 0
            ]);
            $env_keys_save->save();
        }

    }
	public function verifyPurchase(){

        
    }
}
