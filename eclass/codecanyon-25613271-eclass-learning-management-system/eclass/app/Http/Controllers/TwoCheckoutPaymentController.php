<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Twocheckout;
use Twocheckout_Charge;
use Twocheckout_Error;

class TwoCheckoutPaymentController extends Controller
{
    public function callback(Request $request)
    {
    	return $request;
    }

    public function twocheckout(Request $request)
    {

    	require_once(resource_path().'/'.'views/lib/Twocheckout.php');


  //   	Twocheckout::username('noshenhussain@gmail.com');
		// Twocheckout::password('Noshen@5429');


    	Twocheckout::privateKey('F6^gktv8d9x7rS|NTz03');
        Twocheckout::sellerId('250778633144');
        // Twocheckout::sandbox(false);

        Twocheckout::verify(false);
        Twocheckout::format('json');


       try {
		    $charge = Twocheckout_Charge::auth(array(
		        "merchantOrderId" => "123",
		        "token" => 'Y2U2OTdlZjMtOGQzMi00MDdkLWJjNGQtMGJhN2IyOTdlN2Ni',
		        "currency" => 'USD',
		        "total" => '10.00',
		        "billingAddr" => array(
		            "name" => 'Testing Tester',
		            "addrLine1" => '123 Test St',
		            "city" => 'Columbus',
		            "state" => 'OH',
		            "zipCode" => '43123',
		            "country" => 'USA',
		            "email" => 'testingtester@2co.com',
		            "phoneNumber" => '555-555-5555'
		        ),
		        "shippingAddr" => array(
		            "name" => 'Testing Tester',
		            "addrLine1" => '123 Test St',
		            "city" => 'Columbus',
		            "state" => 'OH',
		            "zipCode" => '43123',
		            "country" => 'USA',
		            "email" => 'testingtester@2co.com',
		            "phoneNumber" => '555-555-5555'
		        )
		    ), 'array');
		    if ($charge['response']['responseCode'] == 'APPROVED') {
		        echo "Thanks for your Order!";
		    }
		} catch (Twocheckout_Error $e) {
			return $e->getMessage();
		    $e->getMessage();
		}
    
    }
}
