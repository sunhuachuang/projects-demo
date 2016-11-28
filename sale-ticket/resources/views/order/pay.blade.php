@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Order <h3>(don't scan, it is test only.)</h3></div>
                <div class="panel-body">
                    <p><span>needed pay: </span><strong><i>{{ $order->amount  }}</i></strong></p>
                    <p class="text-center">
                        <img src="{{ asset('cart.jpg') }}" width="240" height="325"/>
                    </p>
                    <a href="{{ url('orders/pay/' . $order->id . '/ok')  }}" class="btn btn-success center-block">if you pay, click it.</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
