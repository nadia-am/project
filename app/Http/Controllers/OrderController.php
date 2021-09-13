<?php

namespace App\Http\Controllers;

use App\Http\Requests\profile\PaymentOrderRequset;
use App\Http\Requests\profile\ShowOrderRequset;
use App\Models\Order;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate();
        return view('profile.orders',compact('orders'));
    }

    public function single(ShowOrderRequset $requset, Order $order)
    {
        return view('profile.order',compact('order'));

    }

    public function payment(PaymentOrderRequset $requset , Order $order)
    {
        $res_num = Str::random();//send it to darga
        $order->payments()->create([
            'resnumber'=>$res_num
        ]);
//redirect to darga
        return redirect()->route('callback.payment', ['id'=>$res_num]);

    }
}
