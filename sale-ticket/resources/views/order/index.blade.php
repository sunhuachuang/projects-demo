@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Order</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>ticket</th>
                            <th>number</th>
                            <th>amount</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->ticket->name }}</td>
                                    <td>{{ $order->number }}</td>
                                    <td>{{ $order->amount }}</td>
                                    @if($order->pay === 0)
                                    <td><a class="btn btn-sm btn-default" href="{{ url('orders/pay/' . $order->id) }}">pay</a></td>
                                    <td>
                                        <form action="{{ url('orders/delete/' . $order->id)  }}" method="post">
                                            {!! csrf_field() !!}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-xs">delete</button>
                                        </form>
                                    </td>
                                    @elseif($order->pay === 1)
                                    <td><p class="text-primary">pay ok, wait...</p></td>
                                    @else
                                    <td><p class="text-success">ok.</p></td>
                                    @endif
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
