<?php

namespace Modules\Discount\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Discount\Entities\Discount;
use Modules\Discount\Http\Requests\CreateDiscountRequest;
use Modules\Discount\Http\Requests\UpdateDiscountRequest;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-discounts')->only(['index']);
        $this->middleware('can:create-discounts')->only(['create','store']);
        $this->middleware('can:edit-discounts')->only(['edit' , 'update']);
        $this->middleware('can:delete-discounts')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $discounts = Discount::query();
        if ($key = \request('search')){
            $discounts = $discounts->where('name','like',"%{$key}%")
                ->orWhereHas('products', function (Builder $query) use($key){
                    $query->where('title', 'like', "%{$key}%");
                })
                ->orWhereHas('categories', function (Builder $query) use($key){
                    $query->where('name', 'like', "%{$key}%");
                });
        }
        $discounts = $discounts->latest()->paginate(20);
        return view('discount::admin.all' , compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('discount::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return void
     */
    public function store(CreateDiscountRequest $request)
    {
        $users =  json_encode($request->users);
        $discount = Discount::create([
            'code'=> $request->code,
            'percent'=> $request->percent,
            'expired_at'=> $request->expired_at
        ]);
        $discount->products()->sync($request->products);
        $discount->categories()->sync($request->categories);
        $discount->users()->sync($request->users);
        alert()->success('???????????? ???? ???????????? ?????????? ????????', '???????????? ????????');
        return redirect(route('admin.discount.index'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Discount $discount
     * @return Renderable
     */
    public function edit(Discount $discount)
    {
        return view('discount::admin.edit',compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Discount $discount
     * @return void
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $users =  json_encode($request->users);
        $discount->update([
            'code'=> $request->code,
            'percent'=> $request->percent,
            'expired_d'=> $request->expired_at
        ]);
        $discount->products()->sync($request->products);
        $discount->categories()->sync($request->categories);
        $discount->users()->sync($request->users);
        alert()->success('???????????? ???? ???????????? ?????????? ????????', '???????????? ????????');
        return redirect(route('admin.discount.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Discount $discount
     * @return void
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        alert()->success('?????? ???? ???????????? ?????????? ????????', '???????????? ????????');
        return redirect(route('admin.discount.index'));
    }
}
