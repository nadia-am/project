<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('home.products',compact('products'));
    }

    public function single(Product $product)
    {
//        $comments = sort_comments($product->comments , 0);
        return view('home.product',compact(['product' ]));
    }
}
