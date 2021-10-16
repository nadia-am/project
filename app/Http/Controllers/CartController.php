<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product)
    {
        Cart::
        if (Cart::has($product)){
            $list = Cart::get($product);
            if ($product->inventory > $list['quantity']){
                Cart::update($product , 1);
            }
        }else{
            Cart::put(
                [
                    'quantity'=>1,
                ],
                $product
            );
        }
        alert()->info('محصول به سبد خرید اضافه شد');
        return back();
    }

    public function shoppingCart()
    {
        return view('home.cart');
    }

    public function quantityUpdate(Request $request)
    {
        $data = $request->validate([
            'id'=>'required',
            'quantity'=>'required',
        ]);
        if (Cart::has($data['id'])){
            Cart::update($data['id'] , [
                'quantity' => $data['quantity']
            ]);
            return response([
                'status'=>'success'
            ]);
        }
        return response([
            'status'=>'error',
            'message'=>'id of product not found'
        ],400);
    }

    public function deleteCart(Product $product)
    {
        Cart::delete($product);
        return back();
    }
}
