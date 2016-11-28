<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index', [
            'orders' => Order::orderBy('created_at', 'asc')->get(),
        ]);
    }

    public function ok(Order $order)
    {
        $order->pay = 2;
        $order->save();
        return redirect('admin/orders');
    }
}
