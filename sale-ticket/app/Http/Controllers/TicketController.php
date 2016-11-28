<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        return view('ticket.index', [
            'tickets' => Ticket::orderBy('created_at', 'desc')->get(),
        ]);
    }
}
