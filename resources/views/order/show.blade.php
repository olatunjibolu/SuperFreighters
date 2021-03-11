@extends('admin.layouts.master')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Product</div>
                    <img src="{{asset('images')}}/{{$product->image}}" class="img-responsibe" width="250">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
            @if(Session::has('message'))
                <div class="alert alert-success">   {{Session::get('message')}}
                </div>
            @endif
                <div class="card-header">Payment Order</div>

                <div class="card-body">
                    <p><h2>{{$product->name}}</h2></p>
                    <p><h4>Shipping: {{$transportation->name}} (Cost: &#8358;{{$order->transport_charge}})</h4></p>
                    <p><h4>Weight: {{$product->weight}}kg x {{$transportation->amount_perkg}} (Cost: &#8358;{{$order->weight_charge}})</h4></p>
                    <p><h4>Location: {{$country->name}} to Nigeria (Cost: &#8358;{{$order->countryoforigin_charge}})</h4></p>
                    <p><h4>Total: &#8358;{{$order->total_charge}}</h4></p>
                    <p><h4>10% Tax: &#8358;{{$order->tax}}</h4></p>
                    <p><h4><b>Total Payable</b>: &#8358;{{$order->total_payable}}</h4></p>
                    <!--<form action="#" method="post">@csrf
                    <form action="{{route('order.store',[$product->id])}}" method="post">
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-success">Pay via PayStack</button>
                        </div>
                    </form>-->
                    <!--<form>
                        <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
                        <input type="hidden" name="cost" id="cost" value="{{$order->total_payable}}">
                        <input type="hidden" name="email" id="email" value="{{auth()->user()->email}}">
                        <script src="https://js.paystack.co/v1/inline.js"></script>
                        <button type="button" onclick="payWithPaystack()"> Pay </button> 
                    </form>-->
                    <form action="{{route('pay')}}" method="post">@csrf
                        <input type="hidden" name="email" id="email" value="{{auth()->user()->email}}">
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                        <input type="hidden" name="amount" value="{{$order->total_payable * 100}}">
                        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                        <button type="submit" class="btn btn-outline-success">Pay via PayStack</button> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@endsection