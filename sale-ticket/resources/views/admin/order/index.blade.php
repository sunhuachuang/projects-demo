@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Order</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>user</th>
                            <th>ticket</th>
                            <th>number</th>
                            <th>amount</th>
                            <th>status</th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->username }}</td>
                                    <td>{{ $order->ticket->name }}</td>
                                    <td>{{ $order->number }}</td>
                                    <td>{{ $order->amount }}</td>
                                    <td>
                                        @if($order->pay === 0)
                                            <p class="text-default">wait pay</p>
                                        @elseif($order->pay === 1)
                                            <form action="{{ url('admin/orders/ok/'.$order->id) }}" method="post">
                                                {!! csrf_field() !!}
                                                <button type="submit" class="btn btn-sm btn-danger">OK ???</button>
                                            </form>
                                        @else
                                            <p class="text-success">it is ok</p>
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
