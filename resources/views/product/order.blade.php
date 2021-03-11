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
                <div class="card-header">Detail</div>

                <div class="card-body">
                    <p><h2>{{$product->name}}</h2></p>
                    <p class="lead">{{$product->description}}</p>
                    <p><h4>Weight: {{$product->weight}}kg</h4></p>
                    <p><h4>Location: {{$country->name}} (Charge: &#8358;{{$country->charge}})</h4></p>
                    <form action="{{route('order.store',[$product->id])}}" method="post">@csrf

                        <div class="form-group">
                            <label>Mode of Shipping</label>
                            <select class="form-control @error('transportation_id') is-invalid @enderror" name="transportation_id" required>
                                <option value=""></option>
                                @foreach(App\Models\Transportation::all() as $transportation)
                                    <option value="{{$transportation->id}}">By {{$transportation->name}} - (base charge: N{{$transportation->base_amount}}, Per kg: N{{$transportation->amount_perkg}})</option>
                                @endforeach
                            </select>
                            @error('transportation_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-danger">Order Freight</button>
                        </div>
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