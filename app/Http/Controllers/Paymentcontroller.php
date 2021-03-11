<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Paystack;
use App\Models\Payment;
use App\Models\Order;
use Session;
//use Mail;

class Paymentcontroller extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(Request $request)
    {
        $data = $request->all();
        \Session::put('order_id', $request->order_id);
        Payment::create($data);
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }        
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        
        $order_id = \Session::get('order_id');
        //dd($paymentDetails);

        if($paymentDetails['data']['status']=='success' && $paymentDetails['message']=='Verification successful')
        {
            Payment::where('reference',$paymentDetails['data']['reference'])->first()->update(['status'=>1]);
            Order::where('id',$order_id)->first()->update(['pay_status'=>1]);

            /*
            $details = [
                'title' => 'Freight Confirmation Order',
                'body' => 'Thank you for your Order. Your payment successful. Your Order is now under processing'
            ];
           
            \Mail::to(auth()->user()->email)->send(new \App\Mail\MyTestMail($details));
            */

            return redirect()->route('order.index')->with('message','Thank you. Payment successful. Your Order is now under processing');
        }
        else
        {
            return redirect()->route('order.index')->with('message','Sorry. The transaction failed.');
        }
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
