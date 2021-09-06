<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\updateOrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::query();
        if ($key = \request('search')){
            $order = $order->where('id','like',"%{$key}%")->orWhere('tracing_serial','like',"%{$key}%");
        }
        $orders = $order->where('status','=',\request('type'))->latest()->paginate(20);
        return view('admin.orders.all',compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $products = $order->products()->withPivot('quantity')->paginate(20);
        return view('admin.orders.detail' , compact(['order','products']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit' , compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(updateOrderRequest $request, Order $order)
    {
        $order->update([
            'status'=>$request->status,
            'tracing_serial'=>$request->tracing_serial
        ]);
        alert()->success('ویرایش با موفقیت انجام گرفت', 'عملیات موفق');
        return redirect(route('admin.orders.index',['type'=> $order->status]));
    }

    public function payments(Order $order)
    {
        $payments = $order->payments()->latest()->paginate(20);
        return view('admin.orders.payment' ,compact(['payments','order']));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        alert()->success('حذف با موفقیت انجام گرفت', 'عملیات موفق');
        return back();
    }
}
