<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transportation;
use App\Models\Country;
//use App\Mail\SendMail;
class Ordercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->where('user_id',auth()->user()->id)->get();
      
        return view('order.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request,[
            'transportation_id'=>'required'
        ]);
        
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['product_id'] = $id;
        $product = Product::find($id);
        $data['country_id'] = $product->country_id;
        $data['transportation_id'] = $request->transportation_id;
        $transport = Transportation::find($data['transportation_id']);
        $data['transport_charge'] = $transport->base_amount;
        $data['weight_charge'] = $transport->amount_perkg * $product->weight;
        $country = Country::find($data['country_id']);
        $data['countryoforigin_charge'] = $country->charge;
        $data['total_charge'] = $data['transport_charge'] + $data['weight_charge'] + $data['countryoforigin_charge'];
        $data['tax'] = 0.1 * $data['total_charge'];
        $data['total_payable'] = $data['transport_charge'] + $data['weight_charge'] + $data['countryoforigin_charge'] + $data['tax'];
        
        switch ($transport->name) {
            case "Air":
                $deliveryDate = Date('y:m:d', strtotime('+2 days'));
              break;
            case "Sea":
                $deliveryDate = Date('y:m:d', strtotime('+20 days'));
              break;
            default:     
        }
        
        $data['delivery_date'] = $deliveryDate;

        Order::create($data);
        //return redirect()->back()->with('message','Order created Successfully. Please, proceed to pay.');
        return redirect()->route('order.index')->with('message','Order created Successfully. Please, proceed to pay.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $product = Product::find($order['product_id']);
        $country = Country::find($order['country_id']);
        $transportation = Transportation::find($order['transportation_id']);
        return view('order.show',compact('order', 'product', 'country', 'transportation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $order = Order::find($id);
       $order->delete();
       return redirect()->back()->with('message','Your Order has been deleted Successfully.');
       
    }

    public function initialise(Request $request, $id)
    {
        $this->validate($request,[
            'order_id'=>'required',
            'cost'=>'required'
        ]);

        $data = $request->all();
        $amount = $request->cost * 100;

        // url to go to after payment
        $callback_url = 'http://localhost/superfreighters/order/callback'; 

        $url = "https://api.paystack.co/transaction/initialize";
        $fields = [
            'email' => auth()->user()->email,
            'amount' => $amount,
            'callback_url' => $callback_url
        ];
        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer sk_test_2459625499cb7f01744b8dd3611cbc306dc63639",
            "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        $response = curl_exec($ch);
        $err = curl_error($ch);

        if($err){
        // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response, true);

        if(!$tranx['status']){
        // there was an error from the API
        print_r('API returned error: ' . $tranx['message']);
        }

        // comment out this line if you want to redirect the user to the payment page
        print_r($tranx);
        // redirect to page so User can pay
        // uncomment this line to allow the user redirect to the payment page
        header('Location: ' . $tranx['data']['authorization_url']);


    }

    public function callback()
    {

        $curl = curl_init();
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if(!$reference){
        die('No reference supplied');
        }

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authorization: Bearer sk_test_2459625499cb7f01744b8dd3611cbc306dc63639",
            "cache-control: no-cache"
        ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response);

        if(!$tranx->status){
        // there was an error from the API
        die('API returned error: ' . $tranx->message);
        }

        if('success' == $tranx->data->status){
        // transaction was successful...
        // please check other things like whether you already gave value for this ref
        // if the email matches the customer who owns the product etc
        // Give value
        echo "<h2>Thank you for making a purchase. Your file has bee sent your email.</h2>";
        }
    }

    public function report()
    {
        return "Thank you";
        /*
        $details = [
            'body'=>'Thank you for making an Order. Your Order is now under processing'
        ];
                
        \Mail::to(auth()->user()->email)
        ->send(new SendMail($details));

        return redirect()->route('order.index')->with('message','Thank You! A notification has been sent to your email address.');
        */
    }
}
