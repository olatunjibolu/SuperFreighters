@extends('layouts.app')

@section('content')
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
                <div class="card-header">Detail</div>

                <div class="card-body">
                    <p><h2>{{$product->name}}</h2></p>
                    <p class="lead">{{$product->description}}</p>
                    <p><h4>Weight: {{$product->weight}}kg</h4></p>
                    <p><h4>Location: {{$country->name}}</h4></p>
                    <p class="text-left">
                    @guest
                        <a href="{{ route('login') }}">
                        @else
                        <a href="{{route('product.view',[$product->id])}}">
                    @endguest
                        <button class="btn btn-outline-danger">
                          Order Freight
                        </button>

                       </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
