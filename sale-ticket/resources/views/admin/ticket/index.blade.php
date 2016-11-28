@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tickets</div>
                <div class="panel-body">
                    <a class="btn btn-default" href="{{ route('admin.tickets.create') }}">new ticket</a>
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>name</th>
                            <th>number</th>
                            <th>price</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->name }}</td>
                                    <td>{{ $ticket->number }}</td>
                                    <td>{{ $ticket->price }}</td>
                                    <td>
                                        <a class="btn btn-xs" href="{{ route('admin.tickets.edit', ['id' => $ticket->id]) }}">edit</a>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.tickets.destroy', ['id' => $ticket->id]) }}">
                                            {!! csrf_field() !!}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-xs">delete</button>
                                        </form>
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
