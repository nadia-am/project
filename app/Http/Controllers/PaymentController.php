<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart_list = Cart::all();

        $price = $cart_list->sum(function ($cart){
//            return $cart['product']->price * $cart['quantity'];
            return ($cart['product']->price - ($cart['product']->price * $cart['discount_percent'])) * $cart['quantity'];
        });
        $cart_data = $cart_list->mapWithKeys(function ($cart){
            return [ $cart['product']->id => [ 'quantity'=> $cart['quantity'] ] ];
        });

        $order = auth()->user()->orders()->create([
            'price'=> $price,
            'status'=> Order::$STATUS_UNPAID
        ]);
        $order->products()->attach($cart_data);
        $res_num = Str::random();//send it to darga
// ------------------------------------------
//darga code
        $order->payments()->create([
            'resnumber'=>$res_num
        ]);
        Cart::flush();
//redirect to darga
        return redirect()->route('callback.payment', ['id'=>$res_num]);
    }

    public function callback($id)
    {
        //return data from data to handle it
        $payment = Payment::where('resnumber',$id)->firstOrFail();
        $payment->update([
            'status'=>1
        ]);
        $payment->order()->update([
            'status'=> Order::$STATUS_PAID
        ]);
        alert()->success('پرداخت با موفقعیت انجام شد.');
        return redirect(route('products.list'));


    }
}
