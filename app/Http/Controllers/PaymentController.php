<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart_list = Cart::all();

        $price = $cart_list->sum(function ($cart){
            return $cart['product']->price * $cart['quantity'];
        });
        $cart_data = $cart_list->mapWithKeys(function ($cart){
            return [ $cart['product']->id => [ 'quantity'=> $cart['quantity'] ] ];
        });

        $order = auth()->user()->orders()->create([
            'price'=> $price,
            'status'=> Order::$STATUS_UNPAID
        ]);
        $order->products()->attach($cart_data);

    }
}
