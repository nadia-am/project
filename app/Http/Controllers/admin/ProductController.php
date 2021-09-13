<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StorProductRequest;
use App\Http\Requests\admin\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller

{
    public function __construct()
    {
        $this->middleware('can:show-products')->only(['index']);
        $this->middleware('can:create-products')->only(['create','store']);
        $this->middleware('can:edit-products')->only(['edit' , 'update']);
        $this->middleware('can:delete-products')->only(['destroy']);
    }
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
    public function store(StorProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $product = auth()->user()->products()->save(new Product([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'inventory' => $request->inventory ? $request->inventory : 0,
                'image'=> $request->image
            ]));
            $this->saveProduct_attributeAndValue($request, $product);
            $product->categories()->sync($request->categories);
            alert()->success('افزودن با موفقیت انجام گرفت', 'عملیات موفق');
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }
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
     * @param UpdateProductRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $product->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'inventory' => $request->inventory ? $request->inventory : 0,
                'image' => $request->image,
            ]);

            $product->attributes()->detach();
            $this->saveProduct_attributeAndValue($request, $product);

            $product->categories()->sync($request->categories);
            DB::commit();
            alert()->success('ویرایش با موفقیت انجام گرفت', 'عملیات موفق');
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }

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

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     */
    protected function saveProduct_attributeAndValue( $request, Product $product)
    {
        $attributes = collect($request['attributes']) ;
        $attributes->each(function ($item) use ($product) {
            if (is_null($item['name']) || is_null($item['value'])) return;

            $attr = Attribute::firstOrCreate([
                'name' => $item['name']
            ]);
            $value = $attr->Values()->firstOrCreate([
                'value' => $item['value']
            ]);
            $product->attributes()->attach($attr->id, ['value_id' => $value->id]);
        });
    }
}
