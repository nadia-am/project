<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\storProductRequest;
use App\Http\Requests\admin\updateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query();
        if ($key = request('search')){
            $products = $products->where('title','like', "%{$key}%")
                ->orWhere('description','like', "%{$key}%")
                ->orWhere('id','like', "%{$key}%");
        }
        $products = $products->latest()->paginate(10);
        return view('admin.products.all' , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storProductRequest $request)
    {
        auth()->user()->products()->save(new Product([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'inventory' => $request->inventory ? $request->inventory : 0
        ]));
        alert()->success('افزودن با موفقیت انجام گرفت', 'عملیات موفق');
        return redirect(route('admin.products.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(updateProductRequest $request, Product $product)
    {
        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'inventory' => $request->inventory ? $request->inventory : 0
        ]);
        alert()->success('ویرایش با موفقیت انجام گرفت', 'عملیات موفق');
        return redirect(route('admin.products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        alert()->success('حذف با موفقیت انجام گرفت', 'عملیات موفق');
        return redirect(route('admin.products.index'));
    }
}