<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product)
    {
        if (! Cart::has($product)){
            Cart::put(
                [
                    'quantity'=>200,
                    'price'=> $product->price
                ],
                $product
            );
        }

        return session()->get('cart');
    }
}
