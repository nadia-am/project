<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\gallery\CreateGalleryRequest;
use App\Http\Requests\gallery\EditGalleryRequest;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $galleries = $product->galleries()->latest()->paginate(20);
        return  view('admin.products.galleries.all' ,compact(['product','galleries']) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('admin.products.galleries.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateGalleryRequest $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGalleryRequest $request , Product $product)
    {
        try {
            DB::beginTransaction();
            $images_list =  collect($request->images);
            $images_list->each(function ($image) use($product){
                $product->galleries()->create($image);
            });
            DB::commit();
            alert()->success('افزودن با موفقیت انجام گرفت', 'عملیات موفق');
        }catch (\Exception $e){
            DB::rollBack();
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }

        return redirect(route('admin.products.galleries.index' ,$product->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @param ProductGallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(  Product $product , ProductGallery $gallery)
    {
        return view('admin.products.galleries.edit',compact(['product', 'gallery']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditGalleryRequest $request
     * @param Product $product
     * @param ProductGallery $image
     * @return \Illuminate\Http\Response
     */
    public function update(EditGalleryRequest  $request, Product $product  , ProductGallery $gallery)
    {
        try {
            $gallery->update([
                'image'=>$request->image,
                'alt'=>$request->alt
            ]);
            alert()->success('ویرایش با موفقیت انجام گرفت', 'عملیات موفق');
        }catch (\Exception $e){
            Log::error($e);
            alert()->success('خطایی رخ داد، مجددا تلاش کنید', 'عملیات ناموفق');
        }

        return redirect(route('admin.products.galleries.index' ,$product->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param ProductGallery $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product , ProductGallery $gallery)
    {
        $gallery->delete();
        alert()->success('حذف با موفقیت انجام گرفت', 'عملیات موفق');
        return redirect(route('admin.products.galleries.index' ,$product->id));
    }
}
