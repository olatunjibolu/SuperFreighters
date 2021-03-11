@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(Session::has('message'))
                <div class="alert alert-success">   {{Session::get('message')}}
                </div>
            @endif
            <div class="card">
                <div class="card-header">All Orders</div>

                <div class="card-body">
                    <table class="table mt-5"  id="dataTable">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">From</th>
                  <th scope="col">To</th>
                  <th scope="col">Delivery Date</th>
                  
                  <th scope="col">Shipment</th>
                  <th scope="col">Amount</th>
                  <th scope="col">Cancel</th>
                  <th scope="col">Status</th>
               
                <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                <tr>
                  <td> {{$order->product->name}}</td>
                  <td>{{$order->country->name}}</td>
                  <td>Nigeria</td>
                  <td>{{$order->delivery_date}}</td>
                  
                  <td>{{$order->transportation->name}}</td>
                  <td>&#8358;{{$order->total_payable}}</td>
                  <td>
                  @if($order->pay_status==0)
                  <a href="#" data-toggle="modal" class="btn btn-outline-danger" data-target="#exampleModal{{$order->id}}">
                       Cancel Order
                    </a>
                      <!-- Modal -->
                <div class="modal fade" id="exampleModal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <form action="{{route('order.destroy',[$order->id])}}" method="post">@csrf
                    {{method_field('DELETE')}}
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Confirm Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure you want to cancel this order?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                      </div>
                    </div>
                  </form>
                  </div>
                </div>
                @endif
                  </td>
                  <td>
                      @if($order->pay_status==0)
                      <span class="alert alert-danger">Not Paid</span>
                      @else
                      <span class="alert alert-success">Paid</span>
                      @endif
                  </td>
                  
                  <td>
                  @if($order->pay_status==0)
                      <a href="{{route('order.show',[$order->id])}}" class="btn btn-outline-success">
                       Make Payment
                    </a>
                  @endif
                
                  </td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
