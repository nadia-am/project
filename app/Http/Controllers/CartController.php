<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product)
    {
//        dd(collect(Cart::get($product))->toArray());
        if (Cart::has($product)){
            $list = Cart::get($product,false);
            if ($product->inventory < $list['quantity']){
                Cart::update($list , 1);
            }
        }else{
            Cart::put(
                [
                    'quantity'=>1,
                    'price'=> $product->price
                ],
                $product
            );
        }
        alert()->info('محصول به سبد خرید اضافه شد');
        return back();
    }

    public function shoppingCart()
    {
//        return Cart::all();
        return view('home.cart');
    }
}
