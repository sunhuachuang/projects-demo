@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tickets</div>
                <div class="panel-body">
                    @include('common.errors')
                    <form action="{{ route('admin.tickets.store') }}" method="post" class="form" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <p><label>name</label>
                            <input type="text" name="name" class="form-control"/>
                        </p>
                        <p><label>number</label>
                            <input type="number" name="number" class="form-control"/>
                        </p>
                        <p><label>price</label>
                            <input type="text" name="price" class="form-control"/>
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
@endsection
