<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;

class ChargilyPayController extends Controller
{
    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    public function initiatePayment(Request $request)
    {
        // Retrieve API credentials from configuration
        $apiKey = env('CHARLI_API_KEY');
        $secretKey = env('CHARLI_SECRET_KEY');
        $amount = Crypt::decryptString($request->amount);

        // Make API request to initiate payment
        try {
            $response = $this->httpClient->post('https://api.charli.com/payment/create', [
                'json' => [
                    'api_key' => $apiKey,
                    'amount' => $amount,
                    // Add other required parameters such as currency, description, etc.
                ]
            ]);
            // Check if request was successful
            if ($response->getStatusCode() == 200) {
                $responseData = json_decode($response->getBody(), true);
                
                // Check if payment initiation was successful
                if ($responseData['success']) {
                    // Redirect user to payment page
                    return redirect()->away($responseData['payment_url']);
                } else {
                    // Handle payment initiation failure
                    return redirect()->back()->with('error', 'Failed to initiate payment. Please try again later.');
                }
            } else {
                // Handle HTTP request failure
                return redirect()->back()->with('error', 'Failed to communicate with payment gateway. Please try again later.');
            }
        } catch (\Exception $e) {
            return $e;
            // Handle any exceptions
            return redirect()->back()->with('error', 'An error occurred. Please try again later.');
        }
    }

    public function verifyPayment(Request $request)
    {
        // Retrieve API credentials from configuration
        $apiKey = config('charli.api_key');
        $secretKey = config('charli.secret_key');

        // Make API request to verify payment
        try {
            $response = $this->httpClient->post('https://api.charli.com/payment/verify', [
                'json' => [
                    'api_key' => $apiKey,
                    'payment_id' => $request->payment_id,
                    // Add other required parameters for verification
                ]
            ]);
            return $response;
            // Check if request was successful
            if ($response->getStatusCode() == 200) {
                $responseData = json_decode($response->getBody(), true);

                // Check payment verification status
                if ($responseData['success']) {
                    // Payment verified, update database or perform other actions
                    return redirect()->route('payment.success')->with('success', 'Payment successful.');
                } else {
                    // Payment verification failed
                    return redirect()->route('payment.failure')->with('error', 'Payment verification failed. Please contact support.');
                }
            } else {
                // Handle HTTP request failure
                return redirect()->route('payment.failure')->with('error', 'Failed to communicate with payment gateway. Please try again later.');
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return redirect()->route('payment.failure')->with('error', 'An error occurred. Please try again later.');
        }
    }
}
