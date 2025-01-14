<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Session;
use Redirect;
use URL;

class PaypalController extends Controller
{
    private $client_id;
    private $secret;
    private $paypal_base_url;
    
    public function __construct()
    {
        $this->client_id = config('paypal.client_id');
        $this->secret = config('paypal.secret');
        $this->paypal_base_url = config('paypal.settings.mode') === 'live'
            ? 'https://api.paypal.com'
            : 'https://api.sandbox.paypal.com';
    }

    public function payWithpaypal(Request $request)
    {
        $pay = $request->amount;
        Session::put('payment', $pay);

        // Step 1: Get Access Token
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return redirect('/')->with('error', 'Unable to get PayPal access token.');
        }

        // Step 2: Create Payment
        $paymentResponse = $this->createPayment($pay, $accessToken);

        if (isset($paymentResponse['links'])) {
            foreach ($paymentResponse['links'] as $link) {
                if ($link['rel'] == 'approval_url') {
                    $redirect_url = $link['href'];
                    break;
                }
            }
            // Save payment ID in session for later use
            Session::put('paypal_payment_id', $paymentResponse['id']);
            
            return Redirect::away($redirect_url);
        }

        return redirect('/')->with('error', 'Unable to create PayPal payment.');
    }

    private function getAccessToken()
    {
        $client = new Client();
        $response = $client->post($this->paypal_base_url . '/v1/oauth2/token', [
            'auth' => [$this->client_id, $this->secret],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ],
        ]);

        $body = json_decode($response->getBody(), true);
        return $body['access_token'] ?? null;
    }

    private function createPayment($amount, $accessToken)
    {
        $client = new Client();
        $response = $client->post($this->paypal_base_url . '/v1/payments/payment', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'intent' => 'sale',
                'payer' => [
                    'payment_method' => 'paypal',
                ],
                'transactions' => [
                    [
                        'amount' => [
                            'total' => $amount,
                            'currency' => 'USD',
                        ],
                        'description' => 'Payment description',
                    ]
                ],
                'redirect_urls' => [
                    'return_url' => URL::route('status'),
                    'cancel_url' => URL::route('status'),
                ],
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getPaymentStatus(Request $request)
    {
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');

        if (empty($request->get('PayerID')) || empty($request->get('token'))) {
            return redirect('/')->with('error', 'Payment failed.');
        }

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return redirect('/')->with('error', 'Unable to get PayPal access token.');
        }

        // Execute Payment
        $client = new Client();
        $response = $client->post($this->paypal_base_url . "/v1/payments/payment/{$payment_id}/execute", [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'payer_id' => $request->get('PayerID'),
            ]
        ]);

        $result = json_decode($response->getBody(), true);

        if ($result['state'] == 'approved') {
            // Handle successful payment (e.g., save order)
            return redirect('/')->with('success', 'Payment successful!');
        }

        return redirect('/')->with('error', 'Payment failed.');
    }
}
