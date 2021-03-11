@extends('admin.layouts.master')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
    <div class="container">
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
                        <a href="{{route('home.view',[$product->id])}}">
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

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
@endsection