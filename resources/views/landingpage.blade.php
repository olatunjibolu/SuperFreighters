@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title">Freights/Cargo/Shipment</h5>
            <p class="card-text">
Call it Freight, cargo or shipment, we help you transport goods (Cars and Equipments) from the US and UK to Nigeria. Freight is the general term for goods transported from one place to another by any means: Cargo is the term generally used for goods carried by ship or plane: to send a cargo to Nigeria. Shipment is a quantity of goods destined for a particular place, no matter how sent: a shipment of cars/equipments.</p>
        </div>
    </div>
    <div class="row justify-content-center">
       @foreach($categories as $category)
        <div class="col-md-12">
            <h2 style="color: blue;">{{$category->name}}</h2>
            <div class="jumbotron">
                 <div class="row">
                @foreach(App\Models\Product::where('category_id',$category->id)->get() as $product)
                <div class="col-md-3">
                   
                    <img src="{{asset('images')}}/{{$product->image}}" width="200" height="155">
                    <p class="text-center">
                    	{{$product->name}}
                        <br><span>Weight: {{$product->weight}}kg</span>

                    </p>
                       <p class="text-center">
                       <a href="{{route('product.view',[$product->id])}}">
                        <button class="btn btn-outline-danger">
                          View
                        </button>

                       </a>
                        </p>
                </div>
                
                @endforeach
            </div>
            </div>

        </div>
       @endforeach
    </div>
</div>
@endsection
