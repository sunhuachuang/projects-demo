<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Order;
use App\User;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user, Order $order)
    {
        return $user->id === $order->user->id;
    }
}
