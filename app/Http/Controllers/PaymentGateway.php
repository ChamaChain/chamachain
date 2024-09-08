<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Carbon\Carbon;

class PaymentGateway extends Controller
{
  public function getContributions(Request $request){
    return view('contributions',
[
            'user' => $request->user(),

]);
  }

    /**
      * Display the user's profile form.
     */
    public function getAuthCredentials()
    {
      // Initialize a cURL session
    $ch = curl_init();

    // Set the URL for the GET request
    $url =  env('AUTHORIZATION_URL');
    $client_key =  env('CONSUMER_KEY');
    $client_secret =  env('CONSUMER_SECRET_KEY');
    $blob =  $client_key.":".$client_secret;
    $basic_auth =  base64_encode($blob);

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic '.$basic_auth]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request and store the response
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        // Decode the response and print it (assuming JSON response)
        $result = json_decode($response, true);
        return $result['access_token'];
    }

    // Close the cURL session
    curl_close($ch);
    }

    public function LipaNaMpesaApi($access_token, $phoneNumber, $amount) {
            $curl = curl_init();

            // Set the URL for the GET request
            $client_key =  env('CONSUMER_KEY');
            $client_secret =  env('CONSUMER_SECRET_KEY');
            $short_code =  env('SHORT_CODE');
            $pass_key =  env('PASS_KEY');
            $skt_push_url =  env('STK_PUSH_URL');

            $timestamp = Carbon::now()->format('YmdHis');
            $blob =  $short_code.$client_secret.$timestamp;
            $password =  base64_encode($blob);

            // get user from the session
            $phone = $phoneNumber || 254746613059;
            $user = Auth::user();

            $callbackUrl = route('mpesa.callback'); // Replace with your route name


            $stkData = [
                "BusinessShortCode"=> 174379,
                "Password"=> 'MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjQwOTA4MDczOTMz',
                "Timestamp"=> '20240908073933',
                "TransactionType"=> "CustomerPayBillOnline",
                "Amount" => 1,
                "PartyA"=> $phone,
                "PartyB"=> 174379,
                "PhoneNumber"=> $phone,
                "CallBackURL"=> "https://mydomain.com/path",
                "AccountReference"=> "CompanyXLTD",
                "TransactionDesc" => "Payment of X"
            ];

            $stkHeaders = [
                'Authorization: Bearer '.$access_token,
                'Content-Type: application/json'
            ];



            curl_setopt($curl, CURLOPT_URL, $skt_push_url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $stkHeaders);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stkData));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            // Execute the request and store the response
            $response = curl_exec($curl);

            // Check for errors
            if (curl_errno($curl)) {
                echo 'cURL Error: ' . curl_error($curl);
            } else {
                // Decode the response and print it (assuming JSON response)
                $result = json_decode($response, true);
                return $result;
            }
            curl_close($curl);

            // Close the cURL session
    }


    /**
     * Display the user's profile form.
     */
    public function makeContribution(Request $request): RedirectResponse
    {

        try {
            $phoneNumber = $request->phoneNumber;
            $amount = $request->amount;

 $access_token = $this->getAuthCredentials();

        $response = $this->LipaNaMpesaApi($access_token, $phoneNumber, $amount);

             return redirect()->route('dashboard')->with('status', 'Payment Successful');

            } catch (\Exception $e) {
        \Log::error($e->getMessage());
      return Redirect::route->back()->with('status', 'Failed To Initiate Payment! Please try again');
    }

    }

    public function paymentCallback(Request $request) {
        $response = $request->all();
        // Do something with the response
        // update user table with the payment information from the session


        // send confirmation to user
        // redirect to a success page
        return redirect()->route('dashboard')->with('status', 'Payment Successful');
    }

      public function checkTransactionStatus(Request $request) {
        $response = $request->all();
        // Do something with the response
        // update user table with the payment information from the session


        // send confirmation to user
        // redirect to a success page
        return redirect()->route('dashboard')->with('status', 'Payment Successful');
    }



}
