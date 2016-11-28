<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'amount', 'user_id', 'ticket_id', 'pay'
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function customSave(Ticket $ticket, Order $order, $request)
    {
        $order->number = $request->number;
        $order->amount = $request->number * $ticket->price;
        $order->user()->associate($request->user());
        $order->ticket()->associate($ticket);

        $ticket->number -= $request->number;
        $ticket->save();
        $order->save();
    }

    public function customDelete(Order $order)
    {
        $ticket = $order->ticket;
        $ticket->number += $order->number;
        $ticket->save();
        $order->delete();
    }
}
