<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Ticket;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('order.index', [
            'orders' => Order::where('user_id', $request->user()->id)->get(),
        ]);
    }

    public function new(Ticket $ticket, Request $request)
    {
        $order = new Order();
        $this->validate($request, [
            'number' => 'required|max:'. $ticket->number,
        ]);

        $order->customSave($ticket, $order, $request);
        return redirect('orders');
    }

    public function pay(Order $order)
    {
        return view('order.pay', [
            'order' => $order,
        ]);
    }

    public function payOk(Order $order)
    {
        $order->pay = 1;
        $order->save();
        return redirect('orders');
    }

    public function delete(Order $order)
    {
        $this->authorize('destroy', $order);
        $order->customDelete($order);
        return redirect('orders');
    }
}
