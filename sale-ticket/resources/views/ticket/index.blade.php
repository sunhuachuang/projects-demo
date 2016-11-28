@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($tickets as $ticket)
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $ticket->name }}</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('storage/ticket_images/'.$ticket->image) }}" />
                            </div>
                            <form action="{{ url('orders/new/'.$ticket->id) }}" class="form">
                                {!! csrf_field() !!}
                                <div class="col-md-6">
                                    <h3>{{ $ticket->name }}</h3>
                                    <p><strong>total:  </strong><i>{{ $ticket->number }}</i></p>
                                    <p><strong>price:  </strong><i>{{ $ticket->price }}</i></p>
                                    <p><label>buy number</label>
                                        <input type="number" name="number" class="form-control" value="1" />
                                    </p>
                                    <button class="btn btn-default center-block" type="submit">buy now !!!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
