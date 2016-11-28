@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tickets</div>
                <div class="panel-body row">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/ticket_images/'.$ticket->image) }}" />
                    </div>
                    <div class="col-md-8">
                        @include('common.errors')
                        <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="post" class="form" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                            <p><label>name</label>
                                <input type="text" name="name" class="form-control" value="{{ $ticket->name }}"/>
                            </p>
                            <p><label>number</label>
                                <input type="number" name="number" class="form-control" value="{{ $ticket->number }}"/>
                            </p>
                            <p><label>price</label>
                                <input type="text" name="price" class="form-control"value="{{ $ticket->price }}"/>
                            </p>
                            <p><label>image</label>
                                <input type="file" name="image" />
                            </p>
                            <p><button type="submit" class="btn btn-default btn-block">submit</button></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
